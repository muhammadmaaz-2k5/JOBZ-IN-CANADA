<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningQuestion extends Model
{
    protected $fillable = [
        'job_id',
        'question_text',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
