<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeDownload extends Model
{
    protected $fillable = [
        'employer_id',
        'candidate_id',
        'job_id',
        'downloaded_at',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
