<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\JobSeekerProfile;
use App\Models\Job;
use App\Models\Resume;
use App\Models\Application;
use App\Models\ScreeningQuestion;
use App\Models\ScreeningAnswer;
use App\Models\ApplicationStatusHistory;
use App\Models\ResumeDownload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApplicationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        Role::firstOrCreate(['name' => 'job_seeker']);
        Role::firstOrCreate(['name' => 'employer']);
        Storage::fake('private');
    }

    private function createJobSeeker()
    {
        $user = User::factory()->create([
            'role' => 'job_seeker',
            'first_name' => 'Candidate',
            'last_name' => 'One',
            'profile_photo' => 'photos/candidate.jpg'
        ]);
        $user->assignRole('job_seeker');

        // Setup Seeker profile with completeness >= 20%
        // Profile photo (10%) + Headline (8%) + Summary (7%) = 25%
        JobSeekerProfile::create([
            'user_id' => $user->id,
            'headline' => 'Full Stack Developer',
            'summary' => 'I love writing PHP and Javascript.',
            'city' => 'Toronto',
            'country' => 'Canada'
        ]);

        return $user;
    }

    private function createEmployerAndJob()
    {
        $user = User::factory()->create([
            'role' => 'employer',
            'first_name' => 'Employer',
            'last_name' => 'Lead'
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

        $category = Category::create([
            'name' => 'Engineering',
            'slug' => 'engineering'
        ]);

        $job = Job::create([
            'company_id' => $company->id,
            'employer_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Laravel Backend Developer',
            'slug' => 'laravel-backend-developer',
            'description' => 'Looking for backend dev.',
            'requirements' => 'PHP expertise.',
            'vacancies' => 1,
            'employment_type' => 'full-time',
            'workplace_type' => 'remote',
            'experience_level' => 'mid',
            'education_level' => 'not-required',
            'salary_visibility' => 'hidden',
            'currency' => 'CAD',
            'salary_period' => 'yearly',
            'country' => 'Canada',
            'city' => 'Toronto',
            'location' => 'Toronto',
            'status' => 'published'
        ]);

        return [$user, $job];
    }

    public function test_candidate_can_apply_to_job_with_screening_questions()
    {
        $seeker = $this->createJobSeeker();
        [$employer, $job] = $this->createEmployerAndJob();

        // Create a screening question
        $q = ScreeningQuestion::create([
            'job_id' => $job->id,
            'question_text' => 'How many years of Laravel experience?',
            'is_required' => true
        ]);

        $resumeFile = UploadedFile::fake()->create('my_resume.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($seeker)->post("/jobs/{$job->slug}/apply", [
            'resume_option' => 'new',
            'resume_title' => 'My Developer Resume',
            'resume_file' => $resumeFile,
            'cover_letter' => 'I would love to apply for this backend position.',
            'answers' => [
                $q->id => '3 years'
            ]
        ]);

        $response->assertRedirect(route('seeker.applications.index'));

        // Assert Application DB record
        $this->assertDatabaseHas('applications', [
            'job_id' => $job->id,
            'applicant_id' => $seeker->id,
            'status' => 'applied'
        ]);

        $app = Application::where('job_id', $job->id)->where('applicant_id', $seeker->id)->first();
        $this->assertNotNull($app);

        // Assert Screening Answer
        $this->assertDatabaseHas('screening_answers', [
            'application_id' => $app->id,
            'question_id' => $q->id,
            'answer' => '3 years'
        ]);

        // Assert Status History Logs
        $this->assertDatabaseHas('application_status_histories', [
            'application_id' => $app->id,
            'new_status' => 'applied'
        ]);

        // Assert Notifications triggered (both seeker and employer have entries in notifications)
        $this->assertDatabaseHas('notifications', [
            'user_id' => $seeker->id,
            'type' => 'submitted'
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $employer->id,
            'type' => 'employer_alert'
        ]);
    }

    public function test_candidate_cannot_submit_duplicate_applications()
    {
        $seeker = $this->createJobSeeker();
        [$employer, $job] = $this->createEmployerAndJob();

        $resume = Resume::create([
            'user_id' => $seeker->id,
            'title' => 'General Resume',
            'file_path' => 'resumes/gen.pdf',
            'original_name' => 'gen.pdf',
            'file_size' => 1024,
            'is_default' => true
        ]);

        // Create an existing application
        Application::create([
            'job_id' => $job->id,
            'applicant_id' => $seeker->id,
            'resume_id' => $resume->id,
            'status' => 'applied',
            'applied_at' => now()
        ]);

        // Try applying again
        $response = $this->actingAs($seeker)->post("/jobs/{$job->slug}/apply", [
            'resume_option' => 'library',
            'resume_id' => $resume->id,
            'cover_letter' => 'Trying again.'
        ]);

        $response->assertRedirect();
        // The candidate still has exactly 1 application
        $this->assertEquals(1, Application::where('job_id', $job->id)->where('applicant_id', $seeker->id)->count());
    }

    public function test_candidate_can_withdraw_application()
    {
        $seeker = $this->createJobSeeker();
        [$employer, $job] = $this->createEmployerAndJob();

        $resume = Resume::create([
            'user_id' => $seeker->id,
            'title' => 'General Resume',
            'file_path' => 'resumes/gen.pdf',
            'original_name' => 'gen.pdf',
            'file_size' => 1024,
            'is_default' => true
        ]);

        $app = Application::create([
            'job_id' => $job->id,
            'applicant_id' => $seeker->id,
            'resume_id' => $resume->id,
            'status' => 'applied',
            'applied_at' => now()
        ]);

        $response = $this->actingAs($seeker)->post("/seeker/applications/{$app->id}/withdraw");

        $response->assertRedirect(route('seeker.applications.index'));

        $this->assertDatabaseHas('applications', [
            'id' => $app->id,
            'status' => 'withdrawn'
        ]);

        $app->refresh();
        $this->assertNotNull($app->withdrawn_at);
    }

    public function test_employer_can_change_applicant_status_and_add_notes()
    {
        $seeker = $this->createJobSeeker();
        [$employer, $job] = $this->createEmployerAndJob();

        $resume = Resume::create([
            'user_id' => $seeker->id,
            'title' => 'General Resume',
            'file_path' => 'resumes/gen.pdf',
            'original_name' => 'gen.pdf',
            'file_size' => 1024,
            'is_default' => true
        ]);

        $app = Application::create([
            'job_id' => $job->id,
            'applicant_id' => $seeker->id,
            'resume_id' => $resume->id,
            'status' => 'applied',
            'applied_at' => now()
        ]);

        // Employer updates candidate stage to shortlisted
        $response = $this->actingAs($employer)->post("/employer/applicants/{$app->id}/status", [
            'status' => 'shortlisted',
            'remarks' => 'Outstanding portfolio website.'
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('applications', [
            'id' => $app->id,
            'status' => 'shortlisted'
        ]);

        // Verify status history
        $this->assertDatabaseHas('application_status_histories', [
            'application_id' => $app->id,
            'previous_status' => 'applied',
            'new_status' => 'shortlisted',
            'remarks' => 'Outstanding portfolio website.'
        ]);

        // Employer adds an internal note
        $responseNote = $this->actingAs($employer)->post("/employer/applicants/{$app->id}/note", [
            'note' => 'Strong candidate, will schedule technical test next week.'
        ]);

        $responseNote->assertRedirect();

        $this->assertDatabaseHas('application_notes', [
            'application_id' => $app->id,
            'employer_id' => $employer->id,
            'note' => 'Strong candidate, will schedule technical test next week.'
        ]);
    }

    public function test_resume_download_tracking()
    {
        $seeker = $this->createJobSeeker();
        [$employer, $job] = $this->createEmployerAndJob();

        $resumeFile = UploadedFile::fake()->create('my_resume.pdf', 100, 'application/pdf');
        $path = $resumeFile->store('resumes', 'private');

        $resume = Resume::create([
            'user_id' => $seeker->id,
            'title' => 'General Resume',
            'file_path' => $path,
            'original_name' => 'my_resume.pdf',
            'file_size' => 100,
            'is_default' => true
        ]);

        $app = Application::create([
            'job_id' => $job->id,
            'applicant_id' => $seeker->id,
            'resume_id' => $resume->id,
            'status' => 'applied',
            'applied_at' => now()
        ]);

        // Employer downloads resume
        $response = $this->actingAs($employer)->get("/employer/applicants/{$app->id}/download");

        $response->assertOk();

        // Verify resume download tracked
        $this->assertDatabaseHas('resume_downloads', [
            'employer_id' => $employer->id,
            'candidate_id' => $seeker->id,
            'job_id' => $job->id
        ]);

        // Verify candidate receives viewed notice
        $this->assertDatabaseHas('notifications', [
            'user_id' => $seeker->id,
            'type' => 'resume_downloaded'
        ]);
    }
}
