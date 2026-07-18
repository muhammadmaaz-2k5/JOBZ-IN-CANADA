<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id',
        'employer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'employment_type',
        'workplace_type',
        'experience_level',
        'education_level',
        'salary_type',
        'salary_min',
        'salary_max',
        'currency',
        'vacancies',
        'location',
        'country',
        'city',
        'latitude',
        'longitude',
        'application_deadline',
        'status',
        'featured',
        'urgent',
        'views_count',
        'applications_count',
        'published_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
    }

    public function reports()
    {
        return $this->hasMany(JobReport::class);
    }
}
