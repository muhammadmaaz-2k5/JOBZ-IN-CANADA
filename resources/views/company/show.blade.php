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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-dark-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">

    <!-- Header Navbar (Homepage Style) -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-800/80 shadow-glass no-print">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-2 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-primary-500 text-white font-bold">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600 dark:text-gray-300">
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors">Find Jobs</a>
                <a href="/#seekers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Job Seekers</a>
                <a href="/#employers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Employers</a>
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

    <!-- Main Content Container -->
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ currentTab: 'about' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Breadcrumbs Navigation -->
            <div class="flex items-center text-[11px] font-bold text-gray-500 gap-1.5 no-print px-4 sm:px-0">
                <a href="/" class="hover:text-primary-500 transition">Home</a>
                <span>/</span>
                <span class="hover:text-primary-500 transition">Companies</span>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-300">{{ $company->company_name }}</span>
            </div>

            <!-- Company Cover & Logo Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-gray-150 dark:border-gray-700/50 mx-4 sm:mx-0">
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
                        <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl border-4 border-white dark:border-gray-800 bg-white shadow-md overflow-hidden flex items-center justify-center p-2">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-2xl font-black text-primary-500 uppercase">{{ substr($company->company_name, 0, 2) }}</span>
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <h1 class="text-xl md:text-2xl font-extrabold text-gray-900 dark:text-white leading-tight">
                                    {{ $company->company_name }}
                                </h1>
                                @if($company->verification_status === 'verified')
                                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-500 text-white rounded-full text-3xs font-extrabold shadow-sm" title="Verified Employer">✓</span>
                                @endif
                            </div>

                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold flex items-center justify-center md:justify-start gap-1">
                                📍 {{ $company->headquarters ?: 'Canada' }} &bull; 🏷️ {{ $company->industry ?: 'Industry' }}
                            </p>

                            <!-- Rating summary -->
                            <div class="flex items-center justify-center md:justify-start gap-2 pt-0.5">
                                <div class="flex text-amber-500 font-bold text-xs">
                                    @php $avg = $company->reviews()->avg('rating') ?: 0; @endphp
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
                            <a href="{{ $company->website }}" target="_blank" rel="noopener" class="px-4 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 font-semibold text-xs transition shadow-sm text-gray-700 dark:text-gray-300">
                                Visit Website ↗
                            </a>
                        @endif
                        
                        <button type="button" class="px-4 py-2 rounded-xl bg-primary-500 text-white hover:bg-primary-600 font-semibold text-xs transition shadow-premium">
                            Follow
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-t border-gray-150 dark:border-gray-700 flex px-6 md:px-8 gap-6 text-xs font-bold text-gray-500 dark:text-gray-400">
                    <button @click="currentTab = 'about'" :class="currentTab === 'about' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">About</button>
                    <button @click="currentTab = 'jobs'" :class="currentTab === 'jobs' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Current Jobs ({{ $jobs->count() }})</button>
                    <button @click="currentTab = 'reviews'" :class="currentTab === 'reviews' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Reviews ({{ $reviews->count() }})</button>
                    <button @click="currentTab = 'gallery'" :class="currentTab === 'gallery' ? 'text-primary-500 border-b-2 border-primary-500 py-3.5' : 'hover:text-gray-800 dark:hover:text-white py-3.5'" class="transition cursor-pointer">Gallery & Culture</button>
                </div>
            </div>

            <!-- Tab Panels Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start mx-4 sm:mx-0">
                
                <!-- Main Content Pane -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Tab: About -->
                    <div x-show="currentTab === 'about'" class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition>
                        <div class="space-y-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3 uppercase tracking-wider">Company Overview</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $company->description ?: 'No description provided for this company yet.' }}
                            </p>
                        </div>
                        
                        <!-- Core Details Grid -->
                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 dark:border-gray-750 pt-6">
                            <div>
                                <span class="text-[9px] uppercase font-bold text-gray-400">Industry</span>
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $company->industry ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase font-bold text-gray-400">Company Size</span>
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $company->company_size ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase font-bold text-gray-400">Founded</span>
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $company->founded_year ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase font-bold text-gray-400">Headquarters</span>
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $company->headquarters ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Open Jobs -->
                    <div x-show="currentTab === 'jobs'" class="space-y-4" x-transition>
                        @forelse($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 flex justify-between items-center gap-4 flex-wrap hover:border-primary-500/25 transition">
                                <div class="space-y-1">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white hover:text-primary-500 transition">
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    <div class="flex flex-wrap items-center gap-3 text-4xs text-gray-450 uppercase font-bold">
                                        <span>📍 {{ $job->city }}</span>
                                        <span>&bull;</span>
                                        <span>💼 {{ $job->employment_type }}</span>
                                        <span>&bull;</span>
                                        <span>💰 {{ $job->salary_min ? '$' . number_format($job->salary_min) . ' CAD' : 'Salary Undisclosed' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="px-4 py-2 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-extrabold text-xs transition shadow-premium uppercase tracking-wider">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-150 dark:border-gray-700/50 text-center text-gray-400 italic text-xs">
                                No active job opportunities published at the moment. Check back soon!
                            </div>
                        @endforelse
                    </div>

                    <!-- Tab: Reviews -->
                    <div x-show="currentTab === 'reviews'" class="space-y-6" x-transition>
                        
                        <!-- Summary and Rating Grid -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                            <div class="text-center sm:border-r border-gray-100 dark:border-gray-700 py-2">
                                <h4 class="text-[9px] uppercase font-bold text-gray-400">Average Rating</h4>
                                <p class="text-3xl font-black text-primary-500 mt-1">{{ number_format($avg, 1) }}</p>
                                <div class="flex justify-center text-amber-500 font-bold text-xs mt-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-4xs text-gray-450 mt-1">Based on {{ $reviews->count() }} ratings</p>
                            </div>
                            <div class="sm:col-span-2 space-y-2">
                                <h4 class="text-xs font-bold text-gray-850 dark:text-gray-250">Candidate Opinion</h4>
                                <p class="text-4xs text-gray-400 uppercase font-black">Company culture, hiring processes, and general feedback.</p>
                                
                                <div class="space-y-1.5 text-xs">
                                    <div class="flex items-center justify-between gap-3 text-gray-450 text-4xs font-bold">
                                        <span>5 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-emerald-500 w-3/4 rounded"></div>
                                        </div>
                                        <span>75%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-455 text-4xs font-bold">
                                        <span>4 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-primary-500 w-1/5 rounded"></div>
                                        </div>
                                        <span>20%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-455 text-4xs font-bold">
                                        <span>3 ★</span>
                                        <div class="flex-1 h-1.5 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-amber-500 w-[5%] rounded"></div>
                                        </div>
                                        <span>5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Write a Review Form -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-4" x-data="{ openForm: false }">
                            <div class="flex justify-between items-center">
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Have you worked here?</h4>
                                <button @click="openForm = !openForm" class="px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-750 text-3xs uppercase font-extrabold hover:bg-gray-50 dark:hover:bg-dark-850 transition cursor-pointer text-gray-700 dark:text-gray-300">
                                    Write Review
                                </button>
                            </div>
                            
                            <form x-show="openForm" class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-750" style="display: none;">
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-450">Rating</label>
                                    <select class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-150 bg-white dark:bg-dark-800 text-xs font-semibold">
                                        <option value="5">★★★★★ (5 - Excellent)</option>
                                        <option value="4">★★★★☆ (4 - Very Good)</option>
                                        <option value="3">★★★☆☆ (3 - Average)</option>
                                        <option value="2">★★☆☆☆ (2 - Poor)</option>
                                        <option value="1">★☆☆☆☆ (1 - Very Poor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-455">Summary / Title</label>
                                    <input type="text" placeholder="e.g. Great work-life balance and supportive team" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-150 bg-white dark:bg-dark-800 text-xs">
                                </div>
                                <div>
                                    <label class="block text-4xs uppercase font-bold text-gray-455">Detailed Feedback</label>
                                    <textarea rows="3.5" placeholder="Share details about the interview process, company culture, benefits, or general work experience..." class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-150 bg-white dark:bg-dark-800 text-xs"></textarea>
                                </div>
                                <button type="button" @click="openForm = false" class="px-4 py-2 bg-primary-500 text-white rounded-xl text-xs font-bold hover:bg-primary-600 transition shadow-premium">
                                    Submit
                                </button>
                            </form>
                        </div>

                        <!-- Review Cards list -->
                        <div class="space-y-4">
                            @forelse($reviews as $rev)
                                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex text-amber-500 font-bold text-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                            <h5 class="text-xs font-bold text-gray-900 dark:text-white mt-1">{{ $rev->title }}</h5>
                                        </div>
                                        <span class="text-4xs text-gray-400 font-semibold">{{ $rev->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-650 dark:text-gray-300 leading-relaxed">{{ $rev->comment }}</p>
                                    <p class="text-[9px] font-bold text-gray-450 uppercase">By: {{ $rev->user->first_name ?? 'Anonymous Candidate' }}</p>
                                </div>
                            @empty
                                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 text-center text-gray-400 italic text-xs">
                                    No reviews posted yet. Be the first to share your experience!
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab: Gallery & Culture -->
                    <div x-show="currentTab === 'gallery'" class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition>
                        <div class="space-y-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3 uppercase tracking-wider">Our Core Values</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase">Innovation</h4>
                                    <p class="text-[10px] text-gray-500 mt-1 leading-relaxed">Constantly seeking newer solutions to help candidates scale in their domains.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase">Inclusion</h4>
                                    <p class="text-[10px] text-gray-500 mt-1 leading-relaxed">Embracing diverse candidates and backgrounds to enrich the local marketplace.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-extrabold text-[10px] text-primary-500 uppercase">Reliability</h4>
                                    <p class="text-[10px] text-gray-500 mt-1 leading-relaxed">Ensuring verified jobs, safe billing transactions, and responsive layouts.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery section -->
                        <div class="space-y-3">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3 uppercase tracking-wider">Office & Team Gallery</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div class="h-24 bg-gradient-to-br from-primary-500/5 to-indigo-500/10 border border-gray-250 dark:border-gray-700 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">🏢</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Office Space</span>
                                    <span class="text-[8px] text-gray-400">Headquarters</span>
                                </div>
                                <div class="h-24 bg-gradient-to-br from-purple-500/5 to-pink-500/10 border border-gray-250 dark:border-gray-700 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">👥</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Team Meeting</span>
                                    <span class="text-[8px] text-gray-400">Collaboration</span>
                                </div>
                                <div class="h-24 bg-gradient-to-br from-emerald-500/5 to-teal-500/10 border border-gray-250 dark:border-gray-700 rounded-2xl overflow-hidden flex flex-col items-center justify-center p-3 text-center">
                                    <span class="text-xl mb-0.5">☕</span>
                                    <span class="text-[9px] font-extrabold uppercase text-gray-900 dark:text-white">Breakout Area</span>
                                    <span class="text-[8px] text-gray-400">Social Lounge</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar Details Pane -->
                <div class="space-y-6">
                    
                    <!-- Quick Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750 uppercase tracking-wider">Quick Stats</h3>
                        <div class="space-y-3 text-xs font-semibold">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Followers:</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200">{{ $company->followers()->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Job Listings:</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 font-mono">{{ $jobs->count() }} active</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Average Review:</span>
                                <span class="font-bold text-amber-500">{{ number_format($avg, 1) }} / 5.0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Headquarters Location Interactive Map simulation -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 space-y-3">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750 uppercase tracking-wider">Office Location</h3>
                        <div class="h-28 bg-gray-50 dark:bg-dark-850 rounded-xl border border-gray-150 dark:border-gray-750 flex items-center justify-center text-xs text-gray-405 font-bold uppercase relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary-500/5 to-transparent pointer-events-none"></div>
                            <span>📍 {{ $company->headquarters ?: 'Toronto, ON' }}</span>
                        </div>
                        <p class="text-[9px] text-gray-400 font-bold text-center uppercase tracking-wider">Sitemap locator verified</p>
                    </div>

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
