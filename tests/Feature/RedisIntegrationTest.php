<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RedisIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'job_seeker']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employer']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_search_suggestions_uses_caching()
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([
                ['type' => 'skill', 'text' => 'React']
            ]);

        $response = $this->getJson('/api/jobs/suggestions?query=React');

        $response->assertStatus(200);
        $response->assertJson([
            ['type' => 'skill', 'text' => 'React']
        ]);
    }

    public function test_dashboard_uses_caching()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([
                'seekerProfile' => null,
                'metrics' => [
                    'applied' => 5,
                    'saved' => 3,
                    'interviews' => 1,
                    'follows' => 2,
                    'alerts' => 1,
                    'profile_completion' => 80
                ],
                'suggestions' => [],
                'recommendedJobs' => collect(),
                'recentApplications' => collect(),
                'savedJobs' => collect(),
                'timeline' => collect(),
                'alerts' => collect(),
                'categories' => collect(),
                'notifications' => collect()
            ]);

        $response = $this->actingAs($user)->get('/seeker/dashboard');

        $response->assertStatus(200);
    }
}
