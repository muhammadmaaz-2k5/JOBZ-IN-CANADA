<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationPreferenceController extends Controller
{
    public function edit()
    {
        $preferences = Auth::user()->notificationPreferences ?? Auth::user()->notificationPreferences()->create();
        return view('profile.notifications', compact('preferences'));
    }

    public function update(Request $request)
    {
        $preferences = Auth::user()->notificationPreferences ?? Auth::user()->notificationPreferences()->create();

        $preferences->update([
            'email_enabled' => $request->has('email_enabled'),
            'push_enabled' => $request->has('push_enabled'),
            'in_app_enabled' => $request->has('in_app_enabled'),
            'job_alerts' => $request->has('job_alerts'),
            'application_updates' => $request->has('application_updates'),
            'marketing_emails' => $request->has('marketing_emails'),
        ]);

        return redirect()->route('profile.notifications.edit')->with('success', 'Notification preferences updated successfully.');
    }
}
