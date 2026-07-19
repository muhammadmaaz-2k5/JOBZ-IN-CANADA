<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Notification;
use App\Mail\ApplicationMail;
use Illuminate\Support\Facades\Mail;

class ApplicationNotifications
{
    /**
     * Dispatch an in-app and email notification to a user.
     *
     * @param User $recipient
     * @param string $type
     * @param array $data
     */
    public static function send(User $recipient, string $type, array $data)
    {
        $preferences = $recipient->notificationPreferences ?? $recipient->notificationPreferences()->create();

        // Check if target category is enabled
        $topicEnabled = true;
        if ($type === 'submitted' || $type === 'status_updated' || $type === 'resume_downloaded' || $type === 'employer_alert') {
            $topicEnabled = (bool)$preferences->application_updates;
        }

        $title = 'Job Application Update';
        $body = 'There is an update to your job application.';

        switch ($type) {
            case 'submitted':
                $title = 'Application Submitted';
                $body = "You successfully applied for {$data['job_title']} at {$data['company_name']}.";
                break;
            case 'employer_alert':
                $title = 'New Applicant';
                $body = "{$data['applicant_name']} applied for {$data['job_title']}.";
                break;
            case 'status_updated':
                $title = 'Application Status Updated';
                $body = "Your application for {$data['job_title']} is now " . ucfirst($data['status']) . ".";
                break;
            case 'withdrawn':
                $title = 'Application Withdrawn';
                $body = "{$data['applicant_name']} withdrew their application for {$data['job_title']}.";
                break;
            case 'resume_downloaded':
                $title = 'Resume Viewed';
                $body = "{$data['company_name']} viewed and downloaded your resume for {$data['job_title']}.";
                break;
        }

        // 1. Create In-App Notification using the custom model & table if enabled
        if ($preferences->in_app_enabled && $topicEnabled) {
            Notification::create([
                'user_id' => $recipient->id,
                'title' => $title,
                'body' => $body,
                'type' => $type,
                'data' => [
                    'type' => $type,
                    'job_title' => $data['job_title'] ?? null,
                    'company_name' => $data['company_name'] ?? null,
                    'applicant_name' => $data['applicant_name'] ?? null,
                    'status' => $data['status'] ?? null,
                    'remarks' => $data['remarks'] ?? null,
                ],
                'is_read' => false,
            ]);
        }

        // 2. Queue Email Mailable if enabled
        if ($preferences->email_enabled && $topicEnabled) {
            Mail::to($recipient->email)->queue(new ApplicationMail($type, $data));
        }
    }
}
