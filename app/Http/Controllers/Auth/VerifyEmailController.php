<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified using OTP.
     */
    public function verify(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        $request->validate([
            'code' => 'required|numeric'
        ]);

        $cachedCode = Cache::get('email_verification_' . $request->user()->id);

        if ($cachedCode && $cachedCode == $request->code) {
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
                Cache::forget('email_verification_' . $request->user()->id);
            }
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
    }
}
