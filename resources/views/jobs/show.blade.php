<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} - JOBZ IN CANADA</title>
    <!-- Fonts -->
    
    
    
    <!-- Scripts & Styles -->
    

    <!-- Structured Data (JSON-LD JobPosting & Breadcrumbs Schema) -->
    @push('head')
    <script type="application/ld+json">
    [
        {
            "@@context": "https://schema.org",
            "@@type": "JobPosting",
            "title": "{{ $job->title }}",
            "description": "{!! e(strip_tags($job->description)) !!}",
            "datePosted": "{{ $job->created_at->toIso8601String() }}",
            @if($job->application_deadline)
            "validThrough": "{{ \Carbon\Carbon::parse($job->application_deadline)->toIso8601String() }}",
            @endif
            "employmentType": "{{ strtoupper($job->employment_type) }}",
            "hiringOrganization": {
                "@@type": "Organization",
                "name": "{{ $job->company->company_name }}",
                "sameAs": "{{ $job->company->website }}"
            },
            "jobLocation": {
                "@@type": "Place",
                "address": {
                    "@@type": "PostalAddress",
                    "addressLocality": "{{ $job->city }}",
                    "addressCountry": "{{ $job->country }}"
                }
            },
            @if($job->salary_min)
            "baseSalary": {
                "@@type": "MonetaryAmount",
                "currency": "{{ $job->currency ?: 'CAD' }}",
                "value": {
                    "@@type": "QuantitativeValue",
                    "value": {{ $job->salary_min }},
                    "unitText": "{{ strtoupper($job->salary_type ?: 'YEAR') }}"
                }
            }
            @endif
        },
        {
            "@@context": "https://schema.org",
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Jobs",
                    "item": "{{ route('jobs.index') }}"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "{{ $job->title }}",
                    "item": "{{ route('jobs.show', $job->slug) }}"
                }
            ]
        }
    ]
    </script>
    @endpush
