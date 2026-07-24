<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Resume;
use App\Models\Application;
use App\Models\ScreeningQuestion;
use App\Models\ScreeningAnswer;
use App\Models\ApplicationStatusHistory;
use App\Notifications\ApplicationNotifications;
use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function showApplyForm($slug)
    {
        $job = Job::with('screeningQuestions')->where('slug', $slug)->firstOrFail();

        // 1. Check if already applied
        $existing = Application::where('job_id', $job->id)
            ->where('applicant_id', Auth::id())
            ->where('status', '!=', 'withdrawn')
            ->first();

        if ($existing) {
            return redirect()->route('jobs.show', $job->slug)->with('warning', 'You have already applied for this job.');
        }

        // 2. Check if closed
        if ($job->status === 'closed' || ($job->application_deadline && \Carbon\Carbon::parse($job->application_deadline)->isPast())) {
            return redirect()->route('jobs.show', $job->slug)->with('warning', 'This job listing is closed.');
        }

        $resumes = Resume::where('user_id', Auth::id())->get();

        return view('jobs.apply', compact('job', 'resumes'));
    }

    public function submitApplication(Request $request, $slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Profile completeness check (min 20%)
        $profile = $user->jobSeekerProfile()->first();
        $completeness = $profile ? $profile->calculateCompletionPercentage() : 0;
        if ($completeness < 20) {
            return redirect()->route('seeker.profile.edit')->with('warning', 'Please complete at least 20% of your profile before applying to jobs.');
        }

        // Validate
        $rules = [
            'resume_option' => ['required', 'string', 'in:library,new'],
            'cover_letter' => $job->resume_required ? ['nullable', 'string'] : ['nullable', 'string'],
        ];

        if ($request->resume_option === 'library') {
            $rules['resume_id'] = ['required', 'exists:resumes,id,user_id,' . $user->id];
        } else {
            $rules['resume_file'] = ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'];
            $rules['resume_title'] = ['required', 'string', 'max:255'];
        }

        // Validate screening questions answers
        foreach ($job->screeningQuestions as $q) {
            if ($q->is_required) {
                $rules["answers.{$q->id}"] = ['required', 'string'];
            } else {
                $rules["answers.{$q->id}"] = ['nullable', 'string'];
            }
        }

        $request->validate($rules);

        return DB::transaction(function () use ($request, $job, $user) {
            // Duplicate Check
            $existing = Application::where('job_id', $job->id)
                ->where('applicant_id', $user->id)
                ->where('status', '!=', 'withdrawn')
                ->lockForUpdate()
                ->first();

            if ($existing) {
                return redirect()->route('jobs.show', $job->slug)->with('warning', 'You have already applied for this job.');
            }

            // Save Resume if new upload
            if ($request->resume_option === 'new') {
                $file = $request->file('resume_file');
                $path = $file->store('resumes', 'private');
                $resume = Resume::create([
                    'user_id' => $user->id,
                    'title' => $request->resume_title,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'is_default' => Resume::where('user_id', $user->id)->count() === 0,
                ]);
                $resumeId = $resume->id;
            } else {
                $resumeId = $request->resume_id;
            }

            // Create Application
            $application = Application::create([
                'job_id' => $job->id,
                'applicant_id' => $user->id,
                'resume_id' => $resumeId,
                'cover_letter' => $request->cover_letter,
                'status' => 'applied',
                'applied_at' => now(),
            ]);

            // Save Answers
            if ($request->has('answers')) {
                foreach ($request->answers as $qId => $ansText) {
                    if ($ansText !== null) {
                        ScreeningAnswer::create([
                            'application_id' => $application->id,
                            'question_id' => $qId,
                            'answer' => $ansText,
                        ]);
                    }
                }
            }

            // Status History Log
            ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'previous_status' => null,
                'new_status' => 'applied',
                'changed_by' => $user->id,
                'remarks' => 'Application submitted by candidate.',
            ]);

            // Increment applications count
            $job->increment('applications_count');

            AuditLogHelper::log($user->id, 'job_applied', "Candidate applied to job: {$job->title}");

            // Notify Candidate
            ApplicationNotifications::send($user, 'submitted', [
                'applicant_name' => $user->first_name . ' ' . $user->last_name,
                'job_title' => $job->title,
                'company_name' => $job->company->company_name,
            ]);

            // Notify Employer
            $employer = $job->employer;
            if ($employer) {
                ApplicationNotifications::send($employer, 'employer_alert', [
                    'employer_name' => $employer->first_name . ' ' . $employer->last_name,
                    'applicant_name' => $user->first_name . ' ' . $user->last_name,
                    'job_title' => $job->title,
                ]);
            }

            return redirect()->route('seeker.applications.index')->with('success', 'Application submitted successfully.');
        });
    }

    public function seekerDashboard(Request $request)
    {
        $query = Application::with(['job.company', 'resume'])
            ->where('applicant_id', Auth::id());

        // Apply filters
        $filter = $request->get('filter', 'all');
        switch ($filter) {
            case 'active':
                $query->whereIn('status', ['applied', 'pending_review', 'shortlisted', 'offered']);
                break;
            case 'pending':
                $query->whereIn('status', ['applied', 'pending_review']);
                break;
            case 'shortlisted':
                $query->where('status', 'shortlisted');
                break;
            case 'offers':
                $query->where('status', 'offered');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
            case 'withdrawn':
                $query->where('status', 'withdrawn');
                break;
            case 'all':
            default:
                break;
        }

        $applications = $query->latest('applied_at')->paginate(10)->withQueryString();

        return view('seeker.applications.index', compact('applications', 'filter'));
    }

    public function show($id)
    {
        $application = Application::with(['job.company', 'resume', 'statusHistory.changer', 'screeningAnswers.question'])
            ->where('applicant_id', Auth::id())
            ->findOrFail($id);

        return view('seeker.applications.show', compact('application'));
    }

    public function withdraw($id)
    {
        $application = Application::where('applicant_id', Auth::id())
            ->whereNotIn('status', ['rejected', 'withdrawn', 'hired'])
            ->findOrFail($id);

        $prevStatus = $application->status;

        $application->update([
            'status' => 'withdrawn',
            'withdrawn_at' => now(),
        ]);

        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'previous_status' => $prevStatus,
            'new_status' => 'withdrawn',
            'changed_by' => Auth::id(),
            'remarks' => 'Application withdrawn by candidate.',
        ]);

        AuditLogHelper::log(Auth::id(), 'job_application_withdrawn', "Candidate withdrew application for job: {$application->job->title}");

        // Notify Employer
        $employer = $application->job->employer;
        if ($employer) {
            ApplicationNotifications::send($employer, 'withdrawn', [
                'employer_name' => $employer->first_name . ' ' . $employer->last_name,
                'applicant_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'job_title' => $application->job->title,
            ]);
        }

        return redirect()->route('seeker.applications.index')->with('success', 'Application withdrawn.');
    }

    public function downloadResume($id)
    {
        $application = Application::where('applicant_id', Auth::id())->findOrFail($id);
        $resume = $application->resume;

        if (!Storage::disk('private')->exists($resume->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('private')->download($resume->file_path, $resume->title);
    }
}
