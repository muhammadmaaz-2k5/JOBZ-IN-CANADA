<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Exception;

class FirebaseAuthController extends Controller
{
    /**
     * Handle the Firebase login callback.
     */
    public function callback(Request $request)
    {
        $idToken = $request->input('idToken');

        if (!$idToken) {
            return response()->json(['error' => 'No ID token provided.'], 400);
        }

        try {
            $auth = Firebase::auth();
            // Verify the ID token
            $verifiedIdToken = $auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            
            // Get user details from Firebase
            $firebaseUser = $auth->getUser($uid);
            
            $email = $firebaseUser->email;
            $displayName = $firebaseUser->displayName ?? '';
            
            if (!$email) {
                return response()->json(['error' => 'Email not provided by Firebase.'], 400);
            }

            // Split display name into first and last name
            $nameParts = explode(' ', $displayName);
            $firstName = $nameParts[0] ?? 'User';
            $lastName = count($nameParts) > 1 ? end($nameParts) : '';

            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'role' => 'seeker', // Defaulting to seeker
                    'email_verified_at' => now(), // Assume Google/Firebase verified it
                    'password' => bcrypt(\Illuminate\Support\Str::random(24)), // Random password since using Firebase
                ]
            );

            // Log the user in
            Auth::login($user, true);

            // Redirect appropriately based on role
            $redirectUrl = $user->role === 'employer' ? route('employer.dashboard') : route('dashboard');

            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Authentication failed: ' . $e->getMessage()], 401);
        }
    }
}
