@php
    use App\Models\Category;
    use App\Models\Skill;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Browse verified Canadian jobs. Filter by location, salary, and work type.">
    <title>Find Jobs — JOBZ IN CANADA</title>
    @vite('resources/js/app.js')
</head>
<body>

<div class="ambient-blobs" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<header class="home-nav">
    <div class="home-nav-inner">
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>
        <nav class="nav-links">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="{{ route('pricing') }}" class="hnav-link">Pricing</a>
            <a href="#" class="hnav-link">Resources</a>
        </nav>
        <div class="nav-actions">
            <button @click="dark = !dark" type="button"
                    class="icon-btn" title="Toggle theme">
                <span x-show="!dark" class="icon-svg">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark" class="icon-svg">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </span>
            </button>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-cta">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="nav-post">Sign In</a>
                <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
            @endauth
        </div>
    </div>
</header><section class="hero !pb-8">
    <div class="hero-inner">
        <div class="hero-badge">
            🍁 Explore active listings across Canada
        </div>
        <h1 class="hero-title">
            Find Your <span class="hero-title-accent">Dream Career</span>
        </h1>
        <p class="hero-subtitle">
            Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds.
        </p>
        <form method="GET" action="{{ route('jobs.index') }}" class="mt-10 flex w-full max-w-6xl mx-auto items-center bg-white border border-gray-300 rounded-full shadow-sm relative p-0.5 z-50">
            <!-- What -->
            <div x-data="{
                    query: '{{ request('keyword') }}',
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
                    query: '{{ request('location') }}',
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
                       placeholder='City, province, or "remote"'>
                       
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

            <!-- Divider -->
            <div class="h-8 w-px bg-gray-300 relative z-0"></div>

            <!-- Sort -->
            <div class="relative flex items-center pr-2">
                <select name="sort" class="bg-transparent border-none focus:ring-0 outline-none text-gray-700 text-sm py-4 px-3 cursor-pointer">
                    <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                    <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                    <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                    <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                </select>
            </div>

            <!-- Button -->
            <div class="pr-1.5 pl-1 shrink-0 relative z-20">
                <button type="submit" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-3.5 px-8 rounded-full transition-colors whitespace-nowrap text-base">
                    Find jobs
                </button>
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="mt-4 flex flex-wrap items-center gap-2 max-w-6xl mx-auto z-40 relative">
            
            <!-- Pay Pill -->
            <div x-data="{ open: false, selected: '{{ request('salary_min', '') }}' }" class="relative">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1650e1] transition-all"
                        :class="{ 'border-gray-900 ring-1 ring-gray-900': open || selected }">
                    Pay <span x-show="selected" x-cloak class="ml-1 bg-gray-900 text-white text-xs py-0.5 px-2 rounded-full">1</span>
                </button>
                <div x-show="open" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-72 bg-white border border-gray-200 rounded-xl shadow-xl z-50 p-4">
                    <div class="max-h-64 overflow-y-auto space-y-3 pr-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">All Pay</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="30000" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">$30,000+/year</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="50000" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">$50,000+/year</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="70000" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">$70,000+/year</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="100000" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">$100,000+/year</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="salary_min" value="150000" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">$150,000+/year</span>
                        </label>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-5 py-2 text-sm font-semibold text-[#1650e1] bg-white border border-transparent rounded-lg hover:bg-blue-50 transition-colors">Reset</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#1650e1] rounded-lg hover:bg-[#0f3ea6] transition-colors">Update</button>
                    </div>
                </div>
            </div>

            <!-- Distance Pill -->
            <div x-data="{ open: false, selected: '{{ request('distance', '') }}' }" class="relative">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1650e1] transition-all"
                        :class="{ 'border-gray-900 ring-1 ring-gray-900 bg-gray-50': open || selected }">
                    Distance <span x-show="selected" x-cloak class="ml-1 bg-gray-900 text-white text-xs py-0.5 px-2 rounded-full">1</span>
                </button>
                <div x-show="open" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-72 bg-white border border-gray-200 rounded-xl shadow-xl z-50 p-4">
                    <div class="max-h-64 overflow-y-auto space-y-3 pr-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="0" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Exact location only</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="5" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Within 5 kilometers</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="10" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Within 10 kilometers</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="15" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Within 15 kilometers</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="25" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Within 25 kilometers</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="distance" value="35" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Within 35 kilometers</span>
                        </label>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-5 py-2 text-sm font-semibold text-[#1650e1] bg-white border border-transparent rounded-lg hover:bg-blue-50 transition-colors">Reset</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#1650e1] rounded-lg hover:bg-[#0f3ea6] transition-colors">Update</button>
                    </div>
                </div>
            </div>

            <!-- Job Type Pill -->
            <div x-data="{ open: false, selected: '{{ request('employment_type', '') }}' }" class="relative">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1650e1] transition-all"
                        :class="{ 'border-gray-900 ring-1 ring-gray-900': open || selected }">
                    Job Type <span x-show="selected" x-cloak class="ml-1 bg-gray-900 text-white text-xs py-0.5 px-2 rounded-full">1</span>
                </button>
                <div x-show="open" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-xl z-50 p-4">
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">All Job Types</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="Full-time" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Full-time</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="Contract" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Contract</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="Internship" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Internship</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="Fresher" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Fresher</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="employment_type" value="Part-time" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Part-time</span>
                        </label>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-5 py-2 text-sm font-semibold text-[#1650e1] bg-white border border-transparent rounded-lg hover:bg-blue-50 transition-colors">Reset</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#1650e1] rounded-lg hover:bg-[#0f3ea6] transition-colors">Update</button>
                    </div>
                </div>
            </div>

            <!-- Job Language Pill -->
            <div x-data="{ open: false, selected: '{{ request('language', '') }}' }" class="relative">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1650e1] transition-all"
                        :class="{ 'border-gray-900 ring-1 ring-gray-900': open || selected }">
                    Job Language <span x-show="selected" x-cloak class="ml-1 bg-gray-900 text-white text-xs py-0.5 px-2 rounded-full">1</span>
                </button>
                <div x-show="open" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-xl z-50 p-4">
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="language" value="" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">All Languages</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="language" value="english" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">English</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="language" value="french" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">French</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="language" value="urdu" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Urdu</span>
                        </label>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-5 py-2 text-sm font-semibold text-[#1650e1] bg-white border border-transparent rounded-lg hover:bg-blue-50 transition-colors">Reset</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#1650e1] rounded-lg hover:bg-[#0f3ea6] transition-colors">Update</button>
                    </div>
                </div>
            </div>

            <!-- Date Posted Pill -->
            <div x-data="{ open: false, selected: '{{ request('posted_date', 'all') }}' }" class="relative">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#1650e1] transition-all"
                        :class="{ 'border-gray-900 ring-1 ring-gray-900': open || (selected && selected !== 'all') }">
                    Date posted <span x-show="selected !== 'all'" x-cloak class="ml-1 bg-gray-900 text-white text-xs py-0.5 px-2 rounded-full">1</span>
                </button>
                <div x-show="open" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-xl z-50 p-4">
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="posted_date" value="all" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">All dates</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="posted_date" value="24h" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Last 24 hours</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="posted_date" value="3d" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Last 3 days</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="posted_date" value="7d" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Last 7 days</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="posted_date" value="14d" x-model="selected" class="w-5 h-5 text-[#1650e1] focus:ring-[#1650e1] border-gray-300">
                            <span class="text-gray-700 text-sm">Last 14 days</span>
                        </label>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="selected = 'all'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-5 py-2 text-sm font-semibold text-[#1650e1] bg-white border border-transparent rounded-lg hover:bg-blue-50 transition-colors">Reset</button>
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-[#1650e1] rounded-lg hover:bg-[#0f3ea6] transition-colors">Update</button>
                    </div>
                </div>
            </div>
            
        </div>
        </form>
    </div>
</section>

<section class="section !pt-4 md:!pt-8">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-indigo"></span>
                <h2 class="section-heading">Browse Jobs</h2>
            </div>
            <span class="results-count">{{ $jobs->total() }} results</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <x-empty-state title="No Job Listings Found" subtitle="Try clearing search inputs, broadening keyword terms, or selecting different locations." icon="🔍" />
            @endforelse
        </div>
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
    </div>
</section>

{{-- RECENTLY VIEWED --}}
@if(count($recentlyViewed) > 0)
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-amber"></span>
                <h2 class="section-heading">Recently Viewed</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($recentlyViewed as $viewedJob)
                <x-job-card :job="$viewedJob" :compact="true" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-footer />

</body>
</html>
