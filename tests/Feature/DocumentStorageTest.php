<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\JobSeekerProfile;
use App\Models\Application;
use App\Models\Category;
use App\Models\Resume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentStorageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.google.document_driver' => 'google']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'job_seeker']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employer']);
    }

    public function test_seeker_uploads_resume_to_google_drive()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');
        JobSeekerProfile::create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('my_resume.pdf', 500, 'application/pdf');

        $response = $this->actingAs($user)->post('/seeker/profile/resume', [
            'title' => 'Google Drive Resume',
            'resume_file' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('resumes', [
            'user_id' => $user->id,
            'title' => 'Google Drive Resume',
            'original_name' => 'my_resume.pdf',
            'mime_type' => 'application/pdf',
            'extension' => 'pdf',
        ]);
        
        $resume = Resume::where('user_id', $user->id)->first();
        $this->assertNotNull($resume->google_drive_file_id);
    }

    public function test_seeker_downloads_resume_from_google_drive()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');

        $resume = Resume::create([
            'user_id' => $user->id,
            'title' => 'My Resume',
            'file_path' => 'resumes/mock_drive_id',
            'google_drive_file_id' => 'mock_drive_id',
            'original_name' => 'resume.pdf',
            'mime_type' => 'application/pdf',
            'extension' => 'pdf',
            'file_size' => 12345,
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->get("/seeker/profile/resume/{$resume->id}/download");

        $response->assertStatus(200);
        $this->assertEquals('mock_document_content', $response->getContent());
        $response->assertHeader('Content-Disposition', 'attachment; filename="resume.pdf"');
    }

    public function test_employer_downloads_candidate_resume_from_google_drive()
    {
        $employer = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $employer->assignRole('employer');
        
        $company = Company::create([
            'company_name' => 'Acme Inc',
            'slug' => 'acme-inc',
            'verification_status' => 'verified',
        ]);
        
        EmployerProfile::create([
            'user_id' => $employer->id,
            'company_id' => $company->id,
            'designation' => 'HR Manager',
        ]);

        $candidate = User::factory()->create();
        $resume = Resume::create([
            'user_id' => $candidate->id,
            'title' => 'My Resume',
            'file_path' => 'resumes/mock_drive_id',
            'google_drive_file_id' => 'mock_drive_id',
            'original_name' => 'resume.pdf',
            'mime_type' => 'application/pdf',
            'extension' => 'pdf',
            'file_size' => 12345,
            'is_default' => true,
        ]);

        $category = Category::create([
            'name' => 'IT Services',
            'slug' => 'it-services',
        ]);

        $job = Job::create([
            'employer_id' => $employer->id,
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'Developer',
            'slug' => 'developer-' . uniqid(),
            'description' => 'Laravel description',
            'employment_type' => 'full_time',
            'workplace_type' => 'remote',
            'experience_level' => 'mid',
            'location' => 'Toronto',
            'city' => 'Toronto',
            'status' => 'published',
        ]);

        $application = Application::create([
            'job_id' => $job->id,
            'applicant_id' => $candidate->id,
            'resume_id' => $resume->id,
            'status' => 'applied',
        ]);

        $response = $this->actingAs($employer)->get("/employer/applicants/{$application->id}/download");

        $response->assertStatus(200);
        $this->assertEquals('mock_document_content', $response->getContent());
    }

    public function test_seeker_uploads_resume_locally_when_configured()
    {
        config(['services.google.document_driver' => 'local']);
        Storage::fake('private');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');
        JobSeekerProfile::create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->create('my_resume.pdf', 500, 'application/pdf');

        $response = $this->actingAs($user)->post('/seeker/profile/resume', [
            'title' => 'Local Resume',
            'resume_file' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('resumes', [
            'user_id' => $user->id,
            'title' => 'Local Resume',
            'original_name' => 'my_resume.pdf',
            'google_drive_file_id' => null,
        ]);

        $resume = Resume::where('user_id', $user->id)->first();
        Storage::disk('private')->assertExists($resume->file_path);
    }
}
