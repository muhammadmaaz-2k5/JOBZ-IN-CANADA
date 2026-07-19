<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SemanticCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.redis_langcache.api_key' => 'mock-api-key',
            'services.redis_langcache.cache_id' => '2119ce483fe54c098e79b6d3cce580cd'
        ]);
    }

    public function test_semantic_cache_hit_retrieves_cached_jobs()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::create([
            'company_name' => 'Acme Inc',
            'slug' => 'acme-inc',
            'verification_status' => 'verified'
        ]);
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);

        // Create the job
        $job10 = Job::create([
            'company_id' => $company->id,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'Laravel Ninja',
            'slug' => 'laravel-ninja',
            'description' => 'Ninja description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'status' => 'published',
            'city' => 'Toronto',
            'country' => 'Canada',
            'location' => 'Toronto'
        ]);

        // Create another job (not in cache)
        $job30 = Job::create([
            'company_id' => $company->id,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'React Guru',
            'slug' => 'react-guru',
            'description' => 'Guru description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'status' => 'published',
            'city' => 'Toronto',
            'country' => 'Canada',
            'location' => 'Toronto'
        ]);

        // Now setup Http fake utilizing the actual generated IDs
        Http::fake([
            'https://aws-us-east-1.langcache.redis.io/v1/caches/*/entries/search' => Http::response([
                [
                    'prompt' => 'Developer',
                    'response' => json_encode([$job10->id])
                ]
            ], 200)
        ]);

        // Run search query
        $response = $this->get('/jobs?keyword=Developer');

        $response->assertStatus(200);
        $response->assertSee('Laravel Ninja');
        $response->assertDontSee('React Guru');
    }

    public function test_semantic_cache_miss_queries_database_and_saves_cache()
    {
        // 1. Fake LangCache search API returning empty/miss and save API returning success
        Http::fake([
            'https://aws-us-east-1.langcache.redis.io/v1/caches/*/entries/search' => Http::response([], 200),
            'https://aws-us-east-1.langcache.redis.io/v1/caches/*/entries' => Http::response(['status' => 'created'], 201)
        ]);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::create([
            'company_name' => 'Acme Inc',
            'slug' => 'acme-inc',
            'verification_status' => 'verified'
        ]);
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);

        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'Node backend developer',
            'slug' => 'node-backend-developer',
            'description' => 'Node description',
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'junior',
            'status' => 'published',
            'city' => 'Toronto',
            'country' => 'Canada',
            'location' => 'Toronto'
        ]);

        // Run search query
        $response = $this->get('/jobs?keyword=Node');

        $response->assertStatus(200);
        $response->assertSee('Node backend developer');

        // Verify that save API request was triggered
        Http::assertSent(function ($request) use ($job) {
            return $request->url() === "https://aws-us-east-1.langcache.redis.io/v1/caches/2119ce483fe54c098e79b6d3cce580cd/entries" &&
                   $request['prompt'] === 'Node' &&
                   $request['response'] === json_encode([$job->id]);
        });
    }
}
