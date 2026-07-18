<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'headline',
        'summary',
        'current_salary',
        'expected_salary',
        'notice_period',
        'experience_years',
        'employment_preference',
        'career_level',
        'work_authorization',
        'linkedin',
        'github',
        'portfolio',
        'website',
        'profile_completion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompletionPercentage(): int
    {
        $user = $this->user()->first();
        if (!$user) {
            return 0;
        }

        $percentage = 0;

        // Photo (10%)
        if (!empty($user->profile_photo)) {
            $percentage += 10;
        }

        // Headline & Summary (15% total - 8% / 7%)
        if (!empty($this->headline)) {
            $percentage += 8;
        }
        if (!empty($this->summary)) {
            $percentage += 7;
        }

        // Resumes (20%)
        if ($user->resumes()->exists()) {
            $percentage += 20;
        }

        // Experience (20%)
        if ($user->experiences()->exists()) {
            $percentage += 20;
        }

        // Education (15%)
        if ($user->education()->exists()) {
            $percentage += 15;
        }

        // Skills (10%)
        if ($user->skills()->exists()) {
            $percentage += 10;
        }

        // Projects & Certifications (10%)
        if ($user->projects()->exists() || $user->certifications()->exists()) {
            $percentage += 10;
        }

        $this->profile_completion = $percentage;
        $this->save();

        return $percentage;
    }
}
