<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Coupon;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\FeaturedJob;
use App\Models\ResumeBoost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BillingMonetizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'employer']);
        Role::firstOrCreate(['name' => 'job_seeker']);
        Role::firstOrCreate(['name' => 'admin']);

        // Create standard plans
        SubscriptionPlan::create([
            'name' => 'Free Plan',
            'monthly_price' => 0,
            'yearly_price' => 0,
            'job_limit' => 3,
            'featured_jobs_limit' => 0,
            'candidate_search' => false,
            'analytics_access' => false,
            'status' => 'active'
        ]);

        SubscriptionPlan::create([
            'name' => 'Professional Plan',
            'monthly_price' => 99,
            'yearly_price' => 990,
            'job_limit' => -1, // Unlimited
            'featured_jobs_limit' => 10,
            'candidate_search' => true,
            'analytics_access' => true,
            'status' => 'active'
        ]);
    }

    private function createEmployer()
    {
        $user = User::factory()->create([
            'role' => 'employer',
            'first_name' => 'Recruiter',
            'last_name' => 'One'
        ]);
        $user->assignRole('employer');
        
        $company = Company::create([
            'company_name' => 'Acme Corp',
            'slug' => 'acme-corp',
            'verification_status' => 'verified',
        ]);
        
        $user->employerProfile()->create([
            'company_name' => 'Acme Corp',
            'company_id' => $company->id,
            'website' => 'https://acme.org',
            'industry' => 'Tech',
            'company_size' => '10-50',
            'description' => 'Acme description',
            'city' => 'Toronto',
            'country' => 'Canada'
        ]);

        return $user;
    }

    private function createSeeker()
    {
        $user = User::factory()->create([
            'role' => 'job_seeker',
            'first_name' => 'Candidate',
            'last_name' => 'One'
        ]);
        $user->assignRole('job_seeker');
        return $user;
    }

    private function createAdmin()
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'first_name' => 'Platform',
            'last_name' => 'Admin'
        ]);
        $user->assignRole('admin');
        return $user;
    }

    public function test_employer_can_subscribe_to_plan_with_coupon()
    {
        $employer = $this->createEmployer();
        $plan = SubscriptionPlan::where('name', 'Professional Plan')->first();

        // Create coupon
        $coupon = Coupon::create([
            'code' => 'SAVE10',
            'type' => 'fixed',
            'value' => 10,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addDay(),
            'status' => 'active'
        ]);

        $response = $this->actingAs($employer)->post('/employer/billing/subscribe', [
            'plan_id' => $plan->id,
            'billing_cycle' => 'monthly',
            'coupon_code' => 'SAVE10'
        ]);

        $response->assertRedirect();
        
        // Assert Subscription created
        $this->assertDatabaseHas('subscriptions', [
            'employer_id' => $employer->id,
            'plan_id' => $plan->id,
            'status' => 'active'
        ]);

        // Price is 99, minus 10 coupon is 89. Tax (13% of 89) = 12. Total = 101.
        $this->assertDatabaseHas('payments', [
            'user_id' => $employer->id,
            'amount' => 101,
            'payment_type' => 'subscription',
            'status' => 'paid'
        ]);

        // Assert Invoice details
        $this->assertDatabaseHas('invoices', [
            'subtotal' => 99,
            'tax' => 12,
            'total' => 101
        ]);
    }

    public function test_active_job_limits_are_enforced()
    {
        $employer = $this->createEmployer();
        $companyId = $employer->employerProfile->company_id;
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);

        // Free plan limit is 3. Let's create 3 published jobs.
        for ($i = 0; $i < 3; $i++) {
            Job::create([
                'company_id' => $companyId,
                'employer_id' => $employer->id,
                'category_id' => $category->id,
                'title' => "Developer {$i}",
                'slug' => "developer-{$i}",
                'description' => 'Description',
                'employment_type' => 'full-time',
                'workplace_type' => 'remote',
                'experience_level' => 'junior',
                'status' => 'published',
                'city' => 'Toronto',
                'country' => 'Canada',
                'location' => 'Toronto'
            ]);
        }

        // Try creating 4th job as published (should redirect back with error)
        $response = $this->actingAs($employer)->from('/employer/jobs/create')->post('/employer/jobs', [
            'title' => 'Excess Job',
            'category_id' => $category->id,
            'description' => 'Excess description',
            'requirements' => 'Requirements',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'education_level' => 'bachelor',
            'salary_visibility' => 'visible',
            'currency' => 'CAD',
            'min_salary' => 80000,
            'max_salary' => 90000,
            'salary_period' => 'yearly',
            'country' => 'Canada',
            'city' => 'Toronto',
            'status' => 'published',
            'location' => 'Toronto'
        ]);

        $response->assertRedirect('/employer/jobs/create');
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('jobs', ['title' => 'Excess Job']);
    }

    public function test_candidate_search_gating_for_employers()
    {
        $employer = $this->createEmployer();

        // 1. Without premium plan, viewing candidate profile fails with 403
        $response = $this->actingAs($employer)->get("/employer/candidates/999");
        $response->assertStatus(403);

        // 2. Subscribe to Professional Plan (enables candidate search)
        $plan = SubscriptionPlan::where('name', 'Professional Plan')->first();
        Subscription::create([
            'employer_id' => $employer->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth()
        ]);

        $employer->refresh();

        // Create candidate
        $seeker = $this->createSeeker();
        $seeker->jobSeekerProfile()->create([
            'headline' => 'QA Analyst',
            'city' => 'Toronto',
            'country' => 'Canada',
            'skills' => 'QA, Testing'
        ]);

        // 3. Now accessing candidate show returns successfully
        $responsePremium = $this->actingAs($employer)->get("/employer/candidates/{$seeker->id}");
        $responsePremium->assertStatus(200);
    }

    public function test_featured_job_promotion()
    {
        $employer = $this->createEmployer();
        $companyId = $employer->employerProfile->company_id;
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);

        $job = Job::create([
            'company_id' => $companyId,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'Normal Job',
            'slug' => 'normal-job',
            'description' => 'Description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'status' => 'published',
            'city' => 'Toronto',
            'country' => 'Canada',
            'location' => 'Toronto'
        ]);

        $response = $this->actingAs($employer)->post("/employer/jobs/{$job->id}/promote", [
            'duration_days' => 30
        ]);

        $response->assertRedirect();
        
        // Assert job featured flag set to true
        $this->assertTrue((bool)$job->fresh()->featured);

        // Assert payment logs
        $this->assertDatabaseHas('featured_jobs', [
            'job_id' => $job->id,
            'employer_id' => $employer->id
        ]);
    }

    public function test_candidate_can_boost_profile()
    {
        $seeker = $this->createSeeker();

        $response = $this->actingAs($seeker)->post('/seeker/boost', [
            'duration_days' => 15
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('resume_boosts', [
            'user_id' => $seeker->id
        ]);
    }

    public function test_admin_coupon_crud()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/coupons', [
            'code' => 'FIFTY',
            'type' => 'percentage',
            'value' => 50,
            'starts_at' => date('Y-m-d'),
            'expires_at' => date('Y-m-d', strtotime('+30 days')),
            'usage_limit' => 100
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('coupons', ['code' => 'FIFTY']);
    }
}
