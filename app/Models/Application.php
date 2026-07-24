<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'applicant_id',
        'resume_id',
        'cover_letter',
        'status',
        'applied_at',
        'withdrawn_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function notes()
    {
        return $this->hasMany(ApplicationNote::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(ApplicationStatusHistory::class, 'application_id');
    }

    public function screeningAnswers()
    {
        return $this->hasMany(ScreeningAnswer::class, 'application_id');
    }
}
