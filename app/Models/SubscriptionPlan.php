<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'monthly_price',
        'yearly_price',
        'job_limit',
        'featured_jobs_limit',
        'candidate_search',
        'analytics_access',
        'status',
    ];

    protected $casts = [
        'monthly_price' => 'integer',
        'yearly_price' => 'integer',
        'job_limit' => 'integer',
        'featured_jobs_limit' => 'integer',
        'candidate_search' => 'boolean',
        'analytics_access' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
