<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\JobSeekerProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CloudinaryMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'job_seeker']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employer']);
    }

    public function test_seeker_uploads_profile_photo_to_cloudinary()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');

        Http::fake([
            'https://api.cloudinary.com/v1_1/*' => Http::response([
                'secure_url' => 'https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png',
                'public_id' => 'job-portal/profile-images/test_public_id',
            ], 200)
        ]);

        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->put('/seeker/profile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '12345678',
            'profile_photo' => $file,
        ]);

        $response->assertRedirect();
        
        $user->refresh();
        $this->assertEquals('https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png', $user->profile_photo);
        $this->assertEquals('job-portal/profile-images/test_public_id', $user->profile_photo_public_id);
    }

    public function test_seeker_replaces_profile_photo_triggers_cloudinary_deletion()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'profile_photo' => 'https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png',
            'profile_photo_public_id' => 'job-portal/profile-images/old_public_id',
        ]);
        $user->assignRole('job_seeker');

        Http::fake([
            'https://api.cloudinary.com/v1_1/*/image/destroy' => Http::response(['result' => 'ok'], 200),
            'https://api.cloudinary.com/v1_1/*/image/upload' => Http::response([
                'secure_url' => 'https://res.cloudinary.com/dgz4l65ly/image/upload/v5678/new.png',
                'public_id' => 'job-portal/profile-images/new_public_id',
            ], 200)
        ]);

        $file = UploadedFile::fake()->create('new_avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->put('/seeker/profile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '12345678',
            'profile_photo' => $file,
        ]);

        $response->assertRedirect();

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'image/destroy') && $request['public_id'] === 'job-portal/profile-images/old_public_id';
        });

        $user->refresh();
        $this->assertEquals('https://res.cloudinary.com/dgz4l65ly/image/upload/v5678/new.png', $user->profile_photo);
        $this->assertEquals('job-portal/profile-images/new_public_id', $user->profile_photo_public_id);
    }

    public function test_employer_uploads_logo_and_cover_to_cloudinary()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('employer');
        
        $company = Company::create([
            'company_name' => 'Acme Corp',
            'slug' => 'acme-corp',
        ]);

        $employerProfile = EmployerProfile::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'designation' => 'CEO',
        ]);

        Http::fake([
            'https://api.cloudinary.com/v1_1/*' => Http::response([
                'secure_url' => 'https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png',
                'public_id' => 'job-portal/test_public_id',
            ], 200)
        ]);

        $logo = UploadedFile::fake()->create('logo.jpg', 100, 'image/jpeg');
        $cover = UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->put('/employer/profile', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone' => '11223344',
            'designation' => 'CEO',
            'company_name' => 'Acme Corp',
            'website' => 'https://acme.com',
            'industry' => 'Tech',
            'company_size' => '10-50',
            'logo' => $logo,
            'cover_image' => $cover,
        ]);

        $response->assertRedirect();

        $company->refresh();
        $this->assertEquals('https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png', $company->logo);
        $this->assertEquals('job-portal/test_public_id', $company->logo_public_id);
        $this->assertEquals('https://res.cloudinary.com/dgz4l65ly/image/upload/v1234/test.png', $company->cover_image);
        $this->assertEquals('job-portal/test_public_id', $company->cover_image_public_id);
    }
}
