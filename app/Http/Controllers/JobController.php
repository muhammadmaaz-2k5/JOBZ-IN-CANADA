<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

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

        $jobs = $query->paginate(10)->withQueryString();

        // Get filter inputs for display/checked states
        $parentCategories = Category::whereNull('parent_id')->with('children')->get();
        $popularSkills = Skill::take(10)->get();

        return view('jobs.index', compact('jobs', 'parentCategories', 'popularSkills'));
    }

    public function show($slug)
    {
        $job = Job::with(['company', 'category', 'skills', 'employer'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment Views Count
        $job->increment('views_count');

        // Related jobs query (recommend jobs in same category or company, excluding current)
        $relatedJobs = Job::where('status', 'published')
            ->where('id', '!=', $job->id)
            ->where(function ($q) use ($job) {
                $q->where('category_id', $job->category_id)
                  ->orWhere('company_id', $job->company_id);
            })
            ->latest()
            ->take(3)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }
}
