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
}
