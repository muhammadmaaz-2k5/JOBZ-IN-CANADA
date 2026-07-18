<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use App\Models\JobAlert;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('employer')) {
            return redirect()->route('employer.dashboard');
        }

        return redirect()->route('seeker.dashboard');
    }

    public function admin()
    {
        // Platform overview metrics for Admin Dashboard
        $metrics = [
            'total_users' => User::count(),
            'seekers_count' => User::role('job_seeker')->count(),
            'employers_count' => User::role('employer')->count(),
            'active_jobs' => Job::where('status', 'published')->count(),
            'pending_jobs' => Job::where('status', 'draft')->count(),
            'applications_count' => Application::count(),
            'companies_count' => Company::count(),
            'reports_count' => \App\Models\JobReport::where('status', 'pending')->count(),
        ];

        // Fetch recent audits and logs
        $recentAudits = AuditLog::with('user')->latest()->take(5)->get();

        return view('dashboard.admin', compact('metrics', 'recentAudits'));
    }

    public function employer()
    {
        $user = Auth::user();
        $employerProfile = $user->employerProfile()->with('company')->first();
        $company = $employerProfile ? $employerProfile->company : null;

        // Insights summary metrics
        $metrics = [
            'active_jobs' => Job::where('employer_id', $user->id)->where('status', 'published')->count(),
            'draft_jobs' => Job::where('employer_id', $user->id)->where('status', 'draft')->count(),
            'closed_jobs' => Job::where('employer_id', $user->id)->where('status', 'closed')->count(),
            'total_applications' => Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))->count(),
            'interviews_scheduled' => Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))->where('status', 'interview_scheduled')->count(),
            'candidates_hired' => Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))->where('status', 'hired')->count(),
            'followers_count' => $company ? $company->followers()->count() : 0,
            'total_views' => Job::where('employer_id', $user->id)->sum('views_count'),
        ];

        // Recent applications list
        $recentApplications = Application::with(['job', 'applicant.jobSeekerProfile'])
            ->whereHas('job', fn($q) => $q->where('employer_id', $user->id))
            ->latest('applied_at')
            ->take(5)
            ->get();

        // Job Performance list
        $jobPerformance = Job::where('employer_id', $user->id)
            ->withCount('savedByUsers')
            ->latest()
            ->get();

        // Group status data for Chart
        $statusData = Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Weekly applications data (last 4 weeks)
        $weeklyApplications = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();
            $count = Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))
                ->whereBetween('applied_at', [$start, $end])
                ->count();
            $weeklyApplications["Week " . (4 - $i)] = $count;
        }

        // Reviews analytics
        $reviewsCount = $company ? $company->reviews()->count() : 0;
        $averageRating = $company ? $company->reviews()->avg('rating') : 0;

        return view('dashboard.employer', compact(
            'employerProfile', 
            'metrics', 
            'recentApplications', 
            'jobPerformance', 
            'statusData', 
            'weeklyApplications', 
            'reviewsCount', 
            'averageRating'
        ));
    }

    public function seeker()
    {
        $user = Auth::user();
        $seekerProfile = $user->jobSeekerProfile()->first();

        // Statistics cards
        $metrics = [
            'applied' => Application::where('applicant_id', $user->id)->where('status', '!=', 'withdrawn')->count(),
            'saved' => $user->savedJobs()->count(),
            'interviews' => Application::where('applicant_id', $user->id)->whereIn('status', ['interview_scheduled', 'interview_completed'])->count(),
            'follows' => $user->companyFollowings()->count(),
            'alerts' => $user->jobAlerts()->count(),
            'profile_completion' => $seekerProfile ? $seekerProfile->calculateCompletionPercentage() : 0,
        ];

        // Improve profile suggestions
        $suggestions = [];
        if (!$seekerProfile || empty($seekerProfile->headline)) {
            $suggestions[] = 'Add a professional headline';
        }
        if (!$seekerProfile || empty($seekerProfile->summary)) {
            $suggestions[] = 'Write a short professional summary';
        }
        if (!$user->resumes()->exists()) {
            $suggestions[] = 'Upload your resume';
        }
        if (!$user->experiences()->exists()) {
            $suggestions[] = 'Add your work experience';
        }
        if (!$user->education()->exists()) {
            $suggestions[] = 'Add your education history';
        }
        if (!$user->skills()->exists()) {
            $suggestions[] = 'Select your core skills';
        }
        if (!$user->projects()->exists()) {
            $suggestions[] = 'Add projects you have completed';
        }

        // Skill-based job recommendations
        $userSkills = $user->skills()->pluck('skills.id');
        $recommendedJobs = Job::with('company')
            ->where('status', 'published')
            ->where(function ($q) use ($userSkills) {
                if ($userSkills->isNotEmpty()) {
                    $q->whereHas('skills', fn($sk) => $sk->whereIn('skills.id', $userSkills));
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // Recent applications list
        $recentApplications = Application::with('job.company')
            ->where('applicant_id', $user->id)
            ->latest('applied_at')
            ->take(5)
            ->get();

        // Bookmarked saved jobs list
        $savedJobs = $user->savedJobs()->with('company')->latest()->take(5)->get();

        // Timelines from user audit logs
        $timeline = AuditLog::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Job alerts list
        $alerts = $user->jobAlerts()->with('category')->get();

        // Categories list for alerts creation dropdown
        $categories = Category::whereNull('parent_id')->get();

        // Recent notifications
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('dashboard.seeker', compact(
            'seekerProfile', 
            'metrics', 
            'suggestions', 
            'recommendedJobs', 
            'recentApplications', 
            'savedJobs', 
            'timeline', 
            'alerts',
            'categories',
            'notifications'
        ));
    }

    public function storeAlert(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'remote' => ['nullable', 'boolean'],
            'frequency' => ['required', 'string', 'in:daily,weekly'],
        ]);

        Auth::user()->jobAlerts()->create([
            'keyword' => $request->keyword,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'salary_min' => $request->salary_min,
            'remote' => $request->has('remote') || $request->remote == '1',
            'frequency' => $request->frequency,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'job_alert_created',
            'description' => "Created a job alert for: {$request->keyword}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Job alert created successfully.');
    }

    public function destroyAlert($id)
    {
        $alert = Auth::user()->jobAlerts()->findOrFail($id);
        $keyword = $alert->keyword;
        $alert->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'job_alert_deleted',
            'description' => "Deleted job alert for: {$keyword}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Job alert deleted.');
    }
}
