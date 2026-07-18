<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\JobSeekerProfile;
use App\Models\Job;
use App\Models\Skill;
use App\Models\JobAlert;
use App\Models\JobReport;
use App\Models\CompanyReview;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'job_seeker']);
        Role::firstOrCreate(['name' => 'employer']);
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

        JobSeekerProfile::create([
            'user_id' => $user->id,
            'headline' => 'Dev',
            'summary' => 'PHP Dev',
            'city' => 'Toronto',
            'country' => 'Canada'
        ]);

        return $user;
    }

    private function createEmployer()
    {
        $user = User::factory()->create([
            'role' => 'employer',
            'first_name' => 'Employer',
            'last_name' => 'One'
        ]);
        $user->assignRole('employer');

        $company = Company::create([
            'company_name' => 'Indeed Canada Corp',
            'slug' => 'indeed-canada-corp',
            'website' => 'https://indeed.ca',
            'industry' => 'Tech',
            'company_size' => '51-200',
            'verification_status' => 'verified'
        ]);

        EmployerProfile::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'designation' => 'Recruiter'
        ]);

        return [$user, $company];
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

    public function test_seeker_can_access_dashboard_and_manage_alerts()
    {
        $seeker = $this->createSeeker();

        $response = $this->actingAs($seeker)->get('/seeker/dashboard');
        $response->assertStatus(200);

        // Store Job Alert
        $responseAlert = $this->actingAs($seeker)->post('/seeker/alerts', [
            'keyword' => 'Laravel',
            'location' => 'Toronto',
            'frequency' => 'daily',
            'remote' => 1
        ]);
        $responseAlert->assertRedirect();
        
        $this->assertDatabaseHas('job_alerts', [
            'user_id' => $seeker->id,
            'keyword' => 'Laravel'
        ]);

        $alert = JobAlert::where('user_id', $seeker->id)->first();

        // Delete Alert
        $responseDelete = $this->actingAs($seeker)->delete("/seeker/alerts/{$alert->id}");
        $responseDelete->assertRedirect();
        $this->assertDatabaseMissing('job_alerts', ['id' => $alert->id]);
    }

    public function test_seeker_can_bookmark_and_unbookmark_jobs()
    {
        $seeker = $this->createSeeker();
        [$employer, $company] = $this->createEmployer();
        
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);
        
        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'Vue Developer',
            'slug' => 'vue-developer',
            'description' => 'Vue dev description',
            'requirements' => 'Vue',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'mid',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published'
        ]);

        // Toggle Save (Bookmark)
        $responseSave = $this->actingAs($seeker)->post("/jobs/{$job->id}/save");
        $responseSave->assertRedirect();
        
        $this->assertTrue($seeker->savedJobs()->where('job_id', $job->id)->exists());

        // Toggle Save again (Unbookmark)
        $responseUnsave = $this->actingAs($seeker)->post("/jobs/{$job->id}/save");
        $responseUnsave->assertRedirect();
        
        $this->assertFalse($seeker->savedJobs()->where('job_id', $job->id)->exists());
    }

    public function test_employer_can_access_dashboard()
    {
        [$employer, $company] = $this->createEmployer();

        $response = $this->actingAs($employer)->get('/employer/dashboard');
        $response->assertStatus(200);
        $response->assertSee($company->company_name);
    }

    public function test_admin_can_access_dashboard_and_moderation_subpages()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        // Subpages access
        $this->actingAs($admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/companies')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/jobs')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/categories')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/skills')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/reports')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/reviews')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/audit-logs')->assertStatus(200);
    }

    public function test_admin_can_toggle_user_status_and_reset_password()
    {
        $admin = $this->createAdmin();
        $seeker = $this->createSeeker();

        // Toggle Status
        $responseStatus = $this->actingAs($admin)->post("/admin/users/{$seeker->id}/status");
        $responseStatus->assertRedirect();
        
        $seeker->refresh();
        $this->assertEquals('suspended', $seeker->status);

        // Reset Password
        $responseReset = $this->actingAs($admin)->post("/admin/users/{$seeker->id}/password-reset", [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);
        $responseReset->assertRedirect();

        // Check authentication succeeds with new password
        $this->assertTrue(Auth::attempt([
            'email' => $seeker->email,
            'password' => 'newpassword123'
        ]));
    }

    public function test_admin_can_verify_company()
    {
        $admin = $this->createAdmin();
        [$employer, $company] = $this->createEmployer();
        $company->update(['verification_status' => 'pending']);

        $response = $this->actingAs($admin)->post("/admin/companies/{$company->id}/verify", [
            'status' => 'verified'
        ]);
        $response->assertRedirect();

        $company->refresh();
        $this->assertEquals('verified', $company->verification_status);
    }

    public function test_admin_can_moderate_jobs()
    {
        $admin = $this->createAdmin();
        [$employer, $company] = $this->createEmployer();
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);
        
        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => $employer->id,
            'category_id' => $category->id,
            'title' => 'Draft Developer',
            'slug' => 'draft-developer',
            'description' => 'Draft description',
            'requirements' => 'Draft',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'mid',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'draft'
        ]);

        // Approve Job
        $responseApprove = $this->actingAs($admin)->post("/admin/jobs/{$job->id}/approve");
        $responseApprove->assertRedirect();

        $job->refresh();
        $this->assertEquals('published', $job->status);

        // Feature toggle
        $responseFeature = $this->actingAs($admin)->post("/admin/jobs/{$job->id}/feature");
        $responseFeature->assertRedirect();

        $job->refresh();
        $this->assertTrue($job->featured);
    }

    public function test_admin_categories_and_skills_crud()
    {
        $admin = $this->createAdmin();

        // Create Category
        $responseCat = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Healthcare',
            'icon' => '🏥'
        ]);
        $responseCat->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Healthcare', 'icon' => '🏥']);

        // Create Skill
        $responseSkill = $this->actingAs($admin)->post('/admin/skills', [
            'name' => 'Laravel Master'
        ]);
        $responseSkill->assertRedirect();
        $this->assertDatabaseHas('skills', ['name' => 'Laravel Master']);

        // Merge Skills
        $sourceSkill = Skill::create(['name' => 'PHP Old', 'slug' => 'php-old']);
        $targetSkill = Skill::create(['name' => 'PHP Modern', 'slug' => 'php-modern']);

        $responseMerge = $this->actingAs($admin)->post('/admin/skills/merge', [
            'source_skill_id' => $sourceSkill->id,
            'target_skill_id' => $targetSkill->id
        ]);
        $responseMerge->assertRedirect();
        
        $this->assertDatabaseMissing('skills', ['id' => $sourceSkill->id]);
        $this->assertDatabaseHas('skills', ['id' => $targetSkill->id]);
    }

    public function test_admin_can_impersonate_user_and_revert()
    {
        $admin = $this->createAdmin();
        $seeker = $this->createSeeker();

        // Start Impersonation
        $responseImpersonate = $this->actingAs($admin)->post("/admin/users/{$seeker->id}/impersonate");
        $responseImpersonate->assertRedirect(route('dashboard'));

        $this->assertEquals($seeker->id, Auth::id());
        $this->assertTrue(session()->has('impersonator_id'));
        $this->assertEquals($admin->id, session('impersonator_id'));

        // Revert Impersonation
        $responseRevert = $this->post('/admin/impersonate/revert');
        $responseRevert->assertRedirect(route('admin.users.index'));

        $this->assertEquals($admin->id, Auth::id());
        $this->assertFalse(session()->has('impersonator_id'));
    }
}
