<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Setup base query, only retrieve published listings
        $query = Job::with(['company', 'category', 'skills'])
            ->where('status', 'published');

        // Apply advanced search filter scope
        $query->filter($request->all());

        // Apply Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'salary_desc':
                $query->orderByRaw('CAST(salary_max AS UNSIGNED) DESC');
                break;
            case 'salary_asc':
                $query->orderByRaw('CAST(salary_min AS UNSIGNED) ASC');
                break;
            case 'closing_soon':
                $query->whereNotNull('application_deadline')
                      ->where('application_deadline', '>=', now())
                      ->orderBy('application_deadline', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('views_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $startTime = microtime(true);
        $jobs = $query->paginate(10)->withQueryString();
        $endTime = microtime(true);
        $searchTimeMs = round(($endTime - $startTime) * 1000);

        // Store Search Query Analytics
        if ($request->filled('keyword') || $request->filled('location') || count($request->except(['page', 'sort']))) {
            \App\Models\SearchQuery::create([
                'query_string' => $request->get('keyword'),
                'filters' => $request->except(['page', 'sort', 'keyword']),
                'results_count' => $jobs->total(),
                'search_time_ms' => $searchTimeMs,
                'user_id' => Auth::id(),
            ]);

            // Save recent search in session
            if ($request->filled('keyword')) {
                $recentSearches = session()->get('recent_searches', []);
                $searchItem = [
                    'keyword' => $request->get('keyword'),
                    'location' => $request->get('location'),
                    'url' => $request->fullUrl()
                ];
                $recentSearches = array_filter($recentSearches, fn($item) => $item['keyword'] !== $searchItem['keyword']);
                array_unshift($recentSearches, $searchItem);
                session()->put('recent_searches', array_slice($recentSearches, 0, 5));
            }
        }

        // Fetch recently viewed jobs details
        $recentlyViewedIds = session()->get('recently_viewed_jobs', []);
        $recentlyViewed = [];
        if (count($recentlyViewedIds) > 0) {
            $recentlyViewed = Job::whereIn('id', $recentlyViewedIds)
                ->where('status', 'published')
                ->with('company')
                ->get()
                ->sortBy(fn($j) => array_search($j->id, $recentlyViewedIds));
        }

        // Get filter inputs for display/checked states
        $parentCategories = Category::whereNull('parent_id')->with('children')->get();
        $popularSkills = Skill::take(10)->get();

        return view('jobs.index', compact('jobs', 'parentCategories', 'popularSkills', 'recentlyViewed'));
    }

    public function show($slug)
    {
        $job = Job::with(['company', 'category', 'skills', 'employer'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment Views Count
        $job->increment('views_count');

        // Track Viewed Job in Session
        $viewed = session()->get('recently_viewed_jobs', []);
        if (!in_array($job->id, $viewed)) {
            array_unshift($viewed, $job->id);
            session()->put('recently_viewed_jobs', array_slice($viewed, 0, 5));
        }

        // Related jobs query (recommend jobs in same category or company, excluding current)
        $relatedJobs = Job::where('status', 'published')
            ->where('id', '!=', $job->id)
            ->where(fn ($q) => $q->where('category_id', $job->category_id)->orWhere('company_id', $job->company_id))
            ->latest()
            ->take(3)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }

    public function clearSearchHistory()
    {
        session()->forget('recent_searches');
        return redirect()->back()->with('success', 'Search history cleared.');
    }

    public function clearViewedHistory()
    {
        session()->forget('recently_viewed_jobs');
        return redirect()->back()->with('success', 'View history cleared.');
    }

    public function toggleSave($id)
    {
        $user = Auth::user();
        $job = Job::findOrFail($id);

        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
            $user->savedJobs()->detach($job->id);
            $message = 'Job removed from saved list.';
            $action = 'job_unsaved';
        } else {
            $user->savedJobs()->attach($job->id);
            $message = 'Job saved successfully.';
            $action = 'job_saved';
        }

        \App\Helpers\AuditLogHelper::log($user->id, $action, "Candidate toggled bookmark on job ID {$job->id}");

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'saved' => $user->savedJobs()->where('job_id', $job->id)->exists()
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
