<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use Database\Seeders\CreateRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles & permissions
        $this->seed(CreateRolesAndPermissionsSeeder::class);
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response2 = $this->get('/seeker/dashboard');
        $response2->assertRedirect('/login');
    }

    public function test_job_seeker_can_access_seeker_dashboard_but_not_others(): void
    {
        $seeker = User::factory()->create();
        $seeker->assignRole('job_seeker');

        // Create dummy profile for seeker
        JobSeekerProfile::create([
            'user_id' => $seeker->id,
            'headline' => 'Developer',
        ]);

        // Access Seeker Dashboard
        $response = $this->actingAs($seeker)->get('/seeker/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Job Seeker Dashboard');

        // Try accessing Employer Dashboard
        $response2 = $this->actingAs($seeker)->get('/employer/dashboard');
        $response2->assertStatus(403);

        // Try accessing Admin Dashboard
        $response3 = $this->actingAs($seeker)->get('/admin/dashboard');
        $response3->assertStatus(403);
    }

    public function test_employer_can_access_employer_dashboard_but_not_others(): void
    {
        $employer = User::factory()->create();
        $employer->assignRole('employer');

        $company = Company::create([
            'company_name' => 'Acme Corp',
            'slug' => 'acme-corp',
        ]);

        EmployerProfile::create([
            'user_id' => $employer->id,
            'company_id' => $company->id,
            'designation' => 'Recruiter',
        ]);

        // Access Employer Dashboard
        $response = $this->actingAs($employer)->get('/employer/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Employer Dashboard');
        $response->assertSee('Acme Corp');

        // Try accessing Seeker Dashboard
        $response2 = $this->actingAs($employer)->get('/seeker/dashboard');
        $response2->assertStatus(403);

        // Try accessing Admin Dashboard
        $response3 = $this->actingAs($employer)->get('/admin/dashboard');
        $response3->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard_but_not_others(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Access Admin Dashboard
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Administrator Dashboard');

        // Try accessing Seeker Dashboard
        $response2 = $this->actingAs($admin)->get('/seeker/dashboard');
        $response2->assertStatus(403);

        // Try accessing Employer Dashboard
        $response3 = $this->actingAs($admin)->get('/employer/dashboard');
        $response3->assertStatus(403);
    }
}
