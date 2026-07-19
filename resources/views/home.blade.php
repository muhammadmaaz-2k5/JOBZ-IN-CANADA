<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JOBZ IN CANADA - Find Your Next Opportunity</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-dark-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">

    <!-- Header Navbar -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-800/80 shadow-glass">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-2 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-primary-500 text-white font-bold">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600 dark:text-gray-300">
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors">Find Jobs</a>
                <a href="#seekers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Job Seekers</a>
                <a href="#employers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Employers</a>
            </nav>

            <!-- Actions Panel -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-white dark:bg-dark-800 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" style="display: none;">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 shadow-sm transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-500 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 shadow-premium transition-colors">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Search Section -->
    <section class="relative overflow-hidden pt-20 pb-28 bg-gradient-to-b from-primary-50/50 via-transparent to-transparent dark:from-primary-950/10">
        <!-- Visual Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(99,102,241,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(99,102,241,0.04)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-6 relative z-10 text-center">
            <!-- Alert Badge -->
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-primary-100/80 text-primary-700 dark:bg-primary-950/40 dark:text-primary-400 mb-6 border border-primary-200/20 backdrop-blur-sm animate-pulse-slow">
                🇨🇦 Supporting Candidates & Canadian Employers Countrywide
            </span>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-none text-gray-900 dark:text-white">
                Find your next <span class="bg-gradient-to-r from-primary-500 to-indigo-600 bg-clip-text text-transparent">career move</span> in Canada
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-base sm:text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                Discover high-paying jobs in Vancouver, Toronto, Montreal, and beyond. We connect global talent with verified Canadian employers.
            </p>

            <!-- Search Panel -->
            <form action="{{ route('jobs.index') }}" method="GET" class="mt-10 p-3 bg-white dark:bg-dark-800 rounded-2xl md:rounded-full shadow-premium border border-gray-150 dark:border-gray-800 max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-2">
                <!-- What Input -->
                <div class="flex-1 w-full flex items-center px-4 py-2 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                    <svg class="h-5 w-5 text-gray-405 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="Job title, keywords, or company" class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-sm dark:placeholder-gray-500">
                </div>

                <!-- Where Input -->
                <div class="flex-1 w-full flex items-center px-4 py-2">
                    <svg class="h-5 w-5 text-gray-450 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="text" name="location" placeholder="City, province, or 'Remote'" class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-sm dark:placeholder-gray-500">
                </div>

                <!-- Search Button -->
                <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full text-white bg-primary-500 hover:bg-primary-600 shadow-md font-semibold text-sm transition-colors cursor-pointer shrink-0">
                    Search Jobs
                </button>
            </form>

            <!-- Popular Category Tags -->
            <div class="mt-8 flex flex-wrap justify-center items-center gap-3">
                <span class="text-xs text-gray-450 font-medium">Popular:</span>
                @foreach(['Technology', 'Healthcare', 'Construction', 'Finance', 'Engineering', 'Remote'] as $cat)
                    <a href="{{ route('jobs.index', ['category' => $cat]) }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 hover:bg-gray-200 dark:bg-dark-800 dark:hover:bg-dark-700 border border-gray-200/40 dark:border-gray-700/40 text-gray-600 dark:text-gray-300 transition-colors">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Portal Options Grid (Job Seekers vs Employers) -->
    <section class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Job Seeker Portal Card -->
        <div id="seekers" class="group relative overflow-hidden rounded-2xl bg-white dark:bg-dark-800 border border-gray-150 dark:border-gray-800/80 p-8 md:p-10 shadow-premium transition-all duration-300 hover:shadow-2xl hover:border-primary-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-primary-500/10 rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-350"></div>
            
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 mb-6">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">I am a Job Seeker</h2>
            <p class="mt-3 text-sm sm:text-base text-gray-500 dark:text-gray-400 leading-relaxed">
                Create a customized professional profile, upload multiple resumes, set up real-time job alerts, and apply to top Canadian vacancies in seconds.
            </p>
            
            <div class="mt-8 flex items-center space-x-4">
                <a href="{{ route('register.seeker') }}" class="px-5 py-2.5 rounded-xl font-semibold text-sm text-white bg-primary-500 hover:bg-primary-600 transition-colors shadow-premium">
                    Get Started
                </a>
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-sm font-semibold text-primary-500 hover:underline">
                    Browse jobs
                    <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Employer Portal Card -->
        <div id="employers" class="group relative overflow-hidden rounded-2xl bg-white dark:bg-dark-800 border border-gray-150 dark:border-gray-800/80 p-8 md:p-10 shadow-premium transition-all duration-300 hover:shadow-2xl hover:border-accent-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-accent-500/10 rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-350"></div>
            
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-accent-500 mb-6">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">I am a Canadian Employer</h2>
            <p class="mt-3 text-sm sm:text-base text-gray-500 dark:text-gray-400 leading-relaxed">
                Publish roles, screen potential applicants via our pipeline dashboard, look up matching resumes in our premium candidate archive, and verify your brand credentials.
            </p>
            
            <div class="mt-8 flex items-center space-x-4">
                <a href="{{ route('register.employer') }}" class="px-5 py-2.5 rounded-xl font-semibold text-sm text-white bg-accent-500 hover:bg-accent-600 transition-colors shadow-premium">
                    Post a Job / Hire
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-semibold text-accent-500 hover:underline">
                    Employer sign-in
                    <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Platform Stats Section -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="rounded-3xl bg-primary-600 dark:bg-dark-800 border border-transparent dark:border-gray-800 text-white p-8 md:p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid opacity-10 pointer-events-none"></div>
            
            <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2">
                    <p class="text-4xl sm:text-5xl font-extrabold text-accent-500">12k+</p>
                    <p class="text-xs sm:text-sm font-semibold text-primary-100">Jobs Posted Monthly</p>
                </div>
                <div class="space-y-2">
                    <p class="text-4xl sm:text-5xl font-extrabold text-accent-500">850+</p>
                    <p class="text-xs sm:text-sm font-semibold text-primary-100">Verified Companies</p>
                </div>
                <div class="space-y-2">
                    <p class="text-4xl sm:text-5xl font-extrabold text-accent-500">95k+</p>
                    <p class="text-xs sm:text-sm font-semibold text-primary-100">Active Job Seekers</p>
                </div>
                <div class="space-y-2">
                    <p class="text-4xl sm:text-5xl font-extrabold text-accent-500">15+</p>
                    <p class="text-xs sm:text-sm font-semibold text-primary-100">Canadian Industries</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-150 dark:border-gray-850 mt-12 bg-white dark:bg-dark-900/50">
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
