<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchQuery extends Model
{
    protected $fillable = [
        'query_string',
        'filters',
        'results_count',
        'search_time_ms',
        'user_id',
    ];

    protected $casts = [
        'filters' => 'array',
        'results_count' => 'integer',
        'search_time_ms' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
