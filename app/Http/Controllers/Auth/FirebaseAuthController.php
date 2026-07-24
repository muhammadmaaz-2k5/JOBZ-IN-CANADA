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
        $requestedRole = $request->input('role');

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

            $validRoles = ['job_seeker', 'employer'];
            $defaultRole = in_array($requestedRole, $validRoles) ? $requestedRole : 'job_seeker';

            // Find or create user
            $user = clone User::firstOrCreate(
                ['email' => $email],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'role' => $defaultRole, // Dynamic default based on request
                    'email_verified_at' => now(),
                    'password' => bcrypt(\Illuminate\Support\Str::random(24)),
                ]
            );

            // If the user already existed but they clicked a specific role button, update their role.
            if ($user->role !== $defaultRole && in_array($defaultRole, $validRoles)) {
                $user->role = $defaultRole;
                $user->save();
            }

            // Fix the role string if it was previously set incorrectly
            if ($user->role === 'seeker') {
                $user->role = 'job_seeker';
                $user->save();
            }

            // Sync Spatie role to ensure they only have the active role
            $user->syncRoles([$user->role]);

            // Log the user in
            Auth::login($user, true);

            // Redirect appropriately based on role
            $redirectUrl = $user->role === 'employer' ? route('employer.dashboard') : route('dashboard');

            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ]);

        } catch (\Throwable $e) {
            return response()->json(['error' => 'Authentication failed: ' . $e->getMessage()], 401);
        }
    }
}
