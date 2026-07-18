<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('employer')) {
            $employerProfile = $user->employerProfile()->with('company')->first();
            
            if (!$employerProfile || !$employerProfile->company || $employerProfile->company->verification_status !== 'verified') {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Your company profile is not verified yet.'], 403);
                }

                return redirect()->route('employer.dashboard')->with('warning', 'Your company profile must be verified before you can access this feature.');
            }
        }

        return $next($request);
    }
}
