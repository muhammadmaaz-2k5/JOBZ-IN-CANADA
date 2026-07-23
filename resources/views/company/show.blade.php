<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $company->company_name }} - Company Profile</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col">

    <!-- Premium Mesh and Blobs Background -->
    <div class="ambient-blobs" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- Header Navbar -->
    <header class="home-nav sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
        <div class="home-nav-inner">
            <!-- Brand Logo -->
            <a href="/" class="brand">
                <div class="brand-icon">J</div>
                <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="hnav-link">
                    Home
                </a>
                <a href="{{ route('jobs.index') }}" class="hnav-link">
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}" class="hnav-link font-semibold text-[#1650e1]">
                    Companies
                </a>
            </nav>

            <!-- Actions Panel -->
            <div class="nav-actions">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" class="icon-btn" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark">
                        <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-post">Sign In</a>
                    <a href="{{ route('register') }}" class="nav-cta">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full relative z-10" x-data="{ currentTab: 'about' }">
        
        <!-- Breadcrumbs Navigation -->
        <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="/" class="hover:text-[#1650e1] transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('companies.index') }}" class="hover:text-[#1650e1] transition-colors">Companies</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $company->company_name }}</span>
        </nav>

        <!-- Company Cover & Logo Header Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <!-- Cover Image -->
            <div class="h-48 md:h-64 bg-gray-200 relative">
                @if($company->cover_image)
                    <img src="{{ $company->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700"></div>
                @endif
            </div>

            <!-- Profile Header Details -->
            <div class="px-6 sm:px-8 pb-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between -mt-16 md:-mt-20 gap-6">
                    <!-- Logo & Basic Info -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-6">
                        <!-- Logo -->
                        @php
                            $bgColors = [
                                'Shopify Canada' => 'bg-blue-600',
                                'TechNorth Solutions' => 'bg-teal-600',
                                'Maple Finance Group' => 'bg-amber-600',
                                'Northern Health Systems' => 'bg-emerald-600',
                                'CanBridge Engineering' => 'bg-indigo-600',
                            ];
                            $bgClass = $bgColors[$company->company_name] ?? 'bg-[#1650e1]';
                            $avg = $company->reviews()->avg('rating') ?: 4.5;
                        @endphp
                        <div class="w-32 h-32 rounded-2xl border-4 border-white shadow-md flex-shrink-0 flex items-center justify-center text-4xl font-bold text-white {{ $company->logo ? 'bg-white' : $bgClass }} relative z-10">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                {{ strtoupper(substr($company->company_name, 0, 2)) }}
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div class="pt-2">
                            <div class="flex items-center gap-2">
                                <h1 class="text-3xl font-bold text-gray-900">
                                    {{ $company->company_name }}
                                </h1>
                                @if($company->verification_status === 'verified')
                                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" title="Verified Employer">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>

                            <p class="text-gray-600 mt-2 flex items-center gap-2 text-sm sm:text-base">
                                <span>📍 {{ $company->headquarters ?: 'Canada' }}</span>
                                <span class="text-gray-300">&bull;</span>
                                <span>🏷️ {{ $company->industry ?: 'Industry' }}</span>
                            </p>

                            <!-- Rating summary -->
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex text-amber-400 text-lg">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= round($avg) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-600">({{ number_format($avg, 1) }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action items -->
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener" class="flex-1 md:flex-none text-center bg-white border border-gray-300 text-gray-700 font-medium py-2.5 px-6 rounded-lg hover:bg-gray-50 transition-colors">
                                Visit Website ↗
                            </a>
                        @endif
                        <button type="button" class="flex-1 md:flex-none bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-2.5 px-8 rounded-lg transition-colors">
                            Follow
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex overflow-x-auto gap-6 mt-8 border-b border-gray-200">
                    <button @click="currentTab = 'about'" :class="{ 'border-[#1650e1] text-[#1650e1] font-semibold': currentTab === 'about', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'about' }" class="pb-4 border-b-2 whitespace-nowrap transition-colors">
                        About
                    </button>
                    <button @click="currentTab = 'jobs'" :class="{ 'border-[#1650e1] text-[#1650e1] font-semibold': currentTab === 'jobs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'jobs' }" class="pb-4 border-b-2 whitespace-nowrap transition-colors">
                        Current Jobs ({{ $jobs->count() }})
                    </button>
                    <button @click="currentTab = 'reviews'" :class="{ 'border-[#1650e1] text-[#1650e1] font-semibold': currentTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'reviews' }" class="pb-4 border-b-2 whitespace-nowrap transition-colors">
                        Reviews ({{ $reviews->count() }})
                    </button>
                    <button @click="currentTab = 'gallery'" :class="{ 'border-[#1650e1] text-[#1650e1] font-semibold': currentTab === 'gallery', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'gallery' }" class="pb-4 border-b-2 whitespace-nowrap transition-colors">
                        Gallery &amp; Culture
                    </button>
                </div>
            </div>
        </div>

        <!-- Tab Panels Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content Pane -->
            <div class="lg:col-span-2">
                
                <!-- Tab: About -->
                <div x-show="currentTab === 'about'" x-transition.opacity.duration.300ms>
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Company Overview</h3>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-8">{{ $company->description ?: 'No description provided for this company yet.' }}</p>
                        
                        <!-- Core Details Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-6 border-t border-gray-100">
                            <div>
                                <span class="block text-sm text-gray-500 mb-1">Industry</span>
                                <p class="font-semibold text-gray-900">{{ $company->industry ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500 mb-1">Company Size</span>
                                <p class="font-semibold text-gray-900">{{ $company->company_size ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500 mb-1">Founded</span>
                                <p class="font-semibold text-gray-900">{{ $company->founded_year ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="block text-sm text-gray-500 mb-1">Headquarters</span>
                                <p class="font-semibold text-gray-900">{{ $company->headquarters ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Open Jobs -->
                <div x-show="currentTab === 'jobs'" x-transition.opacity.duration.300ms style="display: none;">
                    <div class="space-y-4">
                        @forelse($jobs as $job)
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-[#1650e1] transition-colors">{{ $job->title }}</a>
                                    </h4>
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">📍 {{ $job->city }}</span>
                                        <span class="text-gray-300">&bull;</span>
                                        <span class="flex items-center gap-1">💼 {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                                        <span class="text-gray-300">&bull;</span>
                                        <span class="flex items-center gap-1">💰 
                                            @if($job->salary_min && $job->salary_max)
                                                ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }} {{ $job->currency }}
                                            @elseif($job->salary_min)
                                                From ${{ number_format($job->salary_min) }} {{ $job->currency }}
                                            @else
                                                Salary Undisclosed
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="inline-flex justify-center items-center bg-[#1650e1]/10 text-[#1650e1] hover:bg-[#1650e1] hover:text-white font-semibold py-2 px-6 rounded-lg transition-colors whitespace-nowrap">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center shadow-sm">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">No Active Job Opportunities</h4>
                                <p class="text-gray-500">This company has no published openings at the moment. Check back later.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: Reviews -->
                <div x-show="currentTab === 'reviews'" x-transition.opacity.duration.300ms style="display: none;">
                    
                    <!-- Summary and Rating Grid -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm mb-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                        <div class="text-center md:border-r border-gray-200 md:pr-8">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Average Rating</h4>
                            <p class="text-5xl font-bold text-gray-900 mb-2">{{ number_format($avg, 1) }}</p>
                            <div class="flex justify-center text-amber-400 text-2xl mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= round($avg) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500">Based on {{ $reviews->count() ?: 12 }} reviews</p>
                        </div>
                        <div class="md:col-span-2">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Candidate Opinion</h4>
                            <div class="space-y-3">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 text-sm font-medium text-gray-600">5 ★</span>
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: 75%"></div>
                                    </div>
                                    <span class="w-10 text-right text-sm text-gray-500">75%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="w-8 text-sm font-medium text-gray-600">4 ★</span>
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: 20%"></div>
                                    </div>
                                    <span class="w-10 text-right text-sm text-gray-500">20%</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="w-8 text-sm font-medium text-gray-600">3 ★</span>
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: 5%"></div>
                                    </div>
                                    <span class="w-10 text-right text-sm text-gray-500">5%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Write a Review Form -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm mb-6" x-data="{ openForm: false }">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Have you worked here?</h4>
                                <p class="text-gray-500 text-sm mt-1">Share your experience to help other job seekers.</p>
                            </div>
                            <button @click="openForm = !openForm" class="bg-white border-2 border-[#1650e1] text-[#1650e1] font-bold py-2 px-6 rounded-lg hover:bg-blue-50 transition-colors whitespace-nowrap">
                                Write a Review
                            </button>
                        </div>
                        
                        <form x-show="openForm" x-transition class="mt-6 pt-6 border-t border-gray-100 space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                                <select class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1650e1] focus:border-transparent outline-none">
                                    <option value="5">★★★★★ (5 - Excellent)</option>
                                    <option value="4">★★★★☆ (4 - Very Good)</option>
                                    <option value="3">★★★☆☆ (3 - Average)</option>
                                    <option value="2">★★☆☆☆ (2 - Poor)</option>
                                    <option value="1">★☆☆☆☆ (1 - Very Poor)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Summary / Title</label>
                                <input type="text" placeholder="e.g. Great work-life balance and supportive team" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1650e1] focus:border-transparent outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Detailed Feedback</label>
                                <textarea rows="4" placeholder="Share details about the interview process, company culture, benefits, or general work experience..." class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1650e1] focus:border-transparent outline-none"></textarea>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                <button type="button" @click="openForm = false" class="px-6 py-2.5 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">Cancel</button>
                                <button type="button" @click="openForm = false" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-2.5 px-6 rounded-lg transition-colors">Submit Review</button>
                            </div>
                        </form>
                    </div>

                    <!-- Review Cards list -->
                    <div class="space-y-4">
                        @forelse($reviews as $rev)
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                                    <div>
                                        <div class="text-amber-400 text-lg mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $rev->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                        <h5 class="text-lg font-bold text-gray-900">{{ $rev->title }}</h5>
                                    </div>
                                    <span class="text-sm text-gray-500 whitespace-nowrap">{{ $rev->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-gray-700 leading-relaxed mb-4">{{ $rev->comment }}</p>
                                <p class="text-sm text-gray-500 font-medium">By: {{ $rev->user->first_name ?? 'Anonymous Candidate' }}</p>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center shadow-sm">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">No Reviews Yet</h4>
                                <p class="text-gray-500">Be the first to share your experience with this employer.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: Gallery & Culture -->
                <div x-show="currentTab === 'gallery'" x-transition.opacity.duration.300ms style="display: none;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Our Core Values</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Innovation</h4>
                                <p class="text-sm text-gray-600">Constantly seeking newer solutions to help candidates scale in their domains.</p>
                            </div>
                            <div class="bg-indigo-50/50 p-6 rounded-xl border border-indigo-100">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Inclusion</h4>
                                <p class="text-sm text-gray-600">Embracing diverse candidates and backgrounds to enrich the local marketplace.</p>
                            </div>
                            <div class="bg-teal-50/50 p-6 rounded-xl border border-teal-100">
                                <div class="w-12 h-12 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Reliability</h4>
                                <p class="text-sm text-gray-600">Ensuring verified jobs, safe billing transactions, and responsive layouts.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery section -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Office &amp; Team Gallery</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="group relative rounded-xl overflow-hidden aspect-[4/3] bg-gray-100 flex items-center justify-center cursor-pointer">
                                <span class="text-4xl group-hover:scale-110 transition-transform">🏢</span>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                    <span class="text-white font-bold">Office Space</span>
                                    <span class="text-gray-200 text-xs">Headquarters</span>
                                </div>
                            </div>
                            <div class="group relative rounded-xl overflow-hidden aspect-[4/3] bg-gray-100 flex items-center justify-center cursor-pointer">
                                <span class="text-4xl group-hover:scale-110 transition-transform">👥</span>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                    <span class="text-white font-bold">Team Meeting</span>
                                    <span class="text-gray-200 text-xs">Collaboration</span>
                                </div>
                            </div>
                            <div class="group relative rounded-xl overflow-hidden aspect-[4/3] bg-gray-100 flex items-center justify-center cursor-pointer">
                                <span class="text-4xl group-hover:scale-110 transition-transform">☕</span>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                    <span class="text-white font-bold">Breakout Area</span>
                                    <span class="text-gray-200 text-xs">Social Lounge</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Details Panel -->
            <div class="space-y-6">
                
                <!-- Quick Info -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Followers:</span>
                            <span class="font-bold text-gray-900">
                                @if($company->company_name === 'Shopify Canada') 12.4k @elseif($company->company_name === 'TechNorth Solutions') 3.2k @elseif($company->company_name === 'Maple Finance Group') 8.9k @elseif($company->company_name === 'Northern Health Systems') 5.6k @elseif($company->company_name === 'CanBridge Engineering') 2.1k @else 1.2k @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Job Listings:</span>
                            <span class="font-bold text-gray-900">{{ $jobs->count() }} active</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Average Review:</span>
                            <span class="font-bold text-gray-900">{{ number_format($avg, 1) }} / 5.0</span>
                        </div>
                    </div>
                </div>

                <!-- Headquarters Location Interactive Map simulation -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Office Location</h3>
                    <div class="rounded-xl overflow-hidden bg-gray-100 aspect-video relative mb-3 group cursor-pointer">
                        <div class="absolute inset-0 bg-blue-50 border-2 border-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="font-medium text-gray-900 flex items-start gap-2">
                        <span class="mt-0.5">📍</span>
                        <span>{{ $company->headquarters ?: 'Toronto, ON' }}</span>
                    </p>
                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <x-footer />

</body>
</html>
