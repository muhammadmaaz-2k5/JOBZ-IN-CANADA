<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Company;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use Database\Seeders\CreateRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles & permissions for every test
        $this->seed(CreateRolesAndPermissionsSeeder::class);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_job_seeker_can_register(): void
    {
        $response = $this->post('/register', [
            'role' => 'job_seeker',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'headline' => 'Full Stack Developer',
            'linkedin' => 'https://linkedin.com/in/johndoe',
        ]);

        $this->assertAuthenticated();
        
        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('job_seeker'));
        
        // Assert profile was created
        $this->assertDatabaseHas('job_seeker_profiles', [
            'user_id' => $user->id,
            'headline' => 'Full Stack Developer',
            'linkedin' => 'https://linkedin.com/in/johndoe',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_employer_can_register(): void
    {
        $response = $this->post('/register', [
            'role' => 'employer',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'company_name' => 'Canada Tech Corp',
            'website' => 'https://canadatech.com',
            'industry' => 'Technology',
            'company_size' => '11-50',
            'designation' => 'HR Director',
            'employer_phone' => '+1 604-555-0123',
        ]);

        $this->assertAuthenticated();

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('employer'));

        // Assert company was created
        $company = Company::where('company_name', 'Canada Tech Corp')->first();
        $this->assertNotNull($company);
        $this->assertEquals('canada-tech-corp', $company->slug);

        // Assert employer profile was created
        $this->assertDatabaseHas('employer_profiles', [
            'user_id' => $user->id,
            'company_id' => $company->id,
            'designation' => 'HR Director',
            'phone' => '+1 604-555-0123',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
