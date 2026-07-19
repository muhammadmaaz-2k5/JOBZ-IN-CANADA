<?php

namespace App\Jobs;

use App\Models\Job;
use App\Models\JobAlert;
use App\Models\Notification;
use App\Mail\AlertMatchNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendJobAlerts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $frequency;

    public function __construct($frequency = 'daily')
    {
        $this->frequency = $frequency;
    }

    public function handle()
    {
        $alerts = JobAlert::where('frequency', $this->frequency)->with('user')->get();

        $sinceTime = $this->frequency === 'daily' ? now()->subDay() : now()->subWeek();

        foreach ($alerts as $alert) {
            $user = $alert->user;
            if (!$user || $user->status !== 'active') {
                continue;
            }

            // Match newly published jobs
            $query = Job::where('status', 'published')
                ->where('created_at', '>=', $sinceTime)
                ->with('company');

            // Apply keyword criteria
            if (!empty($alert->keyword)) {
                $keyword = $alert->keyword;
                $query->where(fn($q) => $q->where('title', 'like', "%{$keyword}%")->orWhere('description', 'like', "%{$keyword}%"));
            }

            // Apply location criteria
            if (!empty($alert->location)) {
                $loc = $alert->location;
                $query->where(fn($q) => $q->where('city', 'like', "%{$loc}%")->orWhere('country', 'like', "%{$loc}%"));
            }

            $jobs = $query->latest()->get();

            if ($jobs->count() > 0) {
                // 1. Send Email Notification
                Mail::to($user->email)->send(new AlertMatchNotificationMail($user, $jobs, $alert->keyword));

                // 2. Write Database Notification log
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'New Job Alert Matches',
                    'body' => "We found {$jobs->count()} new job(s) matching your alert for \"{$alert->keyword}\". Check your email for full list.",
                    'type' => 'job_alert',
                    'data' => [
                        'keyword' => $alert->keyword,
                        'jobs_count' => $jobs->count(),
                    ],
                    'is_read' => false,
                ]);
            }
        }
    }
}
