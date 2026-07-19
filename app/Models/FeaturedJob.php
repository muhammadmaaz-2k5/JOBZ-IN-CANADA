<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedJob extends Model
{
    protected $fillable = [
        'job_id',
        'employer_id',
        'starts_at',
        'expires_at',
        'payment_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }
}
