<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Company $company)
    {
        $user = auth()->user();
        if ($user && $user->role === 'employer' && $user->employerProfile && $user->employerProfile->company_id === $company->id) {
            return back()->with('error', 'You cannot review your own company.');
        }
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string|min:10',
        ]);

        $company->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'review' => $validated['review'],
        ]);

        return back()->with('status', 'Review submitted successfully!');
    }
}
