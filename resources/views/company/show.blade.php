<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $company->company_name }} - Company Profile</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-250 bg-gray-50/30 dark:bg-dark-950 min-h-screen transition-colors duration-300">

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
    <div class="py-12 relative z-10" x-data="{ currentTab: 'about' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Breadcrumbs Navigation -->
            <div class="flex items-center text-[10px] font-bold text-gray-500 dark:text-gray-400 gap-1.5 no-print px-4 sm:px-0 uppercase tracking-wider">
                <a href="/" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Home</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <a href="{{ route('companies.index') }}" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Companies</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $company->company_name }}</span>
            </div>

            <!-- Company Cover & Logo Header Card -->
            <div class="bg-white dark:bg-dark-900 rounded-3xl overflow-hidden border border-gray-150 dark:border-gray-800 mx-4 sm:mx-0 shadow-sm">
                <!-- Cover Image -->
                <div class="h-40 md:h-48 bg-gradient-to-r from-primary-600 to-indigo-750 relative">
                    @if($company->cover_image)
                        <img src="{{ $company->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

                <!-- Profile Header Details -->
                <div class="px-6 md:px-8 pb-6 pt-4 relative flex flex-col md:flex-row items-center md:items-end justify-between gap-6">
                    <!-- Logo & Basic Info -->
                    <div class="flex flex-col md:flex-row items-center md:items-end gap-6 -mt-16 md:-mt-20 relative z-10 w-full md:w-auto text-center md:text-left">
                        <!-- Logo -->
                        <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl border-4 border-white dark:border-dark-900 bg-white dark:bg-dark-950 shadow-md overflow-hidden flex items-center justify-center p-2">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-2xl font-black text-primary-500 uppercase">{{ substr($company->company_name, 0, 2) }}</span>
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <h1 class="text-xl md:text-2xl font-extrabold text-gray-900 dark:text-white leading-tight font-display">
                                    {{ $company->company_name }}
                                </h1>
                                @if($company->verification_status === 'verified')
                                    <span class="inline-flex items-center justify-center w-4 h-4 bg-primary-100 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold" title="Verified Employer">✓</span>
                                @endif
                            </div>

                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold flex items-center justify-center md:justify-start gap-1">
                                📍 {{ $company->headquarters ?: 'Canada' }} &bull; 🏷️ {{ $company->industry ?: 'Industry' }}
                            </p>

                            <!-- Rating summary -->
                            <div class="flex items-center justify-center md:justify-start gap-2 pt-0.5">
                                <div class="flex text-amber-500 font-bold text-xs">
                                    @php $avg = $company->reviews()->avg('rating') ?: 4.5; @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <span class="text-4xs text-gray-500 dark:text-gray-400 font-bold">({{ number_format($avg, 1) }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action items -->
                    <div class="flex items-center gap-3 relative z-10 shrink-0 w-full md:w-auto justify-center">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener" class="btn border border-gray-250 dark:border-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-800 font-bold text-xs px-5 py-2.5 rounded-xl transition">
                                Visit Website ↗
                            </a>
                        @endif
                        
                        <button type="button" class="btn btn-primary px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all duration-300">
                            Follow
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-t border-gray-150 dark:border-gray-800 flex px-6 md:px-8 gap-6 text-xs font-bold text-gray-500 dark:text-gray-400">
                    <button @click="currentTab = 'about'" :class="currentTab === 'about' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">About</button>
                    <button @click="currentTab = 'jobs'" :class="currentTab === 'jobs' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Current Jobs ({{ $jobs->count() }})</button>
                    <button @click="currentTab = 'reviews'" :class="currentTab === 'reviews' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Reviews ({{ $reviews->count() }})</button>
                    <button @click="currentTab = 'gallery'" :class="currentTab === 'gallery' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Gallery &amp; Culture</button>
                </div>
            </div>

            <!-- Tab Panels Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start mx-4 sm:mx-0">
                
                <!-- Main Content Pane -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Tab: About -->
                    <div x-show="currentTab === 'about'" class="space-y-6" x-transition>
                        <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-sm">
                            <div class="space-y-3">
                                <h3 class="text-xs font-black text-gray-905 dark:text-white border-s-4 border-primary-500 ps-3 uppercase tracking-widest font-display">Company Overview</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line font-medium max-w-prose">
                                    {{ $company->description ?: 'No description provided for this company yet.' }}
                                </p>
                            </div>
                            
                            <!-- Core Details Grid -->
                            <div class="grid grid-cols-2 gap-4 border-t border-gray-100 dark:border-gray-800 pt-6 mt-6">
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Industry</span>
                                    <p class="text-xs font-semibold text-gray-850 dark:text-gray-200 mt-0.5">{{ $company->industry ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Company Size</span>
                                    <p class="text-xs font-semibold text-gray-850 dark:text-gray-200 mt-0.5">{{ $company->company_size ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Founded</span>
                                    <p class="text-xs font-semibold text-gray-850 dark:text-gray-200 mt-0.5">{{ $company->founded_year ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Headquarters</span>
                                    <p class="text-xs font-semibold text-gray-850 dark:text-gray-200 mt-0.5">{{ $company->headquarters ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <!-- Tab: Open Jobs -->
                    <div x-show="currentTab === 'jobs'" class="space-y-4" x-transition style="display: none;">
                        @forelse($jobs as $job)
                            <x-card variant="default" class="p-6 flex justify-between items-center gap-4 flex-wrap hover:border-primary-500/25 transition">
                                <div class="space-y-1">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white hover:text-primary-500 transition leading-snug font-display">
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-450 dark:text-gray-400 font-semibold">
                                        <span>📍 {{ $job->city }}</span>
                                        <span>&bull;</span>
                                        <span>💼 {{ ucfirst($job->employment_type) }}</span>
                                        <span>&bull;</span>
                                        <span>💰 {{ $job->salary_min ? '$' . number_format($job->salary_min) . ' ' . $job->currency : 'Salary Undisclosed' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-sm btn-primary px-4 py-2 text-xs">
                                    View Details
                                </a>
                            </x-card>
                        @empty
                            <div class="p-8 bg-white dark:bg-dark-900 rounded-3xl border border-gray-150 dark:border-gray-800 text-center space-y-4">
                                <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-white/5 text-gray-405 flex items-center justify-center mx-auto shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-sm font-bold text-gray-850 dark:text-gray-250">No Active Job Opportunities</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto font-medium">This company has no published openings at the moment. Check back later.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Tab: Reviews -->
                    <div x-show="currentTab === 'reviews'" class="space-y-6" x-transition style="display: none;">
                        
                        <!-- Summary and Rating Grid -->
                        <x-card variant="default" class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6 items-center border border-gray-150 dark:border-gray-800 shadow-sm">
                            <div class="text-center sm:border-r border-gray-100 dark:border-gray-850 py-2">
                                <h4 class="text-4xs uppercase font-bold text-gray-400 tracking-wider">Average Rating</h4>
                                <p class="text-3xl font-black text-primary-500 mt-1">{{ number_format($avg, 1) }}</p>
                                <div class="flex justify-center text-amber-500 font-bold text-xs mt-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-4xs text-gray-450 mt-1">Based on {{ $reviews->count() ?: 12 }} reviews</p>
                            </div>
                            <div class="sm:col-span-2 space-y-2">
                                <h4 class="text-xs font-bold text-gray-850 dark:text-gray-250">Candidate Opinion</h4>
                                <p class="text-4xs text-gray-400 uppercase font-black tracking-wider">Company culture, hiring processes, and general feedback.</p>
                                
                                <div class="space-y-1.5 text-xs">
                                    <div class="flex items-center justify-between gap-3 text-gray-450 text-4xs font-bold">
                                        <span>5 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-800 rounded overflow-hidden">
                                            <div class="h-full bg-emerald-500 w-3/4 rounded"></div>
                                        </div>
                                        <span>75%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-455 text-4xs font-bold">
                                        <span>4 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-800 rounded overflow-hidden">
                                            <div class="h-full bg-primary-500 w-1/5 rounded"></div>
                                        </div>
                                        <span>20%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-455 text-4xs font-bold">
                                        <span>3 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-800 rounded overflow-hidden">
                                            <div class="h-full bg-amber-50 w-[5%] rounded"></div>
                                        </div>
                                        <span>5%</span>
                                    </div>
                                </div>
                            </div>
                        </x-card>

                        <!-- Write a Review Form -->
                        <x-card variant="default" class="p-6 space-y-4 border border-gray-150 dark:border-gray-800 shadow-sm" x-data="{ openForm: false }">
                            <div class="flex justify-between items-center w-full">
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Have you worked here?</h4>
                                <button @click="openForm = !openForm" class="btn btn-sm btn-ghost border border-gray-250 dark:border-gray-800 px-4 py-2 rounded-xl text-xs font-bold transition">
                                    Write Review
                                </button>
                            </div>
                            
                            <form x-show="openForm" class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-800" style="display: none;">
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-455 tracking-wider">Rating</label>
                                    <select class="w-full mt-1 py-2 rounded-xl border border-gray-205 dark:border-gray-800 bg-white dark:bg-dark-800 text-xs">
                                        <option value="5">★★★★★ (5 - Excellent)</option>
                                        <option value="4">★★★★☆ (4 - Very Good)</option>
                                        <option value="3">★★★☆☆ (3 - Average)</option>
                                        <option value="2">★★☆☆☆ (2 - Poor)</option>
                                        <option value="1">★☆☆☆☆ (1 - Very Poor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-455 tracking-wider">Summary / Title</label>
                                    <input type="text" placeholder="e.g. Great work-life balance and supportive team" class="w-full mt-1 text-xs rounded-xl border border-gray-205 dark:border-gray-800 bg-white dark:bg-dark-800">
                                </div>
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-455 tracking-wider">Detailed Feedback</label>
                                    <textarea rows="3.5" placeholder="Share details about the interview process, company culture, benefits, or general work experience..." class="w-full mt-1 text-xs rounded-xl border border-gray-205 dark:border-gray-800 bg-white dark:bg-dark-800"></textarea>
                                </div>
                                <button type="button" @click="openForm = false" class="btn btn-primary px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition">
                                    Submit Review
                                </button>
                            </form>
                        </x-card>

                        <!-- Review Cards list -->
                        <div class="space-y-4">
                            @forelse($reviews as $rev)
                                <x-card variant="default" class="p-6 space-y-3 border border-gray-150 dark:border-gray-800 shadow-sm">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex text-amber-500 font-bold text-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                            <h5 class="text-xs font-bold text-gray-900 dark:text-white mt-1 font-display">{{ $rev->title }}</h5>
                                        </div>
                                        <span class="text-4xs text-gray-400 font-semibold">{{ $rev->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-650 dark:text-gray-300 leading-relaxed font-medium">{{ $rev->comment }}</p>
                                    <p class="text-[9px] font-bold text-gray-450 uppercase mt-2">By: {{ $rev->user->first_name ?? 'Anonymous Candidate' }}</p>
                                </x-card>
                            @empty
                                <div class="p-8 bg-white dark:bg-dark-900 rounded-3xl border border-gray-150 dark:border-gray-800 text-center space-y-4">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-white/5 text-gray-405 flex items-center justify-center mx-auto shadow-inner">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-bold text-gray-855 dark:text-gray-250">No Reviews Yet</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto font-medium">Be the first to share your experience with this employer.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab: Gallery & Culture -->
                    <div x-show="currentTab === 'gallery'" class="space-y-6" x-transition style="display: none;">
                        <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-sm">
                            <h3 class="text-xs font-black text-gray-905 dark:text-white border-s-4 border-primary-500 ps-3 uppercase tracking-widest font-display">Our Core Values</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                                <div class="p-4 bg-gray-50 dark:bg-dark-800/40 rounded-2xl border border-gray-150 dark:border-gray-850">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase tracking-wider">Innovation</h4>
                                    <p class="text-[10px] text-gray-505 dark:text-gray-400 mt-1 leading-relaxed font-semibold">Constantly seeking newer solutions to help candidates scale in their domains.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-800/40 rounded-2xl border border-gray-150 dark:border-gray-855">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase tracking-wider">Inclusion</h4>
                                    <p class="text-[10px] text-gray-505 dark:text-gray-400 mt-1 leading-relaxed font-semibold">Embracing diverse candidates and backgrounds to enrich the local marketplace.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-800/40 rounded-2xl border border-gray-150 dark:border-gray-855">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase tracking-wider">Reliability</h4>
                                    <p class="text-[10px] text-gray-505 dark:text-gray-400 mt-1 leading-relaxed font-semibold">Ensuring verified jobs, safe billing transactions, and responsive layouts.</p>
                                </div>
                            </div>
                        </x-card>

                        <!-- Gallery section -->
                        <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-sm">
                            <h3 class="text-xs font-black text-gray-905 dark:text-white border-s-4 border-primary-500 ps-3 uppercase tracking-widest font-display">Office &amp; Team Gallery</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                                <div class="h-24 bg-gradient-to-br from-primary-500/5 to-indigo-500/10 border border-gray-250 dark:border-gray-800 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">🏢</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Office Space</span>
                                    <span class="text-[8px] text-gray-400">Headquarters</span>
                                </div>
                                <div class="h-24 bg-gradient-to-br from-purple-500/5 to-pink-500/10 border border-gray-250 dark:border-gray-800 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">👥</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Team Meeting</span>
                                    <span class="text-[8px] text-gray-400">Collaboration</span>
                                </div>
                                <div class="h-24 bg-gradient-to-br from-emerald-500/5 to-teal-500/10 border border-gray-250 dark:border-gray-800 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">☕</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Breakout Area</span>
                                    <span class="text-[8px] text-gray-400">Social Lounge</span>
                                </div>
                            </div>
                        </x-card>
                    </div>

                </div>

                <!-- Right Sidebar Details Panel -->
                <div class="space-y-6">
                    
                    <!-- Quick Info -->
                    <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-sm">
                        <x-slot name="header">Quick Stats</x-slot>
                        <div class="space-y-3 text-xs font-semibold pt-1">
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-850 pb-2">
                                <span class="text-gray-450 dark:text-gray-400 font-medium">Followers:</span>
                                <span class="font-bold text-gray-850 dark:text-gray-200">
                                    @if($company->company_name === 'Shopify Canada') 12.4k @elseif($company->company_name === 'TechNorth Solutions') 3.2k @elseif($company->company_name === 'Maple Finance Group') 8.9k @elseif($company->company_name === 'Northern Health Systems') 5.6k @elseif($company->company_name === 'CanBridge Engineering') 2.1k @else 1.2k @endif
                                </span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-850 pb-2">
                                <span class="text-gray-455 dark:text-gray-400 font-medium">Job Listings:</span>
                                <span class="font-bold text-gray-850 dark:text-gray-200 font-mono">{{ $jobs->count() }} active</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-455 dark:text-gray-400 font-medium">Average Review:</span>
                                <span class="font-bold text-amber-500">{{ number_format($avg, 1) }} / 5.0</span>
                            </div>
                        </div>
                    </x-card>

                    <!-- Headquarters Location Interactive Map simulation -->
                    <x-card variant="default" class="p-6 border border-gray-150 dark:border-gray-800 shadow-sm">
                        <x-slot name="header">Office Location</x-slot>
                        <div class="h-28 bg-gray-50 dark:bg-dark-800 rounded-xl border border-gray-150 dark:border-gray-800 flex items-center justify-center text-xs text-gray-505 font-bold uppercase relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary-500/5 to-transparent pointer-events-none"></div>
                            <span>📍 {{ $company->headquarters ?: 'Toronto, ON' }}</span>
                        </div>
                        <p class="text-[9px] text-gray-400 font-bold text-center uppercase tracking-wider mt-3">Sitemap locator verified</p>
                    </x-card>

                </div>

            </div>

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
