<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::updateOrCreate(
            ['name' => 'Free Plan'],
            [
                'monthly_price' => 0,
                'yearly_price' => 0,
                'job_limit' => 3,
                'featured_jobs_limit' => 0,
                'candidate_search' => false,
                'analytics_access' => false,
                'status' => 'active'
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['name' => 'Starter Plan'],
            [
                'monthly_price' => 29,
                'yearly_price' => 290,
                'job_limit' => 20,
                'featured_jobs_limit' => 3,
                'candidate_search' => false,
                'analytics_access' => false,
                'status' => 'active'
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['name' => 'Professional Plan'],
            [
                'monthly_price' => 99,
                'yearly_price' => 990,
                'job_limit' => -1, // Unlimited
                'featured_jobs_limit' => 10,
                'candidate_search' => true,
                'analytics_access' => true,
                'status' => 'active'
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['name' => 'Enterprise Plan'],
            [
                'monthly_price' => 299,
                'yearly_price' => 2990,
                'job_limit' => -1,
                'featured_jobs_limit' => -1, // Unlimited
                'candidate_search' => true,
                'analytics_access' => true,
                'status' => 'active'
            ]
        );
    }
}
