@php
    try {
        $latestJobs = \App\Models\Job::with(['company', 'skills', 'screeningQuestions'])
            ->where('status', 'published')->latest()->paginate(6);
        
        $companies  = \App\Models\Company::with('jobs')->where('verification_status', 'verified')->latest()->take(5)->get();
        $jobsCount  = \App\Models\Job::where('status', 'published')->count();
    } catch (\Throwable $e) {
        $latestJobs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6);
        $companies = collect(); $jobsCount = 0;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Canada's premier job board. Find verified jobs from top Canadian employers.">
    <title>JOBZ IN CANADA — Find Your Dream Job</title>
    @vite('resources/js/app.js')
</head>
<body>

{{-- ══════════════════════════════════════
     AMBIENT BLOBS
══════════════════════════════════════ --}}
<div class="ambient-blobs" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

{{-- ══════════════════════════════════════
     NAVBAR
══════════════════════════════════════ --}}
<header class="home-nav">
    <div class="home-nav-inner">

        {{-- Brand --}}
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="nav-links">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="{{ route('pricing') }}" class="hnav-link">Pricing</a>
        </nav>

        {{-- Actions --}}
        <div class="nav-actions">
            {{-- Search icon --}}
            <button class="icon-btn" title="Search">
                <svg width=".9rem" height=".9rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>



            <a href="{{ route('register') }}" class="nav-post">
                Sign In
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
            @endauth
        </div>
    </div>
</header>

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section class="hero !pb-8">
    <div class="hero-inner">



        {{-- H1 --}}
        <h1 class="hero-title">
            Find your dream job<br>
            in <span class="hero-title-accent">Canada</span>
        </h1>

        <p class="hero-subtitle">
            Discover thousands of exciting opportunities from Canada's top verified employers.
            Transparent salaries, remote options &amp; one-click applications.
        </p>

        {{-- Search bar --}}
        <form action="{{ route('jobs.index') }}" method="GET" 
              class="mt-10 flex w-full max-w-5xl mx-auto items-center bg-white border border-gray-300 rounded-full shadow-sm relative p-0.5 z-50">
            
            <!-- What -->
            <div x-data="{
                    query: '',
                    suggestions: [],
                    showSuggestions: false,
                    fetchSuggestions() {
                        if(this.query.length < 2) {
                            this.suggestions = [];
                            this.showSuggestions = false;
                            return;
                        }
                        fetch('/api/jobs/suggestions?query=' + encodeURIComponent(this.query))
                            .then(res => res.json())
                            .then(data => {
                                this.suggestions = data;
                                this.showSuggestions = data.length > 0;
                            });
                    },
                    selectSuggestion(text) {
                        this.query = text;
                        this.showSuggestions = false;
                    }
                 }"
                 @click.away="showSuggestions = false"
                 class="relative flex-1 flex items-center focus-within:ring-2 focus-within:ring-[#1650e1] focus-within:z-10 rounded-l-full transition-all">
                
                <div class="pl-6 pr-3 text-gray-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="keyword" 
                       x-model="query"
                       @input.debounce.250ms="fetchSuggestions"
                       @focus="if(suggestions.length > 0) showSuggestions = true"
                       autocomplete="off"
                       class="w-full py-4 pr-4 text-base text-gray-900 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-500" 
                       placeholder="Job title, keywords, or company">
                       
                <!-- Dropdown -->
                <div x-cloak x-show="showSuggestions"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 w-[120%] sm:w-[150%] md:w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden z-50">
                    <ul class="py-2">
                        <template x-for="(sugg, index) in suggestions" :key="index">
                            <li>
                                <button type="button" @click="selectSuggestion(sugg.text)" 
                                        class="w-full text-left px-5 py-3 hover:bg-blue-50 flex items-center gap-3 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span x-text="sugg.text" class="text-gray-900 text-base font-medium"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-8 w-px bg-gray-300 relative z-0"></div>

            <!-- Where -->
            <div x-data="{
                    query: '',
                    suggestions: [],
                    showSuggestions: false,
                    fetchSuggestions() {
                        if(this.query.length < 2) {
                            this.suggestions = [];
                            this.showSuggestions = false;
                            return;
                        }
                        fetch('/api/jobs/suggestions?query=' + encodeURIComponent(this.query))
                            .then(res => res.json())
                            .then(data => {
                                let locs = data.filter(s => s.type === 'location');
                                // Hardcode Remote if it matches query
                                if ('remote'.includes(this.query.toLowerCase()) && !locs.find(s => s.text.toLowerCase() === 'remote')) {
                                    locs.unshift({ text: 'Remote', type: 'location' });
                                }
                                this.suggestions = locs;
                                this.showSuggestions = this.suggestions.length > 0;
                            });
                    },
                    selectSuggestion(text) {
                        this.query = text;
                        this.showSuggestions = false;
                    }
                 }"
                 @click.away="showSuggestions = false"
                 class="relative flex-1 flex items-center focus-within:ring-2 focus-within:ring-[#1650e1] focus-within:z-10 transition-all">
                
                <div class="pl-4 pr-3 text-gray-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                
                <input type="text" name="location" 
                       x-model="query"
                       @input.debounce.250ms="fetchSuggestions"
                       @focus="if(suggestions.length > 0) showSuggestions = true"
                       autocomplete="off"
                       class="w-full py-4 pr-4 text-base text-gray-900 bg-transparent border-none focus:ring-0 outline-none placeholder-gray-500" 
                       placeholder='City, state, zip code, or "remote"'>
                       
                <!-- Dropdown -->
                <div x-cloak x-show="showSuggestions"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 w-[120%] sm:w-[150%] md:w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden z-50">
                    <ul class="py-2">
                        <template x-for="(sugg, index) in suggestions" :key="index">
                            <li>
                                <button type="button" @click="selectSuggestion(sugg.text)" 
                                        class="w-full text-left px-5 py-3 hover:bg-blue-50 flex items-center gap-3 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span x-text="sugg.text" class="text-gray-900 text-base font-medium"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Button -->
            <div class="pr-1.5 pl-1 shrink-0 relative z-20">
                <button type="submit" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-3.5 px-8 rounded-full transition-colors whitespace-nowrap text-base">
                    Find jobs
                </button>
            </div>
        </form>

        {{-- Popular tags --}}
        <div class="popular-chips">
            <span class="popular-label">Popular:</span>
            @foreach(['Tech', 'Remote', 'Software Engineering', 'Healthcare', 'Finance', 'Design'] as $cat)
                <a href="{{ route('jobs.index', ['category' => $cat]) }}" class="chip">{{ $cat }}</a>
            @endforeach
        </div>
    </div>