</head>
<body>

    <!-- Premium Mesh and Blobs Background -->
    <div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Header Navbar -->
    <header>
        <div>
            <!-- Brand Logo -->
            <a href="/">
                <div>
                    <span>J</span>
                </div>
                <span>JOBZ IN <span>CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav>
                <a href="{{ route('home') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('jobs.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Companies
                </a>
            </nav>

            <!-- Actions Panel -->
            <div>
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <div>
        <div>

            <!-- Back to Jobs Navigation -->
            <div>
                <a href="{{ route('jobs.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Jobs
                </a>
            </div>

            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Spectacular Header Banner (Exact Image 4 Style) -->
            <div>
                <!-- Left: Logo & Meta Info -->
                <div>
                    <!-- Logo Box with hover lift -->
                    @php
                        $initials = strtoupper(substr($job->company->company_name, 0, 2));
                        $bgColors = [
                            'Shopify Canada' => 'bg-blue-600',
                            'TechNorth Solutions' => 'bg-teal-600',
                            'Maple Finance Group' => 'bg-amber-700',
                            'Northern Health Systems' => 'bg-emerald-600',
                            'CanBridge Engineering' => 'bg-indigo-650',
                        ];
                        $bgClass = $bgColors[$job->company->company_name] ?? 'bg-primary-600';
                        
                        $user = Auth::user();
                        $isSeeker = $user && $user->hasRole('job_seeker');
                        $isEmployer = $user && $user->hasRole('employer') && $job->employer_id === $user->id;
                        
                        $hasApplied = false;
                        $isClosed = false;
                        $completeness = 0;
                        
                        if ($isSeeker) {
                            $hasApplied = \App\Models\Application::where('job_id', $job->id)
                                ->where('applicant_id', $user->id)
                                ->where('status', '!=', 'withdrawn')
                                ->exists();
                            $isClosed = $job->status === 'closed' || ($job->application_deadline && \Carbon\Carbon::parse($job->application_deadline)->isPast());
                            $completeness = $user->jobSeekerProfile ? $user->jobSeekerProfile->calculateCompletionPercentage() : 0;
                        }
                    @endphp
                    <div>
                        @if($job->company->logo)
                            <img src="{{ $job->company->logo }}" alt="Logo" />
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                    <div>
                        <!-- Badges Row -->
                        <div>
                            @if($job->featured)
                                <span>Featured</span>
                            @endif
                            @if($job->screeningQuestions->count() === 0)
                                <span>Easy Apply</span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h1>{{ $job->title }}</h1>

                        <!-- Company name & verified badge -->
                        <div>
                            <a href="{{ route('companies.show', $job->company->slug) }}">{{ $job->company->company_name }}</a>
                            @if($job->company->verification_status === 'verified')
                                <span>✓</span>
                            @endif
                        </div>

                        <!-- Meta Info Row -->
                        <div>
                            <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                            <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                            <span>⏰ {{ $job->created_at->diffForHumans() }}</span>
                            <span>👥 {{ $job->vacancies ?: 1 }} opening</span>
                        </div>
                    </div>
                </div>

                <!-- Right: CTA Actions -->
                <div>
                    <button type="button" title="Save Job">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <button type="button" title="Share Job">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742a3 3 0 110 2.516m0-2.516a3 3 0 115.317-1.954m-5.317 1.954a3 3 0 115.317 1.954m-5.317-1.954L15.32 7.18m-6.636 6.078l6.637 3.32"/></svg>
                    </button>

                    @guest
                        <a href="{{ route('login') }}">
                            Easy Apply
                        </a>
                    @else
                        @if($isSeeker)
                            @if($hasApplied)
                                <button disabled>
                                    Already Applied
                                </button>
                            @elseif($isClosed)
                                <button disabled>
                                    Application Closed
                                </button>
                            @elseif($completeness < 20)
                                <a href="{{ route('seeker.profile.edit') }}" title="Min 20% profile completeness required to apply">
                                    Profile Incomplete (Min 20%)
                                </a>
                            @else
                                <a href="{{ route('jobs.apply', $job->slug) }}">
                                    Easy Apply
                                </a>
                            @endif
                        @elseif($isEmployer)
                            <a href="{{ route('employer.applicants.job', $job->id) }}">
                                View Applicants ({{ $job->applications_count }})
                            </a>
                        @else
                            <button>
                                Easy Apply (Preview)
                            </button>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Under Header: 4 Quick Stat Cards -->
            <div>
                <div>
                    <span>Salary Range</span>
                    <span>
                        @if($job->salary_min)
                            ${{ number_format($job->salary_min / 1000) }}k - ${{ number_format($job->salary_max / 1000) }}k /yr
                        @else
                            Competitive Salary
                        @endif
                    </span>
                </div>
                <div>
                    <span>Workplace</span>
                    <span>{{ $job->workplace_type }}</span>
                </div>
                <div>
                    <span>Experience</span>
                    <span>{{ $job->experience_level }}</span>
                </div>
                <div>
                    <span>Category</span>
                    <span>{{ $job->category ? $job->category->name : 'Technology' }}</span>
                </div>
            </div>

            <!-- Detailed Grid Column Structure -->
            <div>
                
                <!-- Left Main Content Column -->
                <div>
                    <x-card variant="default">
                        <div>
                            <!-- Job Description -->
                            <div>
                                <h3>
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Job Description
                                </h3>
                                <div></div>
                                <p>{{ $job->description }}</p>
                            </div>

                            <!-- Responsibilities -->
                            @if($job->responsibilities)
                                <div>
                                    <h3>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Key Responsibilities
                                    </h3>
                                    <div></div>
                                    <div>
                                        @php $i = 1; @endphp
                                        @foreach(explode("\n", $job->responsibilities) as $line)
                                            @if(trim($line))
                                                <div>
                                                    <span>{{ $i++ }}</span>
                                                    <p>{{ trim($line) }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Requirements -->
                            <div>
                                <h3>
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Requirements
                                </h3>
                                <div></div>
                                <div>
                                    @foreach(explode("\n", $job->requirements) as $line)
                                        @if(trim($line))
                                            <div>
                                                <span>✓</span>
                                                <p>{{ trim($line) }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Benefits -->
                            @if($job->benefits)
                                <div>
                                    <h3>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7.463 8.2l.003-.003.003-.003m0 0L7.5 12.5M4.537 16.2l3.39 3.39m0 0L9.5 17.5M8.2 19.5h11.5M19.5 8.2v11.5"/></svg>
                                        Benefits
                                    </h3>
                                    <div></div>
                                    <div>
                                        @foreach(explode("\n", $job->benefits) as $line)
                                            @if(trim($line))
                                                <div>
                                                    <span>🎁</span>
                                                    <p>{{ trim($line) }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-card>

                    <!-- Related Jobs Recommendation -->
                    <div>
                        <h3>Related Opportunities</h3>
                        <div>
                            @forelse($relatedJobs as $rel)
                                @php
                                    $relInitials = strtoupper(substr($rel->company->company_name, 0, 2));
                                    $relBgColors = [
                                        'Shopify Canada' => 'bg-blue-600',
                                        'TechNorth Solutions' => 'bg-teal-600',
                                        'Maple Finance Group' => 'bg-amber-700',
                                        'Northern Health Systems' => 'bg-emerald-600',
                                        'CanBridge Engineering' => 'bg-indigo-650',
                                    ];
                                    $relBgClass = $relBgColors[$rel->company->company_name] ?? 'bg-primary-600';
                                @endphp
                                <x-card variant="default">
                                    <div>
                                        <div>
                                            @if($rel->company->logo)
                                                <img src="{{ $rel->company->logo }}" alt="Logo" />
                                            @else
                                                {{ $relInitials }}
                                            @endif
                                        </div>
                                        <div>
                                            <h4>
                                                <a href="{{ route('jobs.show', $rel->slug) }}">{{ $rel->title }}</a>
                                            </h4>
                                            <p>{{ $rel->company->company_name }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span>{{ ucfirst($rel->workplace_type) }}</span>
                                        <span>
                                            @if($rel->salary_min)
                                                ${{ number_format($rel->salary_min/1000) }}k - ${{ number_format($rel->salary_max/1000) }}k
                                            @else
                                                Competitive
                                            @endif
                                        </span>
                                    </div>
                                </x-card>
                            @empty
                                <!-- Modern Empty State for Related Jobs -->
                                <div>
                                    <div>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <div>
                                        <h4>No related opportunities found</h4>
                                        <p>We couldn't find other open jobs matching this category right now.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Details Panel (Sticky on scroll) -->
                <div>
                    
                    <!-- Job Overview Stat Table -->
                    <x-card variant="default">
                        <x-slot name="header">Job Overview</x-slot>
                        
                        <div>
                            <div>
                                <span>Posted:</span>
                                <span>{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                <span>Type:</span>
                                <span>{{ str_replace('_', '-', $job->employment_type) }}</span>
                            </div>
                            <div>
                                <span>Workplace:</span>
                                <span>{{ $job->workplace_type }}</span>
                            </div>
                            <div>
                                <span>Vacancies:</span>
                                <span>{{ $job->vacancies ?: 1 }} opening</span>
                            </div>
                            <div>
                                <span>Views:</span>
                                <span>{{ $job->views_count }} views</span>
                            </div>
                            <div>
                                <span>Level:</span>
                                <span>{{ $job->experience_level }}</span>
                            </div>
                            @if($job->application_deadline)
                                <div>
                                    <span>Deadline:</span>
                                    <span>{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </x-card>

                    <!-- Required Skills checklist with Unified Borders and Category Icons -->
                    <x-card variant="default">
                        <x-slot name="header">Required Skills</x-slot>
                        <div>
                            @forelse($job->skills as $skill)
                                @php
                                    $isBackend = in_array(strtolower($skill->name), ['laravel', 'php', 'mysql', 'postgres', 'redis', 'api']);
                                    $isFrontend = in_array(strtolower($skill->name), ['react', 'tailwind css', 'javascript', 'css', 'html', 'next.js']);
                                    $icon = $isBackend ? '⚙️' : ($isFrontend ? '💻' : '🏷️');
                                @endphp
                                <span>
                                    {{ $icon }} {{ $skill->name }}
                                </span>
                            @empty
                                <span>No specific skills listed.</span>
                            @endforelse
                        </div>
                    </x-card>

                    <!-- Employer Branding Card -->
                    <x-card variant="default">
                        <x-slot name="header">About Company</x-slot>
                        @php
                            $compInitials = strtoupper(substr($job->company->company_name, 0, 2));
                            $compBgColors = [
                                'Shopify Canada' => 'bg-blue-600',
                                'TechNorth Solutions' => 'bg-teal-600',
                                'Maple Finance Group' => 'bg-amber-700',
                                'Northern Health Systems' => 'bg-emerald-600',
                                'CanBridge Engineering' => 'bg-indigo-650',
                            ];
                            $compBgClass = $compBgColors[$job->company->company_name] ?? 'bg-primary-600';
                            
                            $compFollowers = 12400;
                            if ($job->company->company_name === 'Shopify Canada') { $compFollowers = 12400; }
                            elseif ($job->company->company_name === 'TechNorth Solutions') { $compFollowers = 3200; }
                            elseif ($job->company->company_name === 'Maple Finance Group') { $compFollowers = 8900; }
                            elseif ($job->company->company_name === 'Northern Health Systems') { $compFollowers = 5600; }
                            elseif ($job->company->company_name === 'CanBridge Engineering') { $compFollowers = 2100; }
                            
                            $followersFormatted = $compFollowers >= 1000 ? number_format($compFollowers / 1000, 1) . 'k' : $compFollowers;
                        @endphp
                        
                        <div>
                            @if($job->company->logo)
                                <img src="{{ $job->company->logo }}" alt="Logo" />
                            @else
                                {{ $compInitials }}
                            @endif
                        </div>
                        <div>
                            <h4>
                                <a href="{{ route('companies.show', $job->company->slug) }}">{{ $job->company->company_name }}</a>
                            </h4>
                            <span>{{ $job->company->industry }} &bull; {{ $followersFormatted }} followers</span>
                        </div>
                        @if($job->company->description)
                            <p>{{ $job->company->description }}</p>
                        @endif
                        <div>
                            <a href="{{ route('companies.show', $job->company->slug) }}">View Company Profile</a>
                        </div>
                    </x-card>

                </div>
            </div>

        </div>
    </div>

    <!-- Sticky Bottom Mobile Action Bar -->
    <div>
        <div>
            <h4>{{ $job->title }}</h4>
            <p>{{ $job->company->company_name }}</p>
        </div>
        
        <div>
            @guest
                <a href="{{ route('login') }}">
                    Apply
                </a>
            @else
                @if($isSeeker)
                    @if($hasApplied)
                        <button disabled>Applied</button>
                    @elseif($isClosed)
                        <button disabled>Closed</button>
                    @elseif($completeness < 20)
                        <a href="{{ route('seeker.profile.edit') }}">Profile</a>
                    @else
                        <a href="{{ route('jobs.apply', $job->slug) }}">
                            Apply
                        </a>
                    @endif
                @elseif($isEmployer)
                    <a href="{{ route('employer.applicants.job', $job->id) }}">
                        Applicants
                    </a>
                @else
                    <button>
                        Apply
                    </button>
                @endif
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div>
            <p>© {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div>
                <a href="#">Terms of Service</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
