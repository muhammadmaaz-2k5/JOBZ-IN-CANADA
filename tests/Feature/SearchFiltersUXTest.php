<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Skill;
use App\Models\JobAlert;
use App\Models\Notification;
use App\Models\SearchQuery;
use App\Jobs\SendJobAlerts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SearchFiltersUXTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'job_seeker']);
        Role::firstOrCreate(['name' => 'admin']);
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

    public function test_autocomplete_suggestions_api()
    {
        $company = Company::create([
            'company_name' => 'OpenAI Tech Corp',
            'slug' => 'openai-tech-corp',
            'verification_status' => 'verified',
        ]);
        
        $category = Category::create(['name' => 'Engineering', 'slug' => 'engineering']);
        
        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'title' => 'Laravel Principal Architect',
            'slug' => 'laravel-principal-architect',
            'description' => 'Laravel dev description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published'
        ]);

        $response = $this->getJson('/api/jobs/suggestions?query=Lara');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'type' => 'job_title',
            'text' => 'Laravel Principal Architect'
        ]);
    }

    public function test_advanced_search_filters_and_analytics()
    {
        $seeker = $this->createSeeker();
        $company = Company::create([
            'company_name' => 'Shopify Canada',
            'slug' => 'shopify-canada',
            'verification_status' => 'verified',
        ]);
        
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);
        
        // Job 1: Has salary, no screening questions (Easy Apply)
        $job1 = Job::create([
            'company_id' => $company->id,
            'employer_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'title' => 'Senior Shopify Developer',
            'slug' => 'senior-shopify-developer',
            'description' => 'Shopify description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'salary_min' => 100000,
            'salary_max' => 150000,
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published'
        ]);

        // Job 2: No salary, has screening questions (not Easy Apply)
        $job2 = Job::create([
            'company_id' => $company->id,
            'employer_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'title' => 'Junior Rails Developer',
            'slug' => 'junior-rails-developer',
            'description' => 'Rails description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published'
        ]);

        $job2->screeningQuestions()->create([
            'question_text' => 'Years of Ruby experience?',
            'type' => 'text',
            'is_required' => true
        ]);

        // 1. Search Easy Apply jobs
        $responseEasy = $this->actingAs($seeker)->get('/jobs?easy_apply=1');
        $responseEasy->assertStatus(200);
        $responseEasy->assertSee('Senior Shopify Developer');
        $responseEasy->assertDontSee('Junior Rails Developer');

        // 2. Search Salary Visible jobs
        $responseSalary = $this->actingAs($seeker)->get('/jobs?salary_visible=1');
        $responseSalary->assertStatus(200);
        $responseSalary->assertSee('Senior Shopify Developer');
        $responseSalary->assertDontSee('Junior Rails Developer');

        // Assert search analytics query is saved
        $this->assertDatabaseHas('search_queries', [
            'user_id' => $seeker->id,
            'results_count' => 1
        ]);
    }

    public function test_recent_searches_and_view_history_tracking()
    {
        $seeker = $this->createSeeker();
        $company = Company::create([
            'company_name' => 'Shopify Canada',
            'slug' => 'shopify-canada',
            'verification_status' => 'verified',
        ]);
        
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);
        
        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'title' => 'React Engineer',
            'slug' => 'react-engineer',
            'description' => 'React description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published'
        ]);

        // Search trigger
        $this->actingAs($seeker)->get('/jobs?keyword=React');
        $this->assertTrue(session()->has('recent_searches'));
        $this->assertEquals('React', session('recent_searches')[0]['keyword']);

        // View trigger
        $this->actingAs($seeker)->get("/jobs/{$job->slug}");
        $this->assertTrue(session()->has('recently_viewed_jobs'));
        $this->assertContains($job->id, session('recently_viewed_jobs'));

        // Clear Search History
        $responseClearSearch = $this->actingAs($seeker)->post('/jobs/history/clear-search');
        $responseClearSearch->assertRedirect();
        $this->assertFalse(session()->has('recent_searches'));

        // Clear Viewed History
        $responseClearViewed = $this->actingAs($seeker)->post('/jobs/history/clear-viewed');
        $responseClearViewed->assertRedirect();
        $this->assertFalse(session()->has('recently_viewed_jobs'));
    }

    public function test_sitemap_xml_endpoint()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $this->assertStringContainsString('<urlset', $response->getContent());
    }

    public function test_job_alerts_matching_and_delivery()
    {
        Mail::fake();

        $seeker = $this->createSeeker();
        $company = Company::create([
            'company_name' => 'Shopify Canada',
            'slug' => 'shopify-canada',
            'verification_status' => 'verified',
        ]);
        
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);

        // Create alert subscriber
        JobAlert::create([
            'user_id' => $seeker->id,
            'keyword' => 'Laravel',
            'location' => 'Toronto',
            'frequency' => 'daily',
            'delivery_channel' => 'email',
        ]);

        // Create match job
        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'title' => 'Laravel Backend Developer',
            'slug' => 'laravel-backend-developer',
            'description' => 'Laravel description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'senior',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published',
            'created_at' => now()->subHours(2), // within 24h
        ]);

        // Dispatch alert matcher job
        SendJobAlerts::dispatch('daily');

        // Verify notification saved in database
        $this->assertDatabaseHas('notifications', [
            'user_id' => $seeker->id,
            'type' => 'job_alert'
        ]);

        // Verify email sent
        Mail::assertSent(\App\Mail\AlertMatchNotificationMail::class, function ($mail) use ($seeker) {
            return $mail->hasTo($seeker->email);
        });
    }

    public function test_admin_can_access_search_analytics()
    {
        $admin = $this->createAdmin();

        SearchQuery::create([
            'query_string' => 'Laravel',
            'results_count' => 10,
            'search_time_ms' => 15,
            'user_id' => null
        ]);

        $response = $this->actingAs($admin)->get('/admin/search-analytics');
        $response->assertStatus(200);
        $response->assertSee('Search');
        $response->assertSee('Query Analytics');
        $response->assertSee('Laravel');
    }
}
