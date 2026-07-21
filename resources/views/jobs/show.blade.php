<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
<body class="font-sans antialiased text-gray-800 dark:text-gray-250 bg-gray-50/30 dark:bg-dark-955 min-h-screen transition-colors duration-300">

    <!-- Premium Mesh and Blobs Background -->
    <div class="absolute top-0 left-0 right-0 h-[500px] overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-primary-500/10 to-indigo-500/10 dark:from-primary-500/5 dark:to-indigo-500/5 blur-3xl opacity-70"></div>
        <div class="absolute top-[10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-indigo-500/10 to-purple-500/10 dark:from-indigo-500/5 dark:to-purple-500/5 blur-3xl opacity-70"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:4rem_4rem] dark:bg-[size:4rem_4rem]"></div>
    </div>

    <!-- Header Navbar -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-855 shadow-glass no-print">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-2.5 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-650 flex items-center justify-center shadow-md">
                    <span class="text-white font-black text-sm">J</span>
                </div>
                <span class="text-base font-extrabold text-gray-900 dark:text-white leading-none font-display">JOBZ IN <span class="text-primary-500 font-black">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-650 dark:text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Companies
                </a>
            </nav>

            <!-- Actions Panel -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-white dark:bg-dark-800 border border-gray-250 dark:border-gray-855 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-dark-750 transition-colors" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" style="display: none;">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-gray-700 dark:text-gray-200 hover:text-primary-500 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <div class="py-8 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Back to Jobs Navigation -->
            <div class="mb-4">
                <a href="{{ route('jobs.index') }}" class="text-xs font-bold text-gray-500 dark:text-gray-450 hover:text-primary-500 transition-colors flex items-center gap-1.5 no-print">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Jobs
                </a>
            </div>

            @if(session('success'))
                <x-alert type="success" class="mb-4">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Spectacular Header Banner (Exact Image 4 Style) -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pb-6 border-b border-gray-150 dark:border-gray-850">
                <!-- Left: Logo & Meta Info -->
                <div class="flex items-start gap-4">
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
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-sm font-black shadow-inner flex-shrink-0 {{ $bgClass }} border border-gray-250 dark:border-gray-800 transform hover:scale-[1.03] transition-transform duration-300">
                        @if($job->company->logo)
                            <img src="{{ $job->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-2 rounded-2xl" />
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                    <div class="space-y-1.5">
                        <!-- Badges Row -->
                        <div class="flex items-center gap-2">
                            @if($job->featured)
                                <span class="px-2.5 py-0.5 rounded text-[8px] font-extrabold bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30 uppercase tracking-wider">Featured</span>
                            @endif
                            @if($job->screeningQuestions->count() === 0)
                                <span class="px-2.5 py-0.5 rounded text-[8px] font-extrabold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30 uppercase tracking-wider">Easy Apply</span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h1 class="text-xl md:text-2xl font-black text-gray-955 dark:text-white leading-tight font-display tracking-tight">{{ $job->title }}</h1>

                        <!-- Company name & verified badge -->
                        <div class="flex items-center gap-1.5 text-xs text-gray-700 dark:text-gray-300 font-bold">
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="hover:text-primary-500 transition">{{ $job->company->company_name }}</a>
                            @if($job->company->verification_status === 'verified')
                                <span class="inline-flex items-center justify-center w-4 h-4 bg-primary-100 dark:bg-primary-955/40 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold">✓</span>
                            @endif
                        </div>

                        <!-- Meta Info Row -->
                        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 flex-wrap pt-0.5 font-semibold">
                            <span class="flex items-center gap-1">📍 {{ $job->city }}, {{ $job->country }}</span>
                            <span class="flex items-center gap-1">💼 {{ ucfirst($job->workplace_type) }}</span>
                            <span class="flex items-center gap-1">⏰ {{ $job->created_at->diffForHumans() }}</span>
                            <span class="flex items-center gap-1">👥 {{ $job->vacancies ?: 1 }} opening</span>
                        </div>
                    </div>
                </div>

                <!-- Right: CTA Actions -->
                <div class="flex items-center gap-3 w-full md:w-auto shrink-0 relative z-10 pt-4 md:pt-0">
                    <button type="button" class="p-3 rounded-xl border border-gray-250 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:text-rose-500 hover:border-rose-200 transition duration-200" title="Save Job">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <button type="button" class="p-3 rounded-xl border border-gray-250 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-400 transition duration-200" title="Share Job">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742a3 3 0 110 2.516m0-2.516a3 3 0 115.317-1.954m-5.317 1.954a3 3 0 115.317 1.954m-5.317-1.954L15.32 7.18m-6.636 6.078l6.637 3.32"/></svg>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="btn bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-extrabold shadow-md hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center px-6 py-3 rounded-xl uppercase tracking-wider text-xs">
                            Easy Apply
                        </a>
                    @else
                        @if($isSeeker)
                            @if($hasApplied)
                                <button disabled class="btn bg-gray-150 dark:bg-dark-850 text-gray-450 cursor-not-allowed w-full md:w-auto border border-gray-200 dark:border-gray-805 px-6 py-3 rounded-xl">
                                    Already Applied
                                </button>
                            @elseif($isClosed)
                                <button disabled class="btn btn-danger cursor-not-allowed opacity-60 w-full md:w-auto px-6 py-3 rounded-xl">
                                    Application Closed
                                </button>
                            @elseif($completeness < 20)
                                <a href="{{ route('seeker.profile.edit') }}" class="btn bg-amber-500 hover:bg-amber-600 text-white w-full md:w-auto shadow-sm px-6 py-3 rounded-xl text-center" title="Min 20% profile completeness required to apply">
                                    Profile Incomplete (Min 20%)
                                </a>
                            @else
                                <a href="{{ route('jobs.apply', $job->slug) }}" class="btn bg-gradient-to-r from-primary-500 to-indigo-650 hover:from-primary-600 hover:to-indigo-700 text-white font-extrabold shadow-md hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center px-8 py-3.5 rounded-xl uppercase tracking-wider text-xs">
                                    Easy Apply
                                </a>
                            @endif
                        @elseif($isEmployer)
                            <a href="{{ route('employer.applicants.job', $job->id) }}" class="btn bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-extrabold shadow-md hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center px-6 py-3 rounded-xl uppercase tracking-wider text-xs">
                                View Applicants ({{ $job->applications_count }})
                            </a>
                        @else
                            <button class="btn bg-gradient-to-r from-primary-500 to-indigo-650 hover:from-primary-600 hover:to-indigo-700 text-white font-extrabold shadow-md hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center px-8 py-3.5 rounded-xl uppercase tracking-wider text-xs">
                                Easy Apply (Preview)
                            </button>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Under Header: 4 Quick Stat Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-1">
                    <span class="text-[9px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Salary Range</span>
                    <span class="text-xs sm:text-sm font-black text-emerald-600 dark:text-emerald-450 block font-display leading-tight">
                        @if($job->salary_min)
                            ${{ number_format($job->salary_min / 1000) }}k - ${{ number_format($job->salary_max / 1000) }}k /yr
                        @else
                            Competitive Salary
                        @endif
                    </span>
                </div>
                <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-1">
                    <span class="text-[9px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Workplace</span>
                    <span class="text-xs sm:text-sm font-black text-blue-600 dark:text-blue-450 block font-display leading-tight capitalize">{{ $job->workplace_type }}</span>
                </div>
                <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-1">
                    <span class="text-[9px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Experience</span>
                    <span class="text-xs sm:text-sm font-black text-purple-600 dark:text-purple-450 block font-display leading-tight capitalize">{{ $job->experience_level }}</span>
                </div>
                <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-1">
                    <span class="text-[9px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Category</span>
                    <span class="text-xs sm:text-sm font-black text-amber-600 dark:text-amber-450 block font-display leading-tight capitalize">{{ $job->category ? $job->category->name : 'Technology' }}</span>
                </div>
            </div>

            <!-- Detailed Grid Column Structure -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Left Main Content Column -->
                <div class="lg:col-span-2 space-y-6">
                    <x-card variant="default" class="p-6 md:p-8 border border-gray-150 dark:border-gray-800 shadow-premium transition-all duration-300 hover:shadow-md hover:border-gray-200/50">
                        <div class="space-y-6">
                            <!-- Job Description -->
                            <div>
                                <h3 class="font-extrabold text-sm md:text-base text-gray-900 dark:text-white mb-3 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Job Description
                                </h3>
                                <div class="h-0.5 w-full bg-gradient-to-r from-primary-500/30 to-transparent mb-4"></div>
                                <p class="text-gray-650 dark:text-gray-300 text-xs md:text-sm leading-relaxed max-w-prose whitespace-pre-line font-medium">{{ $job->description }}</p>
                            </div>

                            <!-- Responsibilities -->
                            @if($job->responsibilities)
                                <div>
                                    <h3 class="font-extrabold text-sm md:text-base text-gray-900 dark:text-white mb-3 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Key Responsibilities
                                    </h3>
                                    <div class="h-0.5 w-full bg-gradient-to-r from-primary-500/30 to-transparent mb-4"></div>
                                    <div class="space-y-3">
                                        @php $i = 1; @endphp
                                        @foreach(explode("\n", $job->responsibilities) as $line)
                                            @if(trim($line))
                                                <div class="flex items-start gap-3">
                                                    <span class="w-5 h-5 rounded-full bg-blue-50 dark:bg-blue-950/30 text-blue-500 flex items-center justify-center text-3xs font-extrabold flex-shrink-0 mt-0.5 shadow-inner">{{ $i++ }}</span>
                                                    <p class="text-xs text-gray-655 dark:text-gray-300 leading-relaxed font-medium">{{ trim($line) }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Requirements -->
                            <div>
                                <h3 class="font-extrabold text-sm md:text-base text-gray-900 dark:text-white mb-3 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Requirements
                                </h3>
                                <div class="h-0.5 w-full bg-gradient-to-r from-primary-500/30 to-transparent mb-4"></div>
                                <div class="space-y-3">
                                    @foreach(explode("\n", $job->requirements) as $line)
                                        @if(trim($line))
                                            <div class="flex items-start gap-3">
                                                <span class="w-5 h-5 rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-500 flex items-center justify-center text-[10px] font-extrabold flex-shrink-0 mt-0.5 shadow-inner">✓</span>
                                                <p class="text-xs text-gray-655 dark:text-gray-300 leading-relaxed font-medium">{{ trim($line) }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Benefits -->
                            @if($job->benefits)
                                <div>
                                    <h3 class="font-extrabold text-sm md:text-base text-gray-900 dark:text-white mb-3 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7.463 8.2l.003-.003.003-.003m0 0L7.5 12.5M4.537 16.2l3.39 3.39m0 0L9.5 17.5M8.2 19.5h11.5M19.5 8.2v11.5"/></svg>
                                        Benefits
                                    </h3>
                                    <div class="h-0.5 w-full bg-gradient-to-r from-primary-500/30 to-transparent mb-4"></div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach(explode("\n", $job->benefits) as $line)
                                            @if(trim($line))
                                                <div class="p-4 bg-gray-50 dark:bg-dark-800/40 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-start gap-3">
                                                    <span class="text-base">🎁</span>
                                                    <p class="text-xs text-gray-655 dark:text-gray-300 leading-relaxed font-semibold">{{ trim($line) }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-card>

                    <!-- Related Jobs Recommendation -->
                    <div class="space-y-4">
                        <h3 class="font-bold text-xs text-gray-955 dark:text-white uppercase tracking-widest pl-1">Related Opportunities</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <x-card variant="default" class="p-6 flex flex-col justify-between gap-4 hover:border-primary-500/30 hover:shadow-premium transition-all duration-300">
                                    <div class="flex gap-4 items-start">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-xs font-black shadow-inner flex-shrink-0 {{ $relBgClass }}">
                                            @if($rel->company->logo)
                                                <img src="{{ $rel->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-1" />
                                            @else
                                                {{ $relInitials }}
                                            @endif
                                        </div>
                                        <div class="space-y-1 min-w-0 flex-1">
                                            <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate font-display">
                                                <a href="{{ route('jobs.show', $rel->slug) }}">{{ $rel->title }}</a>
                                            </h4>
                                            <p class="text-5xs font-black text-gray-400 uppercase tracking-wider">{{ $rel->company->company_name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-3xs border-t border-gray-100 dark:border-gray-850 pt-3">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-gray-50 dark:bg-dark-800 text-gray-600 dark:text-gray-400 border border-gray-150 dark:border-gray-850 uppercase tracking-wider w-fit">{{ ucfirst($rel->workplace_type) }}</span>
                                        <span class="text-emerald-600 dark:text-emerald-450 font-extrabold">
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
                                <div class="col-span-2 p-8 bg-white dark:bg-dark-900 rounded-3xl border border-gray-150 dark:border-gray-800 text-center space-y-4 shadow-sm">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-white/5 text-gray-405 flex items-center justify-center mx-auto shadow-inner">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-bold text-gray-855 dark:text-gray-250">No related opportunities found</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto font-medium leading-relaxed">We couldn't find other open jobs matching this category right now.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Details Panel (Sticky on scroll) -->
                <div class="space-y-6 lg:sticky lg:top-24">
                    
                    <!-- Job Overview Stat Table -->
                    <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-premium transition-all duration-300 hover:shadow-md">
                        <x-slot name="header">Job Overview</x-slot>
                        
                        <div class="space-y-3.5 text-xs text-gray-750 dark:text-gray-300 font-semibold pt-1">
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-850 pb-2.5">
                                <span class="text-gray-400 font-medium">Posted:</span>
                                <span class="font-bold text-gray-905 dark:text-white capitalize">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-855 pb-2.5">
                                <span class="text-gray-400 font-medium">Type:</span>
                                <span class="font-bold text-gray-905 dark:text-white capitalize">{{ str_replace('_', '-', $job->employment_type) }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-855 pb-2.5">
                                <span class="text-gray-400 font-medium">Workplace:</span>
                                <span class="font-bold text-gray-905 dark:text-white capitalize">{{ $job->workplace_type }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-855 pb-2.5">
                                <span class="text-gray-400 font-medium">Vacancies:</span>
                                <span class="font-bold text-gray-905 dark:text-white font-mono">{{ $job->vacancies ?: 1 }} opening</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-855 pb-2.5">
                                <span class="text-gray-400 font-medium">Views:</span>
                                <span class="font-bold text-gray-905 dark:text-white font-mono">{{ $job->views_count }} views</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-855 pb-2.5">
                                <span class="text-gray-400 font-medium">Level:</span>
                                <span class="font-bold text-gray-905 dark:text-white capitalize">{{ $job->experience_level }}</span>
                            </div>
                            @if($job->application_deadline)
                                <div class="flex justify-between text-rose-500 font-bold">
                                    <span>Deadline:</span>
                                    <span>{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </x-card>

                    <!-- Required Skills checklist with Unified Borders and Category Icons -->
                    <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-premium transition-all duration-300 hover:shadow-md">
                        <x-slot name="header">Required Skills</x-slot>
                        <div class="flex flex-wrap gap-2 pt-1">
                            @forelse($job->skills as $skill)
                                @php
                                    $isBackend = in_array(strtolower($skill->name), ['laravel', 'php', 'mysql', 'postgres', 'redis', 'api']);
                                    $isFrontend = in_array(strtolower($skill->name), ['react', 'tailwind css', 'javascript', 'css', 'html', 'next.js']);
                                    $icon = $isBackend ? '⚙️' : ($isFrontend ? '💻' : '🏷️');
                                @endphp
                                <span class="px-3 py-1.5 bg-gray-50 dark:bg-dark-800 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-lg border border-gray-150 dark:border-gray-850 hover:border-primary-500/30 transition-all duration-200 cursor-default">
                                    {{ $icon }} {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400 italic">No specific skills listed.</span>
                            @endforelse
                        </div>
                    </x-card>

                    <!-- Employer Branding Card -->
                    <x-card variant="default" class="p-6 text-center space-y-4 border border-gray-150 dark:border-gray-800 shadow-premium transition-all duration-300 hover:shadow-md">
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
                        
                        <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center text-white text-sm font-black shadow-inner flex-shrink-0 {{ $compBgClass }}">
                            @if($job->company->logo)
                                <img src="{{ $job->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-1" />
                            @else
                                {{ $compInitials }}
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-950 dark:text-white font-display">
                                <a href="{{ route('companies.show', $job->company->slug) }}" class="hover:text-primary-500 transition">{{ $job->company->company_name }}</a>
                            </h4>
                            <span class="text-4xs text-gray-400 dark:text-gray-505 font-black uppercase tracking-wider block mt-1.5">{{ $job->company->industry }} &bull; {{ $followersFormatted }} followers</span>
                        </div>
                        @if($job->company->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3 text-left leading-relaxed font-semibold">{{ $job->company->description }}</p>
                        @endif
                        <div class="pt-3 text-left border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="btn border border-gray-250 dark:border-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-800/40 text-center w-full block py-2.5 rounded-xl font-bold text-xs transition leading-none">View Company Profile</a>
                        </div>
                    </x-card>

                </div>
            </div>

        </div>
    </div>

    <!-- Sticky Bottom Mobile Action Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-dark-900/95 backdrop-blur-lg border-t border-gray-150 dark:border-gray-800 py-3.5 px-6 md:hidden shadow-2xl flex items-center justify-between gap-4 no-print">
        <div class="min-w-0 flex-1">
            <h4 class="font-extrabold text-xs text-gray-900 dark:text-white line-clamp-1 leading-snug">{{ $job->title }}</h4>
            <p class="text-4xs text-gray-455 dark:text-gray-400 font-bold mt-0.5">{{ $job->company->company_name }}</p>
        </div>
        
        <div class="flex items-center gap-2">
            @guest
                <a href="{{ route('login') }}" class="btn btn-xs bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-bold px-4 py-2.5 rounded-xl text-3xs uppercase tracking-wider">
                    Apply
                </a>
            @else
                @if($isSeeker)
                    @if($hasApplied)
                        <button disabled class="btn btn-xs bg-gray-150 dark:bg-dark-800 text-gray-400 text-3xs px-4 py-2.5 rounded-xl">Applied</button>
                    @elseif($isClosed)
                        <button disabled class="btn btn-xs btn-danger opacity-60 text-3xs px-4 py-2.5 rounded-xl">Closed</button>
                    @elseif($completeness < 20)
                        <a href="{{ route('seeker.profile.edit') }}" class="btn btn-xs bg-amber-500 text-white text-3xs px-4 py-2.5 rounded-xl">Profile</a>
                    @else
                        <a href="{{ route('jobs.apply', $job->slug) }}" class="btn btn-xs bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-bold px-5 py-2.5 rounded-xl text-3xs uppercase tracking-wider">
                            Apply
                        </a>
                    @endif
                @elseif($isEmployer)
                    <a href="{{ route('employer.applicants.job', $job->id) }}" class="btn btn-xs bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-bold px-4 py-2.5 rounded-xl text-3xs uppercase tracking-wider">
                        Applicants
                    </a>
                @else
                    <button class="btn btn-xs bg-gradient-to-r from-primary-500 to-indigo-650 text-white font-bold px-4 py-2.5 rounded-xl text-3xs uppercase tracking-wider">
                        Apply
                    </button>
                @endif
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-150 dark:border-gray-850 mt-12 bg-white dark:bg-dark-900/50 no-print">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
            <p>© {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
