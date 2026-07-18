<?php

namespace App\Http\Controllers;

use App\Helpers\AuditLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        
        // Retrieve active database sessions (excluding current session)
        $sessions = [];
        if (config('session.driver') === 'database') {
            $sessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $request->session()->getId())
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'ip_address' => $session->ip_address,
                        'user_agent' => $session->user_agent,
                        'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    ];
                });
        }

        return view('profile.settings', compact('user', 'sessions'));
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        // Terminate other sessions
        Auth::logoutOtherDevices($request->password);

        // Delete database records if session driver is database
        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', Auth::id())
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        AuditLogHelper::log(Auth::id(), 'logout_other_devices', 'User logged out other devices.');

        return redirect()->route('settings.edit')->with('success', 'Logged out of other devices successfully.');
    }

    public function downloadGdprData()
    {
        $user = Auth::user();
        $user->load([
            'jobSeekerProfile', 'employerProfile.company', 'resumes', 'experiences', 
            'education', 'certifications', 'projects', 'skills'
        ]);

        $data = [
            'personal_information' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'country' => $user->country,
                'city' => $user->city,
                'status' => $user->status,
                'registered_at' => $user->created_at->toIso8601String(),
            ],
            'job_seeker_profile' => $user->jobSeekerProfile,
            'employer_profile' => $user->employerProfile,
            'resumes' => $user->resumes->map(fn($r) => [
                'title' => $r->title,
                'original_name' => $r->original_name,
                'file_size_bytes' => $r->file_size,
                'uploaded_at' => $r->created_at->toIso8601String(),
            ]),
            'experiences' => $user->experiences,
            'education' => $user->education,
            'certifications' => $user->certifications,
            'projects' => $user->projects,
            'skills' => $user->skills->map(fn($s) => [
                'name' => $s->name,
                'experience_years' => $s->pivot->experience_years,
                'proficiency' => $s->pivot->proficiency,
            ]),
        ];

        AuditLogHelper::log($user->id, 'gdpr_export', 'User downloaded personal GDPR data.');

        $filename = 'gdpr-data-' . Str::slug($user->first_name . '-' . $user->last_name) . '-' . date('Y-m-d') . '.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function deactivateAccount(Request $request)
    {
        $request->validate([
            'deactivate_password' => ['required', 'string', 'current_password'],
        ]);

        $user = Auth::user();

        AuditLogHelper::log($user->id, 'account_deactivated', 'User deactivated/soft deleted their account.');

        // Soft delete the user model
        $user->update(['status' => 'inactive']);
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Your account has been deactivated successfully.');
    }
}
