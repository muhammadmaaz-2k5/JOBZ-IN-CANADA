<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileCompletedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('job_seeker')) {
            $seekerProfile = $user->jobSeekerProfile()->first();
            
            if (!$seekerProfile || $seekerProfile->profile_completion < 20) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Please complete at least 20% of your profile before performing this action.'], 403);
                }

                return redirect()->route('seeker.dashboard')->with('warning', 'Please complete at least 20% of your profile (including uploading a resume) before performing this action.');
            }
        }

        return $next($request);
    }
}
