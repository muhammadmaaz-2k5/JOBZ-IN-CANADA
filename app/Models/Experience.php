<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'designation',
        'employment_type',
        'start_date',
        'end_date',
        'currently_working',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'currently_working' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
