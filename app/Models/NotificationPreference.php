<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        'email_enabled',
        'push_enabled',
        'in_app_enabled',
        'job_alerts',
        'application_updates',
        'marketing_emails',
    ];

    protected $casts = [
        'email_enabled' => 'boolean',
        'push_enabled' => 'boolean',
        'in_app_enabled' => 'boolean',
        'job_alerts' => 'boolean',
        'application_updates' => 'boolean',
        'marketing_emails' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
