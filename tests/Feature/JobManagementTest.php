<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class JobManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'employer']);
    }

    private function createVerifiedEmployer()
    {
        $user = User::factory()->create([
            'role' => 'employer',
            'first_name' => 'Employer',
            'last_name' => 'User'
        ]);
        $user->assignRole('employer');

        $company = Company::create([
            'company_name' => 'Indeed Canada Corp',
            'slug' => 'indeed-canada-corp',
            'website' => 'https://indeed.ca',
            'industry' => 'Technology',
            'company_size' => '51-200',
            'verification_status' => 'verified' // VERIFIED to bypass middleware
        ]);

        EmployerProfile::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'designation' => 'Recruiting Lead'
        ]);

        return $user;
    }

    public function test_employer_can_post_a_job_and_sync_skills()
    {
        $user = $this->createVerifiedEmployer();
        
        $category = Category::create([
            'name' => 'Engineering',
            'slug' => 'engineering'
        ]);

        $skill1 = Skill::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $skill2 = Skill::create(['name' => 'React', 'slug' => 'react']);

        $response = $this->actingAs($user)->post('/employer/jobs', [
            'title' => 'Senior Laravel Engineer',
            'category_id' => $category->id,
            'description' => 'We are looking for a Laravel developer.',
            'requirements' => '3+ years experience with PHP & Laravel.',
            'vacancies' => 2,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'education_level' => 'bachelors',
            'salary_visibility' => 'range',
            'currency' => 'CAD',
            'min_salary' => 90000,
            'max_salary' => 120000,
            'salary_period' => 'yearly',
            'country' => 'Canada',
            'city' => 'Vancouver',
            'skills' => [$skill1->id, $skill2->id],
            'status' => 'published',
        ]);

        $response->assertRedirect(route('employer.jobs.index'));

        $this->assertDatabaseHas('jobs', [
            'title' => 'Senior Laravel Engineer',
            'workplace_type' => 'remote',
            'salary_min' => 90000,
            'status' => 'published'
        ]);

        $job = Job::where('title', 'Senior Laravel Engineer')->first();
        $this->assertNotNull($job);
        $this->assertTrue($job->skills->contains($skill1->id));
        $this->assertTrue($job->skills->contains($skill2->id));

        // Verify audit log
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'job_created'
        ]);
    }

    public function test_employer_can_duplicate_job()
    {
        $user = $this->createVerifiedEmployer();
        $category = Category::create(['name' => 'Design', 'slug' => 'design']);

        $job = Job::create([
            'company_id' => $user->employerProfile->company_id,
            'employer_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'UI Designer',
            'slug' => 'ui-designer-original',
            'description' => 'Original description.',
            'requirements' => 'Design things.',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'hybrid',
            'experience_level' => 'junior',
            'education_level' => 'not-required',
            'salary_visibility' => 'hidden',
            'currency' => 'CAD',
            'salary_period' => 'monthly',
            'country' => 'Canada',
            'city' => 'Calgary',
            'location' => 'Calgary',
            'status' => 'published'
        ]);

        $response = $this->actingAs($user)->post("/employer/jobs/{$job->id}/duplicate");

        $response->assertRedirect(route('employer.jobs.index'));

        $this->assertDatabaseHas('jobs', [
            'title' => 'UI Designer Copy',
            'status' => 'draft',
            'workplace_type' => 'hybrid'
        ]);
    }

    public function test_public_job_listings_search_and_filters()
    {
        $user = User::factory()->create();
        $category1 = Category::create(['name' => 'Engineering', 'slug' => 'engineering']);
        $category2 = Category::create(['name' => 'Design', 'slug' => 'design']);

        $company = Company::create([
            'company_name' => 'Microsoft',
            'slug' => 'microsoft',
            'website' => 'https://microsoft.com',
            'industry' => 'Tech',
            'company_size' => '501+'
        ]);

        // Job 1: Engineering Remote Laravel
        $job1 = Job::create([
            'company_id' => $company->id,
            'employer_id' => $user->id,
            'category_id' => $category1->id,
            'title' => 'Laravel Developer',
            'slug' => 'laravel-developer',
            'description' => 'Writing backend services.',
            'requirements' => 'PHP.',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'mid',
            'education_level' => 'not-required',
            'salary_visibility' => 'exact',
            'currency' => 'CAD',
            'min_salary' => 80000,
            'max_salary' => 80000,
            'salary_period' => 'yearly',
            'country' => 'Canada',
            'city' => 'Toronto',
            'location' => 'Toronto',
            'status' => 'published'
        ]);

        // Job 2: Design On-site Graphic
        $job2 = Job::create([
            'company_id' => $company->id,
            'employer_id' => $user->id,
            'category_id' => $category2->id,
            'title' => 'Graphic Designer',
            'slug' => 'graphic-designer',
            'description' => 'Photoshop work.',
            'requirements' => 'Adobe CC.',
            'vacancies' => 1,
            'employment_type' => 'part-time',
            'workplace_type' => 'on-site',
            'experience_level' => 'junior',
            'education_level' => 'not-required',
            'salary_visibility' => 'hidden',
            'currency' => 'CAD',
            'salary_period' => 'hourly',
            'country' => 'Canada',
            'city' => 'Montreal',
            'location' => 'Montreal',
            'status' => 'published'
        ]);

        // Search keyword "Laravel"
        $response = $this->get('/jobs?keyword=Laravel');
        $response->assertOk();
        $response->assertSee('Laravel Developer');
        $response->assertDontSee('Graphic Designer');

        // Filter by workplace remote
        $response = $this->get('/jobs?workplace_type[]=remote');
        $response->assertOk();
        $response->assertSee('Laravel Developer');
        $response->assertDontSee('Graphic Designer');
    }

    public function test_auto_close_expired_jobs_artisan_command()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Swift', 'slug' => 'swift']);
        $company = Company::create([
            'company_name' => 'Apple',
            'slug' => 'apple',
            'website' => 'https://apple.com',
            'industry' => 'Tech',
            'company_size' => '501+'
        ]);

        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Expired Swift Developer',
            'slug' => 'expired-swift-developer',
            'description' => 'Expired Swift.',
            'requirements' => 'iOS.',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'education_level' => 'not-required',
            'salary_visibility' => 'hidden',
            'currency' => 'CAD',
            'salary_period' => 'yearly',
            'country' => 'Canada',
            'city' => 'Toronto',
            'location' => 'Toronto',
            'status' => 'published',
            'application_deadline' => now()->subDay(), // Passed
            'auto_close_on_deadline' => true
        ]);

        // Run Artisan command
        Artisan::call('jobs:close-expired');

        $job->refresh();
        $this->assertEquals('closed', $job->status);
    }
}
