<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class UserCredentialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = User::create([
                'first_name' => 'System',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $admin->assignRole('admin');
        } else {
            $admin->update(['password' => 'password']);
        }

        // 2. Create Employer User
        $employer = User::where('email', 'drtoolofficial@gmail.com')->first();
        if (!$employer) {
            $employer = User::create([
                'first_name' => 'Jane',
                'last_name' => 'Recruiter',
                'email' => 'drtoolofficial@gmail.com',
                'password' => 'password',
                'role' => 'employer',
                'email_verified_at' => now(),
            ]);
            $employer->assignRole('employer');
        } else {
            $employer->update(['password' => 'password']);
        }

        // 3. Create Job Seeker User
        $seeker = User::where('email', 'muhamamdmaaz85@gmail.com')->first();
        if (!$seeker) {
            $seeker = User::create([
                'first_name' => 'Muhammad',
                'last_name' => 'Maaz',
                'email' => 'muhamamdmaaz85@gmail.com',
                'password' => 'password',
                'role' => 'job_seeker',
                'phone' => '+15550199',
                'city' => 'Toronto',
                'country' => 'Canada',
                'email_verified_at' => now(),
            ]);
            $seeker->assignRole('job_seeker');
        } else {
            $seeker->update(['password' => 'password']);
        }

        // 4. Populate Seeker Profile & Resumes to bypass completeness block (Needs to be >= 20%)
        $profile = JobSeekerProfile::where('user_id', $seeker->id)->first();
        if (!$profile) {
            $profile = JobSeekerProfile::create([
                'user_id' => $seeker->id,
                'headline' => 'Full-Stack Software Engineer',
                'summary' => 'Experienced developer specializing in Node.js backend architecture, Laravel APIs, and React single-page applications. Dedicated to writing clean code and scaling platforms.',
                'experience_years' => 3,
                'website' => 'https://github.com/muhammadmaaz-2k5',
            ]);

            // Add Education record
            Education::create([
                'user_id' => $seeker->id,
                'institution' => 'University of Peshawar',
                'degree' => 'BSc in Computer Science',
                'field_of_study' => 'Software Engineering',
                'start_date' => '2021-09-01',
                'end_date' => '2025-05-31',
            ]);

            // Add Experience record
            Experience::create([
                'user_id' => $seeker->id,
                'company' => 'Spark Zone Technologies',
                'designation' => 'MERN/Full Stack Developer',
                'employment_type' => 'full_time',
                'start_date' => '2025-01-01',
                'end_date' => '2025-10-31',
                'currently_working' => false,
                'description' => 'Developed scalable web applications using Node.js and Express.js, building RESTful APIs and server-side architecture for production applications.',
            ]);

            // Attach default skills to Seeker Profile
            $laravel = Skill::where('name', 'Laravel')->first();
            $php = Skill::where('name', 'PHP')->first();
            $react = Skill::where('name', 'React')->first();
            
            $skillsToAttach = array_filter([$laravel->id ?? null, $php->id ?? null, $react->id ?? null]);
            if (!empty($skillsToAttach)) {
                $seeker->skills()->sync($skillsToAttach);
            }
        }
    }
}
