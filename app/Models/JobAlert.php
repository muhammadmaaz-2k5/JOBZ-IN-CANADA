<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    protected $fillable = [
        'user_id',
        'keyword',
        'location',
        'category_id',
        'salary_min',
        'remote',
        'frequency',
    ];

    protected $casts = [
        'remote' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
