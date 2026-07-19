<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchSuggestionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // Match Job Titles
        $jobTitles = Job::where('status', 'published')
            ->where('title', 'like', "%{$query}%")
            ->distinct()
            ->take(5)
            ->pluck('title')
            ->map(fn($t) => ['type' => 'job_title', 'text' => $t]);
        $suggestions = array_merge($suggestions, $jobTitles->toArray());

        // Match Company Names
        $companies = Company::where('company_name', 'like', "%{$query}%")
            ->where('verification_status', 'verified')
            ->take(3)
            ->pluck('company_name')
            ->map(fn($c) => ['type' => 'company', 'text' => $c]);
        $suggestions = array_merge($suggestions, $companies->toArray());

        // Match Skills
        $skills = Skill::where('name', 'like', "%{$query}%")
            ->take(3)
            ->pluck('name')
            ->map(fn($s) => ['type' => 'skill', 'text' => $s]);
        $suggestions = array_merge($suggestions, $skills->toArray());

        // Match Categories
        $categories = Category::where('name', 'like', "%{$query}%")
            ->take(3)
            ->pluck('name')
            ->map(fn($cat) => ['type' => 'category', 'text' => $cat]);
        $suggestions = array_merge($suggestions, $categories->toArray());

        // Match Locations (Cities)
        $locations = Job::where('status', 'published')
            ->where(fn($q) => $q->where('city', 'like', "%{$query}%")->orWhere('country', 'like', "%{$query}%"))
            ->distinct()
            ->take(3)
            ->pluck('city')
            ->map(fn($loc) => ['type' => 'location', 'text' => $loc]);
        $suggestions = array_merge($suggestions, $locations->toArray());

        return response()->json($suggestions);
    }
}
