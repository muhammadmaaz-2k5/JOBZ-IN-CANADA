@php
    try {
        $featuredJobs = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->where('featured', true)->latest()->take(3)->get();
        if ($featuredJobs->isEmpty()) {
            $featuredJobs = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->latest()->take(3)->get();
        }
        $recentJobs = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->latest()->take(6)->get();
        $companies = \App\Models\Company::where('verification_status', 'verified')->latest()->take(5)->get();
        $jobsCount = \App\Models\Job::count();
    } catch (\Throwable $e) {
        $featuredJobs = collect();
        $recentJobs = collect();
        $companies = collect();
        $jobsCount = 0;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JOBZ IN CANADA - Find Your Dream Job</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-50/30 dark:bg-dark-950 min-h-screen transition-colors duration-300">

    <!-- Premium Mesh and Blobs Background -->
    <div class="absolute top-0 left-0 right-0 h-[650px] overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-25%] left-[-15%] w-[700px] h-[700px] rounded-full bg-gradient-to-tr from-primary-500/10 to-indigo-500/10 dark:from-primary-500/5 dark:to-indigo-500/5 blur-3xl opacity-80"></div>
        <div class="absolute top-[15%] right-[-15%] w-[600px] h-[600px] rounded-full bg-gradient-to-br from-indigo-500/10 to-purple-500/10 dark:from-indigo-500/5 dark:to-purple-500/5 blur-3xl opacity-80"></div>
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
                <a href="/" class="text-primary-500 dark:text-white font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
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

    <!-- Hero Search Section -->
    <section class="relative overflow-hidden pt-16 pb-20 text-center">
        <div class="max-w-5xl mx-auto px-6 relative z-10 space-y-6">
            <!-- Alert Badge -->
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-bold bg-primary-50 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400 border border-primary-200/20 backdrop-blur-sm">
                🇨🇦 Canada Wide Jobs &bull; {{ $jobsCount }} Active Roles
            </span>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-none text-gray-905 dark:text-white font-display">
                Find your dream job <br class="hidden sm:inline" /> in <span class="bg-gradient-to-r from-primary-500 to-indigo-650 bg-clip-text text-transparent">Canada</span>
            </h1>
            <p class="max-w-2xl mx-auto text-sm sm:text-base text-gray-500 dark:text-gray-400 font-semibold leading-relaxed">
                Discover thousands of exciting opportunities from Canada's top employers. Transparent salaries, remote options, and one-click applications.
            </p>

            <!-- Search Panel -->
            <form action="{{ route('jobs.index') }}" method="GET" class="p-2.5 bg-white dark:bg-dark-900 rounded-3xl md:rounded-full shadow-premium border border-gray-150 dark:border-gray-800 max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-2">
                <!-- What Input -->
                <div class="flex-1 w-full flex items-center px-4 py-2 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-800">
                    <svg class="h-4.5 w-4.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="Job title, keywords, or company..." class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold dark:text-white dark:placeholder-gray-600">
                </div>

                <!-- Where Input -->
                <div class="flex-1 w-full flex items-center px-4 py-2">
                    <svg class="h-4.5 w-4.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="text" name="location" placeholder="City, province, or 'Remote'..." class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold dark:text-white dark:placeholder-gray-600">
                </div>

                <!-- Search Button -->
                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-primary-500 to-indigo-650 hover:from-primary-600 hover:to-indigo-700 text-white font-extrabold px-8 py-3.5 rounded-full shrink-0 shadow-md hover:shadow-lg transition-all duration-300 text-xs uppercase tracking-wider">
                    Search
                </button>
            </form>

            <!-- Popular Category Tags -->
            <div class="flex flex-wrap justify-center items-center gap-2 pt-2">
                <span class="text-[10px] text-gray-450 dark:text-gray-500 font-bold uppercase tracking-wider">Popular:</span>
                @foreach(['Tech', 'Remote', 'Software Engineering', 'Healthcare', 'Finance', 'Software'] as $cat)
                    <a href="{{ route('jobs.index', ['category' => $cat]) }}" class="inline-flex items-center px-3 py-1 rounded-full text-4xs font-black uppercase tracking-wider bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-400 hover:border-primary-500/20 dark:hover:border-primary-500/10 transition-all duration-200">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Platform Stats Cards -->
    <section class="max-w-5xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 text-center space-y-1">
                <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-500 flex items-center justify-center mx-auto mb-2 shadow-inner">⚡</div>
                <p class="text-xl sm:text-2xl font-black text-gray-905 dark:text-white tracking-tight">12,480+</p>
                <p class="text-4xs font-bold text-gray-400 uppercase tracking-widest">Jobs Posted</p>
            </x-card>
            <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 text-center space-y-1">
                <div class="w-8 h-8 rounded-xl bg-teal-50 dark:bg-teal-950/20 text-teal-500 flex items-center justify-center mx-auto mb-2 shadow-inner">🏢</div>
                <p class="text-xl sm:text-2xl font-black text-gray-905 dark:text-white tracking-tight">3,200+</p>
                <p class="text-4xs font-bold text-gray-400 uppercase tracking-widest">Companies</p>
            </x-card>
            <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 text-center space-y-1">
                <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-950/20 text-purple-500 flex items-center justify-center mx-auto mb-2 shadow-inner">👥</div>
                <p class="text-xl sm:text-2xl font-black text-gray-905 dark:text-white tracking-tight">450k+</p>
                <p class="text-4xs font-bold text-gray-400 uppercase tracking-widest">Job Seekers</p>
            </x-card>
            <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 text-center space-y-1">
                <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-500 flex items-center justify-center mx-auto mb-2 shadow-inner">📈</div>
                <p class="text-xl sm:text-2xl font-black text-gray-905 dark:text-white tracking-tight">8,000+</p>
                <p class="text-4xs font-bold text-gray-400 uppercase tracking-widest">Monthly Applies</p>
            </x-card>
        </div>
    </section>

    <!-- Browse by Category Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-6">
        <div class="flex justify-between items-end">
            <div class="space-y-1">
                <h2 class="text-xl font-black text-gray-950 dark:text-white font-display">Browse by Category</h2>
                <p class="text-xs text-gray-500 dark:text-gray-450 font-medium">Explore roles across top Canadian industries</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="text-xs font-extrabold text-primary-500 hover:text-primary-650 hover:underline">View All &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            @php
                $cats = [
                    ['title' => 'Tech & Dev', 'icon' => '💻', 'count' => '1,420 jobs', 'val' => 'Software Development'],
                    ['title' => 'Healthcare', 'icon' => '🩺', 'count' => '850 jobs', 'val' => 'Healthcare'],
                    ['title' => 'Finance', 'icon' => '💵', 'count' => '640 jobs', 'val' => 'Finance'],
                    ['title' => 'Marketing', 'icon' => '📣', 'count' => '420 jobs', 'val' => 'Marketing'],
                    ['title' => 'Construction', 'icon' => '🏗️', 'count' => '310 jobs', 'val' => 'Construction'],
                    ['title' => 'Remote', 'icon' => '🏠', 'count' => '980 jobs', 'val' => 'Remote'],
                ];
            @endphp
            @foreach($cats as $c)
                <a href="{{ route('jobs.index', ['category' => $c['val']]) }}" class="group bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-5 shadow-sm hover:shadow-md text-center hover:border-primary-500/20 transition-all duration-300">
                    <div class="text-2xl mb-2.5 transform group-hover:scale-110 transition-transform duration-300">{{ $c['icon'] }}</div>
                    <h3 class="font-extrabold text-xs text-gray-900 dark:text-white truncate font-display">{{ $c['title'] }}</h3>
                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-bold mt-1 uppercase">{{ $c['count'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-6">
        <div class="flex justify-between items-end">
            <div class="space-y-1">
                <h2 class="text-xl font-black text-gray-950 dark:text-white font-display">⭐ Featured Jobs</h2>
                <p class="text-xs text-gray-500 dark:text-gray-450 font-medium">Promoted opportunities from certified partners</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="text-xs font-extrabold text-primary-500 hover:text-primary-650 hover:underline">More Jobs &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredJobs as $job)
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
                @endphp
                <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 hover:border-primary-500/20 shadow-sm flex flex-col justify-between gap-5 relative transition-all duration-300">
                    <div class="space-y-4">
                        <!-- Top Row: Logo & Save button -->
                        <div class="flex justify-between items-start">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white text-xs font-black {{ $bgClass }} shadow-inner">
                                @if($job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-1" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            
                            <button class="w-8 h-8 rounded-xl border border-gray-150 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:border-rose-200 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </div>

                        <!-- Job Title & Company -->
                        <div class="space-y-1">
                            <h3 class="font-extrabold text-sm text-gray-900 dark:text-white line-clamp-1 font-display">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-primary-500 transition">{{ $job->title }}</a>
                            </h3>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                {{ $job->company->company_name }}
                                @if($job->company->verification_status === 'verified')
                                    <span class="inline-flex items-center justify-center w-4 h-4 bg-primary-100 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold">✓</span>
                                @endif
                            </p>
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed font-semibold">{{ $job->description }}</p>

                        <!-- Skill tags -->
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach($job->skills->take(3) as $skill)
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-gray-50 dark:bg-dark-800 text-gray-600 dark:text-gray-400 border border-gray-150 dark:border-gray-850 cursor-default">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-850 flex justify-between items-center text-xs">
                        <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">
                            @if($job->salary_min)
                                ${{ number_format($job->salary_min / 1000) }}k - ${{ number_format($job->salary_max / 1000) }}k
                            @else
                                Competitive
                            @endif
                        </span>
                        <span class="text-gray-400 font-bold uppercase tracking-wider text-[9px]">📍 {{ $job->city }}</span>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-8">
        <div class="text-center space-y-1.5">
            <h2 class="text-xl font-black text-gray-955 dark:text-white font-display">How JOBZINCANADA Works</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Simple steps to kickstart your Canadian career</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 relative shadow-sm">
                <span class="absolute top-4 left-4 w-6 h-6 rounded-lg bg-primary-50 dark:bg-primary-950/20 text-primary-500 flex items-center justify-center text-2xs font-extrabold">1</span>
                <div class="pt-4 space-y-2">
                    <h3 class="font-extrabold text-sm text-gray-900 dark:text-white font-display">Search &amp; Discover</h3>
                    <p class="text-xs text-gray-505 dark:text-gray-400 leading-relaxed font-semibold">Filter through thousands of verified postings by city, industry, or remote options.</p>
                </div>
            </div>
            <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 relative shadow-sm">
                <span class="absolute top-4 left-4 w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/20 text-blue-500 flex items-center justify-center text-2xs font-extrabold">2</span>
                <div class="pt-4 space-y-2">
                    <h3 class="font-extrabold text-sm text-gray-900 dark:text-white font-display">Apply with One Click</h3>
                    <p class="text-xs text-gray-550 dark:text-gray-400 leading-relaxed font-semibold">Upload your resume to your profile and send one-click applications instantly.</p>
                </div>
            </div>
            <div class="bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 relative shadow-sm">
                <span class="absolute top-4 left-4 w-6 h-6 rounded-lg bg-purple-50 dark:bg-purple-950/20 text-purple-500 flex items-center justify-center text-2xs font-extrabold">3</span>
                <div class="pt-4 space-y-2">
                    <h3 class="font-extrabold text-sm text-gray-900 dark:text-white font-display">Get Hired Faster</h3>
                    <p class="text-xs text-gray-550 dark:text-gray-400 leading-relaxed font-semibold">Track real-time updates and message recruiters directly on our platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose JOBZINCANADA Card -->
    <section class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-gradient-to-r from-blue-700 via-primary-650 to-indigo-650 rounded-3xl p-8 md:p-10 text-white relative overflow-hidden shadow-premium">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-white/10 blur-2xl"></div>

            <div class="relative z-10 space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl md:text-2xl font-black font-display text-white">Why choose JOBZINCANADA?</h2>
                    <p class="text-xs text-blue-100 font-medium">Built with candidates and local employers in mind</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl space-y-2 backdrop-blur-sm">
                        <h3 class="font-bold text-xs text-white flex items-center gap-1.5">✓ Verified Employers</h3>
                        <p class="text-[11px] text-blue-50 leading-relaxed font-medium">All job posts are double-checked for corporate credentials to avoid scams.</p>
                    </div>
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl space-y-2 backdrop-blur-sm">
                        <h3 class="font-bold text-xs text-white flex items-center gap-1.5">📍 Canada-Wide Positions</h3>
                        <p class="text-[11px] text-blue-50 leading-relaxed font-medium">From remote positions to local roles in Toronto, Vancouver, and Montreal.</p>
                    </div>
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl space-y-2 backdrop-blur-sm">
                        <h3 class="font-bold text-xs text-white flex items-center gap-1.5">💵 Salary Transparency</h3>
                        <p class="text-[11px] text-blue-50 leading-relaxed font-medium">Access details regarding annual packages and benefits before applying.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Employers Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-6">
        <div class="flex justify-between items-end">
            <div class="space-y-1">
                <h2 class="text-xl font-black text-gray-950 dark:text-white font-display">Top Employers</h2>
                <p class="text-xs text-gray-500 dark:text-gray-450 font-medium">Partner brands actively recruiting talent in Canada</p>
            </div>
            <a href="{{ route('companies.index') }}" class="text-xs font-extrabold text-primary-500 hover:text-primary-650 hover:underline">All Companies &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($companies as $company)
                @php
                    $initials = strtoupper(substr($company->company_name, 0, 2));
                    $bgColors = [
                        'Shopify Canada' => 'bg-blue-600',
                        'TechNorth Solutions' => 'bg-teal-600',
                        'Maple Finance Group' => 'bg-amber-700',
                        'Northern Health Systems' => 'bg-emerald-600',
                        'CanBridge Engineering' => 'bg-indigo-650',
                    ];
                    $bgClass = $bgColors[$company->company_name] ?? 'bg-primary-600';
                @endphp
                <a href="{{ route('companies.show', $company->slug) }}" class="group bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-5 shadow-sm hover:shadow-md hover:border-primary-500/20 text-center transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xs font-black mx-auto mb-3 shadow-inner {{ $bgClass }} transform group-hover:scale-105 transition-transform duration-350">
                        @if($company->logo)
                            <img src="{{ $company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-1" />
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    <h3 class="font-extrabold text-xs text-gray-900 dark:text-white truncate group-hover:text-primary-500 transition-colors font-display">{{ $company->company_name }}</h3>
                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-bold mt-1 uppercase">{{ $company->industry ?: 'Industry' }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Recently Posted Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 space-y-6">
        <div class="flex justify-between items-end">
            <div class="space-y-1">
                <h2 class="text-xl font-black text-gray-955 dark:text-white font-display">Recently Posted</h2>
                <p class="text-xs text-gray-500 dark:text-gray-450 font-medium">New career opportunities added today</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="text-xs font-extrabold text-primary-500 hover:text-primary-650 hover:underline">All Jobs &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentJobs as $job)
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
                @endphp
                <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 hover:border-primary-500/20 shadow-sm flex flex-col justify-between gap-5 transition-all duration-300">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white text-xs font-black {{ $bgClass }} shadow-inner">
                                @if($job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-1" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            
                            <button class="w-8 h-8 rounded-xl border border-gray-150 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-rose-500 hover:border-rose-200 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </div>

                        <div class="space-y-1">
                            <h3 class="font-extrabold text-sm text-gray-900 dark:text-white line-clamp-1 font-display">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-primary-500 transition">{{ $job->title }}</a>
                            </h3>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5 font-semibold">
                                {{ $job->company->company_name }}
                                @if($job->company->verification_status === 'verified')
                                    <span class="inline-flex items-center justify-center w-4 h-4 bg-primary-100 dark:bg-primary-955/40 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold">✓</span>
                                @endif
                            </p>
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed font-semibold">{{ $job->description }}</p>

                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach($job->skills->take(3) as $skill)
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-gray-50 dark:bg-dark-800 text-gray-650 dark:text-gray-400 border border-gray-150 dark:border-gray-850 cursor-default">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-850 flex justify-between items-center text-xs">
                        <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">
                            @if($job->salary_min)
                                ${{ number_format($job->salary_min / 1000) }}k - ${{ number_format($job->salary_max / 1000) }}k
                            @else
                                Competitive
                            @endif
                        </span>
                        <span class="text-gray-450 dark:text-gray-500 font-bold uppercase tracking-wider text-[9px]">📍 {{ $job->city }}</span>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- Portal Options Grid (Job Seekers vs Employers) -->
    <section class="max-w-5xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Job Seeker Portal Card -->
        <x-card variant="default" class="group relative overflow-hidden p-8 hover:shadow-xl hover:border-primary-500/20">
            <div class="absolute right-0 top-0 w-24 h-24 bg-primary-500/10 rounded-bl-full pointer-events-none group-hover:scale-110 transition-transform duration-350"></div>
            
            <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-primary-50 dark:bg-primary-955/20 text-primary-500 mb-5 shadow-inner">
                <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            
            <h2 class="text-lg font-black text-gray-900 dark:text-white font-display">I am a Job Seeker</h2>
            <p class="mt-2 text-xs text-gray-505 dark:text-gray-400 leading-relaxed font-semibold">
                Create a customized professional profile, upload multiple resumes, set up real-time job alerts, and apply to top Canadian vacancies in seconds.
            </p>
            
            <div class="mt-6 flex items-center space-x-4">
                <a href="{{ route('register.seeker') }}" class="btn btn-primary px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-extrabold">
                    Get Started
                </a>
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-xs font-bold text-primary-500 hover:text-primary-650">
                    Browse jobs &rarr;
                </a>
            </div>
        </x-card>

        <!-- Employer Portal Card -->
        <x-card variant="default" class="group relative overflow-hidden p-8 hover:shadow-xl hover:border-accent-500/20">
            <div class="absolute right-0 top-0 w-24 h-24 bg-accent-500/10 rounded-bl-full pointer-events-none group-hover:scale-110 transition-transform duration-350"></div>
            
            <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-accent-500 mb-5 shadow-inner">
                <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            
            <h2 class="text-lg font-black text-gray-900 dark:text-white font-display">I am a Canadian Employer</h2>
            <p class="mt-2 text-xs text-gray-505 dark:text-gray-400 leading-relaxed font-semibold">
                Publish roles, screen potential applicants via our pipeline dashboard, look up matching resumes in our premium candidate archive, and verify your brand credentials.
            </p>
            
            <div class="mt-6 flex items-center space-x-4">
                <a href="{{ route('register.employer') }}" class="btn bg-accent-500 hover:bg-accent-600 text-white shadow-md px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-extrabold">
                    Post a Job
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-bold text-accent-500 hover:text-accent-650">
                    Employer sign-in &rarr;
                </a>
            </div>
        </x-card>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-150 dark:border-gray-850 mt-12 bg-white dark:bg-dark-900/50">
        <div class="max-w-5xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-gray-500 dark:text-gray-400 font-semibold">
            <div class="space-y-2 max-w-xs text-left">
                <a href="/" class="flex items-center space-x-2 font-extrabold text-sm tracking-tight text-primary-600 dark:text-white">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-primary-500 to-indigo-650 flex items-center justify-center shadow">
                        <span class="text-white font-black text-[10px]">J</span>
                    </div>
                    <span class="text-xs font-black text-gray-900 dark:text-white tracking-tight">JOBZIN<span class="text-primary-500">CANADA</span></span>
                </a>
                <p class="text-[10px] text-gray-400 dark:text-gray-505 leading-relaxed font-medium">Canada's premier job board connecting top talent with leading employers nationwide.</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-505 pt-2">📍 Toronto, Canada</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-8 md:gap-16">
                <div class="space-y-2">
                    <h4 class="font-extrabold text-[10px] uppercase text-gray-900 dark:text-white tracking-widest">Candidates</h4>
                    <ul class="space-y-1 text-gray-400 font-medium">
                        <li><a href="{{ route('jobs.index') }}" class="hover:text-primary-500">Browse Jobs</a></li>
                        <li><a href="#" class="hover:text-primary-500">Career Advice</a></li>
                        <li><a href="#" class="hover:text-primary-500">Salary Guide</a></li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <h4 class="font-extrabold text-[10px] uppercase text-gray-900 dark:text-white tracking-widest">Employers</h4>
                    <ul class="space-y-1 text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-primary-500">Post a Job</a></li>
                        <li><a href="#" class="hover:text-primary-500">Pricing</a></li>
                        <li><a href="#" class="hover:text-primary-500">Talent Search</a></li>
                    </ul>
                </div>
                <div class="space-y-2">
                    <h4 class="font-extrabold text-[10px] uppercase text-gray-900 dark:text-white tracking-widest">Connect</h4>
                    <div class="flex gap-2">
                        <span class="p-2 rounded-lg bg-gray-50 dark:bg-dark-800 border border-gray-150 dark:border-gray-800 text-gray-450 text-3xs cursor-pointer hover:text-primary-500">LN</span>
                        <span class="p-2 rounded-lg bg-gray-50 dark:bg-dark-800 border border-gray-150 dark:border-gray-800 text-gray-450 text-3xs cursor-pointer hover:text-primary-500">TW</span>
                        <span class="p-2 rounded-lg bg-gray-50 dark:bg-dark-800 border border-gray-150 dark:border-gray-800 text-gray-450 text-3xs cursor-pointer hover:text-primary-500">FB</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-5xl mx-auto px-6 py-4 border-t border-gray-100 dark:border-gray-850 flex justify-between items-center text-[10px] text-gray-400 font-semibold font-medium">
            <p>© {{ date('Y') }} JOBZINCANADA. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:underline">Privacy</a>
                <a href="#" class="hover:underline">Terms</a>
                <a href="#" class="hover:underline">Cookies</a>
            </div>
        </div>
    </footer>

</body>
</html>
