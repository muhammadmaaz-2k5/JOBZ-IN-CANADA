<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

#[Fillable(['first_name', 'last_name', 'email', 'password', 'role', 'phone', 'profile_photo', 'country', 'city', 'status', 'last_login'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }

    public function jobSeekerProfile()
    {
        return $this->hasOne(JobSeekerProfile::class);
    }

    public function employerProfile()
    {
        return $this->hasOne(EmployerProfile::class);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
                    ->withPivot('experience_years', 'proficiency')
                    ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Job::class, 'saved_jobs')->withTimestamps();
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    public function companyFollowings()
    {
        return $this->belongsToMany(Company::class, 'company_followers')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function reportsLogs()
    {
        return $this->hasMany(ReportsLog::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'employer_id');
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'employer_id')
            ->where('status', 'active')
            ->latestOfMany();
    }

    public function resumeBoosts()
    {
        return $this->hasMany(ResumeBoost::class);
    }

    public function activeResumeBoost()
    {
        return $this->hasOne(ResumeBoost::class)
            ->where('expires_at', '>=', now())
            ->latestOfMany();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
