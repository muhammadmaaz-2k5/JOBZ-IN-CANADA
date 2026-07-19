<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateSearchAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        if ($user && $user->hasRole('employer')) {
            $sub = $user->activeSubscription;
            
            if ($sub && $sub->isValid() && $sub->plan && $sub->plan->candidate_search) {
                return $next($request);
            }
        }

        abort(403, 'Candidate search is a premium feature. Please upgrade your subscription plan.');
    }
}
