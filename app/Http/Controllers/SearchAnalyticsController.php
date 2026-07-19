<?php

namespace App\Http\Controllers;

use App\Models\SearchQuery;
use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Top Search Keywords
        $topKeywords = SearchQuery::select('query_string', DB::raw('count(*) as count'))
            ->whereNotNull('query_string')
            ->where('query_string', '!=', '')
            ->groupBy('query_string')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        // Zero-Result Searches
        $zeroResults = SearchQuery::select('query_string', DB::raw('count(*) as count'))
            ->where('results_count', 0)
            ->whereNotNull('query_string')
            ->groupBy('query_string')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        // Average Search Time
        $avgSearchTime = SearchQuery::avg('search_time_ms') ?? 0;

        // Top Applied Jobs
        $mostApplied = Job::orderByDesc('applications_count')->take(5)->get();

        // Top Viewed Jobs
        $mostViewed = Job::orderByDesc('views_count')->take(5)->get();

        // Search Queries log
        $recentQueries = SearchQuery::with('user')->latest()->paginate(15);

        return view('admin.search_analytics', compact(
            'topKeywords',
            'zeroResults',
            'avgSearchTime',
            'mostApplied',
            'mostViewed',
            'recentQueries'
        ));
    }
}