</section>



{{-- ══════════════════════════════════════
     LATEST JOBS
══════════════════════════════════════ --}}
<section class="section !pt-4 md:!pt-8" id="latest-jobs">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-rose"></span>
                <h2 class="section-heading">Latest Jobs</h2>
                <span class="text-muted-xs">Recently posted opportunities across Canada</span>
            </div>
        </div>

        <div class="feat-grid" id="latest-jobs-grid">
            @forelse($latestJobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="feat-empty">
                    No latest jobs right now &mdash;
                    <a href="{{ route('jobs.index') }}" class="text-indigo">browse all jobs</a>
                </div>
            @endforelse
        </div>
        <div x-data="{
                 loading: false,
                 nextPageUrl: '{{ $latestJobs->nextPageUrl() }}',
                 loadMore() {
                     if(this.loading || !this.nextPageUrl) return;
                     this.loading = true;
                     
                     fetch(this.nextPageUrl)
                        .then(res => res.text())
                        .then(html => {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, 'text/html');
                            
                            let newGrid = doc.querySelector('#latest-jobs-grid');
                            if (newGrid) {
                                document.querySelector('#latest-jobs-grid').insertAdjacentHTML('beforeend', newGrid.innerHTML);
                            }
                            
                            let newTrigger = doc.querySelector('#load-more-trigger');
                            if (newTrigger && newTrigger.getAttribute('data-url')) {
                                this.nextPageUrl = newTrigger.getAttribute('data-url');
                            } else {
                                this.nextPageUrl = null;
                            }
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                 }
             }"
             x-init="
                 let observer = new IntersectionObserver((entries) => {
                     if (entries[0].isIntersecting) {
                         loadMore();
                     }
                 }, { rootMargin: '400px' });
                 observer.observe($el);
             "
             class="mt-12 flex justify-center py-8"
             id="load-more-trigger"
             data-url="{{ $latestJobs->nextPageUrl() }}">
             
             <!-- Loading State -->
             <div x-show="loading" class="flex flex-col items-center gap-3">
                 <div class="relative w-10 h-10">
                     <div class="absolute inset-0 rounded-full border-4 border-indigo-100"></div>
                     <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
                 </div>
                 <span class="text-sm font-medium text-indigo-600 tracking-wide animate-pulse">Fetching more opportunities...</span>
             </div>

             <!-- End State -->
             <div x-cloak x-show="!nextPageUrl && !loading" class="flex flex-col items-center gap-2 opacity-60">
                 <div class="w-16 h-1 bg-gray-200 rounded-full mb-2"></div>
                 <span class="text-sm font-medium text-gray-500">You've reached the end!</span>
                 <span class="text-xs text-gray-400">No more jobs to load.</span>
             </div>
        </div>
    </div>
</section>





<x-footer />

</body>
</html>
