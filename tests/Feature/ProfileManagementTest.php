<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use App\Models\Company;
use App\Models\Skill;
use App\Models\Resume;
use App\Models\Experience;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'job_seeker']);
        Role::firstOrCreate(['name' => 'employer']);
    }

    public function test_seeker_can_update_profile_and_completeness_recalculated()
    {
        Storage::fake('public');
        $user = User::factory()->create([
            'role' => 'job_seeker',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
        $user->assignRole('job_seeker');
        
        $profile = JobSeekerProfile::create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put('/seeker/profile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'headline' => 'Senior Developer',
            'summary' => 'Doing things with Laravel.',
            'profile_photo' => UploadedFile::fake()->create('photo.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('seeker.profile.edit'));
        
        $user->refresh();
        $profile->refresh();

        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Senior Developer', $profile->headline);
        $this->assertNotNull($user->profile_photo);
        
        // Assert completeness was updated
        // Photo (10%) + Headline (8%) + Summary (7%) = 25%
        $this->assertEquals(25, $profile->profile_completion);
        
        // Assert audit log was recorded
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'profile_updated'
        ]);
    }

    public function test_seeker_can_upload_resume_and_set_default()
    {
        Storage::fake();
        $user = User::factory()->create(['role' => 'job_seeker']);
        $user->assignRole('job_seeker');
        JobSeekerProfile::create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('resume.pdf', 500, 'application/pdf');

        $response = $this->actingAs($user)->post('/seeker/profile/resume', [
            'title' => 'Standard Resume',
            'resume_file' => $file,
        ]);

        $response->assertRedirect(route('seeker.profile.edit'));

        $this->assertDatabaseHas('resumes', [
            'user_id' => $user->id,
            'title' => 'Standard Resume',
            'is_default' => true
        ]);
    }

    public function test_employer_can_update_company_branding()
    {
        Storage::fake('public');
        $user = User::factory()->create([
            'role' => 'employer',
            'first_name' => 'Jane',
            'last_name' => 'Smith'
        ]);
        $user->assignRole('employer');
        
        $company = Company::create([
            'company_name' => 'Old Tech Inc',
            'slug' => 'old-tech-inc',
            'website' => 'https://oldtech.com',
            'industry' => 'Services',
            'company_size' => '1-10',
            'verification_status' => 'pending'
        ]);
        
        EmployerProfile::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'designation' => 'HR Director'
        ]);

        $response = $this->actingAs($user)->put('/employer/profile', [
            'first_name' => 'HR',
            'last_name' => 'Manager',
            'designation' => 'Recruiter',
            'company_name' => 'New Tech Corp',
            'website' => 'https://newtech.com',
            'industry' => 'Technology',
            'company_size' => '11-50',
            'logo' => UploadedFile::fake()->create('logo.png', 100, 'image/png'),
        ]);

        $response->assertRedirect(route('employer.profile.edit'));

        $company->refresh();
        $this->assertEquals('New Tech Corp', $company->company_name);
        $this->assertNotNull($company->logo);
    }

    public function test_gdpr_data_download()
    {
        $user = User::factory()->create([
            'role' => 'job_seeker',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
        $user->assignRole('job_seeker');
        JobSeekerProfile::create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/settings/download-data');

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename=gdpr-data-john-doe-' . date('Y-m-d') . '.json');
    }
}
