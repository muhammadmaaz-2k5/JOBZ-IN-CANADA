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
        $cachedData = \Illuminate\Support\Facades\Cache::remember("dashboard:admin", now()->addMinutes(5), function () {
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

            $recentAudits = AuditLog::with('user')->latest()->take(5)->get();

            return compact('metrics', 'recentAudits');
        });

        return view('dashboard.admin', $cachedData);
    }

    public function employer()
    {
        $user = Auth::user();
        $userId = $user->id;

        $cachedData = \Illuminate\Support\Facades\Cache::remember("dashboard:employer:{$userId}", now()->addMinutes(5), function () use ($userId) {
            $user = User::find($userId);
            $employerProfile = $user->employerProfile()->with('company')->first();
            $company = $employerProfile ? $employerProfile->company : null;

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

            $recentApplications = Application::with(['job', 'applicant.jobSeekerProfile'])
                ->whereHas('job', fn($q) => $q->where('employer_id', $user->id))
                ->latest('applied_at')
                ->take(5)
                ->get();

            $jobPerformance = Job::where('employer_id', $user->id)
                ->withCount('savedByUsers')
                ->latest()
                ->get();

            $statusData = Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $weeklyApplications = [];
            for ($i = 3; $i >= 0; $i--) {
                $start = now()->subWeeks($i)->startOfWeek();
                $end = now()->subWeeks($i)->endOfWeek();
                $count = Application::whereHas('job', fn($q) => $q->where('employer_id', $user->id))
                    ->whereBetween('applied_at', [$start, $end])
                    ->count();
                $weeklyApplications["Week " . (4 - $i)] = $count;
            }

            $reviewsCount = $company ? $company->reviews()->count() : 0;
            $averageRating = $company ? $company->reviews()->avg('rating') : 0;

            return compact(
                'employerProfile',
                'metrics',
                'recentApplications',
                'jobPerformance',
                'statusData',
                'weeklyApplications',
                'reviewsCount',
                'averageRating'
            );
        });

        return view('dashboard.employer', $cachedData);
    }

    public function seeker()
    {
        $user = Auth::user();
        $userId = $user->id;

        $cachedData = \Illuminate\Support\Facades\Cache::remember("dashboard:seeker:{$userId}", now()->addMinutes(5), function () use ($userId) {
            $user = User::find($userId);
            $seekerProfile = $user->jobSeekerProfile()->first();

            $metrics = [
                'applied' => Application::where('applicant_id', $user->id)->where('status', '!=', 'withdrawn')->count(),
                'saved' => $user->savedJobs()->count(),
                'interviews' => Application::where('applicant_id', $user->id)->whereIn('status', ['interview_scheduled', 'interview_completed'])->count(),
                'follows' => $user->companyFollowings()->count(),
                'alerts' => $user->jobAlerts()->count(),
                'profile_completion' => $seekerProfile ? $seekerProfile->calculateCompletionPercentage() : 0,
            ];

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

            $recentApplications = Application::with('job.company')
                ->where('applicant_id', $user->id)
                ->latest('applied_at')
                ->take(5)
                ->get();

            $savedJobs = $user->savedJobs()->with('company')->latest()->take(5)->get();

            $timeline = AuditLog::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $alerts = $user->jobAlerts()->with('category')->get();
            $categories = Category::whereNull('parent_id')->get();
            $notifications = $user->notifications()->latest()->take(5)->get();

            return compact(
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
            );
        });

        return view('dashboard.seeker', $cachedData);
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

    /**
     * Display the in-app chat messaging interface.
     */
    public function messages()
    {
        return view('messages.index');
    }
}
