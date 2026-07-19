<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\ApplicationNote;
use App\Models\ApplicationStatusHistory;
use App\Models\ResumeDownload;
use App\Notifications\ApplicationNotifications;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class EmployerApplicantController extends Controller
{
    private function getEmployerJobIds()
    {
        return Job::where('employer_id', Auth::id())->pluck('id')->toArray();
    }

    public function index(Request $request, $jobId = null)
    {
        $jobIds = $this->getEmployerJobIds();

        $query = Application::with(['job', 'applicant.jobSeekerProfile', 'resume'])
            ->whereIn('job_id', $jobIds);

        if ($jobId) {
            if (!in_array($jobId, $jobIds)) {
                abort(403, 'Unauthorized access to this job listing.');
            }
            $query->where('job_id', $jobId);
        }

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('applicant', function ($q) use ($search) {
                $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest('applied_at');
        } else {
            $query->latest('applied_at');
        }

        $applications = $query->paginate(15)->withQueryString();
        $jobsList = Job::where('employer_id', Auth::id())->get();

        return view('employer.applicants.index', compact('applications', 'jobsList', 'jobId'));
    }

    public function show($id)
    {
        $jobIds = $this->getEmployerJobIds();
        
        $application = Application::with([
            'job',
            'applicant.jobSeekerProfile',
            'applicant.education',
            'applicant.experiences',
            'applicant.certifications',
            'applicant.projects',
            'applicant.skills',
            'resume',
            'notes.employer',
            'statusHistory.changer',
            'screeningAnswers.question'
        ])
        ->whereIn('job_id', $jobIds)
        ->findOrFail($id);

        return view('employer.applicants.show', compact('application'));
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:applied,pending_review,shortlisted,interview_scheduled,interview_completed,offered,hired,rejected,withdrawn'],
            'remarks' => ['nullable', 'string'],
        ]);

        $jobIds = $this->getEmployerJobIds();
        $application = Application::with('job')->whereIn('job_id', $jobIds)->findOrFail($id);

        $prevStatus = $application->status;

        $application->update([
            'status' => $request->status,
        ]);

        // Status History Log
        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'previous_status' => $prevStatus,
            'new_status' => $request->status,
            'changed_by' => Auth::id(),
            'remarks' => $request->remarks ?? 'Status updated by employer.',
        ]);

        AuditLogHelper::log(Auth::id(), 'applicant_status_changed', "Changed applicant status to {$request->status} for job: {$application->job->title}");

        // Notify Candidate
        $candidate = $application->applicant;
        ApplicationNotifications::send($candidate, 'status_updated', [
            'applicant_name' => $candidate->first_name . ' ' . $candidate->last_name,
            'job_title' => $application->job->title,
            'company_name' => $application->job->company->company_name,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status changed successfully.',
                'status' => $request->status,
            ]);
        }

        return redirect()->back()->with('success', 'Candidate status updated.');
    }

    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => ['required', 'string'],
        ]);

        $jobIds = $this->getEmployerJobIds();
        $application = Application::whereIn('job_id', $jobIds)->findOrFail($id);

        ApplicationNote::create([
            'application_id' => $application->id,
            'employer_id' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Internal note added successfully.');
    }

    public function downloadResume($id)
    {
        $jobIds = $this->getEmployerJobIds();
        $application = Application::with(['job', 'resume'])->whereIn('job_id', $jobIds)->findOrFail($id);
        $resume = $application->resume;

        // Track download
        ResumeDownload::create([
            'employer_id' => Auth::id(),
            'candidate_id' => $application->applicant_id,
            'job_id' => $application->job_id,
            'downloaded_at' => now(),
        ]);

        // Notify Candidate
        $candidate = $application->applicant;
        ApplicationNotifications::send($candidate, 'resume_downloaded', [
            'applicant_name' => $candidate->first_name . ' ' . $candidate->last_name,
            'job_title' => $application->job->title,
            'company_name' => $application->job->company->company_name,
        ]);

        if ($resume->google_drive_file_id) {
            $driveService = app(\App\Services\Storage\StorageManager::class)->drive();
            $content = $driveService->downloadDocument($resume->google_drive_file_id);
            if (!$content) {
                abort(404, 'Resume file not found on Google Drive.');
            }
            return response($content, 200, [
                'Content-Type' => $resume->mime_type ?: 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $resume->original_name . '"',
            ]);
        }

        if (!Storage::disk('private')->exists($resume->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('private')->download($resume->file_path, $resume->title);
    }

    public function pipeline(Request $request, $jobId = null)
    {
        $jobIds = $this->getEmployerJobIds();
        
        $query = Application::with(['job', 'applicant.jobSeekerProfile', 'resume'])
            ->whereIn('job_id', $jobIds);

        if ($jobId) {
            if (!in_array($jobId, $jobIds)) {
                abort(403, 'Unauthorized access to this job listing.');
            }
            $query->where('job_id', $jobId);
        }

        $applications = $query->get();

        // Categorize into Kanban Columns
        $columns = [
            'applied' => $applications->where('status', 'applied'),
            'pending_review' => $applications->where('status', 'pending_review'),
            'shortlisted' => $applications->where('status', 'shortlisted'),
            'interview' => $applications->whereIn('status', ['interview_scheduled', 'interview_completed']),
            'offer' => $applications->where('status', 'offered'),
            'hired' => $applications->where('status', 'hired'),
            'rejected' => $applications->where('status', 'rejected'),
        ];

        $jobsList = Job::where('employer_id', Auth::id())->get();

        return view('employer.applicants.pipeline', compact('columns', 'jobsList', 'jobId'));
    }

    public function searchCandidates(Request $request)
    {
        $query = User::role('job_seeker')->with(['jobSeekerProfile', 'activeResumeBoost']);

        // Filters: Skills, Experience, Education, Location, Salary Expectation, Availability, Languages.
        if ($request->filled('keyword')) {
            $keyword = '%' . $request->keyword . '%';
            $query->where(function($q) use ($keyword) {
                $q->where('first_name', 'like', $keyword)
                  ->orWhere('last_name', 'like', $keyword)
                  ->orWhereHas('jobSeekerProfile', function($p) use ($keyword) {
                      $p->where('headline', 'like', $keyword)
                        ->orWhere('about_me', 'like', $keyword)
                        ->orWhere('skills', 'like', $keyword);
                  });
            });
        }

        if ($request->filled('location')) {
            $location = '%' . $request->location . '%';
            $query->whereHas('jobSeekerProfile', function($p) use ($location) {
                $p->where('city', 'like', $location)
                  ->orWhere('country', 'like', $location);
            });
        }

        // Apply ResumeBoost ranking sort (Boosted profiles first)
        $query->leftJoin('resume_boosts', function($join) {
            $join->on('users.id', '=', 'resume_boosts.user_id')
                 ->where('resume_boosts.expires_at', '>=', now());
        })
        ->select('users.*')
        ->orderByRaw('CASE WHEN resume_boosts.id IS NOT NULL THEN 0 ELSE 1 END ASC')
        ->orderBy('users.created_at', 'desc');

        $candidates = $query->paginate(10);

        return view('employer.candidates.search', compact('candidates'));
    }

    public function showCandidate($id)
    {
        $candidate = User::role('job_seeker')->with('jobSeekerProfile')->findOrFail($id);
        return view('employer.candidates.show', compact('candidate'));
    }

    public function downloadCandidateResume($id)
    {
        $candidate = User::role('job_seeker')->findOrFail($id);
        
        // Use resumes relationship
        $resume = $candidate->resumes()->where('is_default', true)->first() ?? $candidate->resumes()->first();

        if (!$resume || !Storage::disk('private')->exists($resume->file_path)) {
            abort(404, 'Resume not found for this candidate.');
        }

        // Track download
        ResumeDownload::create([
            'employer_id' => Auth::id(),
            'candidate_id' => $candidate->id,
            'downloaded_at' => now(),
        ]);

        return Storage::disk('private')->download($resume->file_path, $resume->title);
    }
}
