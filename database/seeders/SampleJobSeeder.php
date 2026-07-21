<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use App\Models\EmployerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure we have an Employer User to own the jobs
        $employer = User::where('email', 'employer@example.com')->first();
        if (!$employer) {
            $employer = User::create([
                'first_name' => 'John',
                'last_name' => 'Recruiter',
                'email' => 'employer@example.com',
                'password' => bcrypt('password'),
            ]);
            $employer->assignRole('employer');
        }

        // 2. Seed Sample Companies
        $companies = [
            [
                'name' => 'Shopify Canada',
                'website' => 'https://www.shopify.ca',
                'industry' => 'E-commerce & Tech',
                'company_size' => '10000+ employees',
                'founded_year' => 2006,
                'headquarters' => 'Ottawa, ON',
                'description' => 'Shopify is a leading global commerce company, providing trusted tools to start, grow, market, and manage a retail business of any size.',
            ],
            [
                'name' => 'TechNorth Solutions',
                'website' => 'https://www.technorth.ca',
                'industry' => 'Software & Cloud',
                'company_size' => '500-1000 employees',
                'founded_year' => 2012,
                'headquarters' => 'Vancouver, BC',
                'description' => 'TechNorth Solutions is a premier Canadian technology firm specializing in cloud infrastructure, DevOps automation, and enterprise software delivery.',
            ],
            [
                'name' => 'Maple Finance Group',
                'website' => 'https://www.maplefinance.ca',
                'industry' => 'Finance & Banking',
                'company_size' => '1000-5000 employees',
                'founded_year' => 2010,
                'headquarters' => 'Toronto, ON',
                'description' => 'Maple Finance Group is a modern financial technology institution offering secure banking services, investment solutions, and commercial financing across Canada.',
            ],
            [
                'name' => 'Northern Health Systems',
                'website' => 'https://www.northernhealth.ca',
                'industry' => 'Healthcare',
                'company_size' => '5000+ employees',
                'founded_year' => 1998,
                'headquarters' => 'Prince George, BC',
                'description' => 'Northern Health Systems provides premium medical care, telehealth services, and hospital management solutions to northern Canadian communities.',
            ],
            [
                'name' => 'CanBridge Engineering',
                'website' => 'https://www.canbridge.ca',
                'industry' => 'Engineering & Construction',
                'company_size' => '200-500 employees',
                'founded_year' => 2008,
                'headquarters' => 'Calgary, AB',
                'description' => 'CanBridge Engineering is an infrastructure development firm focusing on sustainable civil engineering, bridge design, and urban transport projects.',
            ]
        ];

        $seededCompanies = [];
        foreach ($companies as $comp) {
            // First check if the company already exists to prevent duplicates
            $company = Company::where('company_name', $comp['name'])->first();
            if (!$company) {
                $company = Company::create([
                    'company_name' => $comp['name'],
                    'slug' => Str::slug($comp['name']),
                    'website' => $comp['website'],
                    'industry' => $comp['industry'],
                    'company_size' => $comp['company_size'],
                    'founded_year' => $comp['founded_year'],
                    'headquarters' => $comp['headquarters'],
                    'description' => $comp['description'],
                    'verification_status' => 'verified',
                ]);
            }
            $seededCompanies[] = $company;

            // Associate the employer with this company profile
            EmployerProfile::updateOrCreate(
                ['user_id' => $employer->id],
                ['company_id' => $company->id]
            );
        }

        // 3. Retrieve Categories & Skills
        $softwareDev = Category::where('name', 'Software Development')->first();
        $devOps = Category::where('name', 'DevOps')->first();

        $laravel = Skill::where('name', 'Laravel')->first();
        $php = Skill::where('name', 'PHP')->first();
        $react = Skill::where('name', 'React')->first();
        $docker = Skill::where('name', 'Docker')->first();
        $aws = Skill::where('name', 'AWS')->first();
        $tailwind = Skill::where('name', 'Tailwind CSS')->first();

        // 4. Seed Published Job Postings
        $jobs = [
            [
                'company' => $seededCompanies[0], // Shopify
                'category' => $softwareDev,
                'title' => 'Senior Full-Stack Architect (PHP & React)',
                'description' => 'We are looking for a Senior Full-Stack Architect to join our engineering division. You will build and scale high-performance merchant dashboards using PHP, Laravel, and React.',
                'responsibilities' => "Design robust RESTful APIs.\nLead front-end architectural decisions using React and TypeScript.\nMentor junior software engineers and review pull requests.",
                'requirements' => "5+ years of production experience with Laravel or other PHP frameworks.\nDeep knowledge of React and state management libraries.\nExperience scaling applications to support millions of concurrent actions.",
                'benefits' => 'Competitive salary & stock options.\n100% remote work flexibility anywhere in Canada.\nComprehensive dental and vision healthcare coverage.',
                'employment_type' => 'full-time',
                'workplace_type' => 'remote',
                'experience_level' => 'senior',
                'salary_min' => 115000,
                'salary_max' => 155000,
                'currency' => 'CAD',
                'location' => 'Toronto, ON',
                'city' => 'Toronto',
                'featured' => true,
                'urgent' => false,
                'skills' => [$laravel, $php, $react, $tailwind],
            ],
            [
                'company' => $seededCompanies[1], // TechNorth
                'category' => $devOps,
                'title' => 'Lead DevOps Engineer (AWS & Docker)',
                'description' => 'TechNorth Solutions is hiring a Lead DevOps Engineer to automate deployment strategies, build secure infrastructure pipelines, and monitor server health across multi-region AWS environments.',
                'responsibilities' => "Maintain infrastructure-as-code using Terraform.\nConstruct zero-downtime CI/CD deployment jobs.\nSupervise database backups, clusters, and Redis caching layers.",
                'requirements' => "Strong background with Docker containers and Kubernetes clusters.\nExpertise configuring Amazon Web Services (VPCs, EC2, ECS, RDS).\nFamiliarity with Shell scripting and server performance diagnostics.",
                'benefits' => 'Flexible working hours (hybrid options).\nAnnual wellness benefits package.\nPaid time off and Canadian holidays match.',
                'employment_type' => 'full-time',
                'workplace_type' => 'hybrid',
                'experience_level' => 'senior',
                'salary_min' => 125000,
                'salary_max' => 165000,
                'currency' => 'CAD',
                'location' => 'Vancouver, BC',
                'city' => 'Vancouver',
                'featured' => false,
                'urgent' => true,
                'skills' => [$docker, $aws],
            ]
        ];

        foreach ($jobs as $j) {
            $slug = Str::slug($j['title']);
            // Check if job already exists to prevent duplicate entries
            $jobExists = Job::where('title', $j['title'])->where('company_id', $j['company']->id)->exists();
            if (!$jobExists) {
                $newJob = Job::create([
                    'company_id' => $j['company']->id,
                    'employer_id' => $employer->id,
                    'category_id' => $j['category']->id ?? null,
                    'title' => $j['title'],
                    'slug' => $slug . '-' . rand(100, 999),
                    'description' => $j['description'],
                    'responsibilities' => $j['responsibilities'],
                    'requirements' => $j['requirements'],
                    'benefits' => $j['benefits'],
                    'employment_type' => $j['employment_type'],
                    'workplace_type' => $j['workplace_type'],
                    'experience_level' => $j['experience_level'],
                    'salary_type' => 'yearly',
                    'salary_min' => $j['salary_min'],
                    'salary_max' => $j['salary_max'],
                    'currency' => $j['currency'],
                    'location' => $j['location'],
                    'city' => $j['city'],
                    'status' => 'published',
                    'featured' => $j['featured'],
                    'urgent' => $j['urgent'],
                    'published_at' => now(),
                ]);

                if (!empty($j['skills'])) {
                    $newJob->skills()->attach(array_filter(array_map(fn($s) => $s->id ?? null, $j['skills'])));
                }
            }
        }
    }
}
