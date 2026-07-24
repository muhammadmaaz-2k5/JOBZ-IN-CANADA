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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 antialiased min-h-screen flex flex-col relative selection:bg-indigo-500/30">

<!-- Ambient Background Effects -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/20 dark:bg-indigo-600/10 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen"></div>
    <div class="absolute top-[20%] right-[-10%] w-[35%] h-[35%] bg-purple-500/20 dark:bg-purple-600/10 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen"></div>
    <div class="absolute bottom-[-10%] left-[20%] w-[40%] h-[40%] bg-blue-500/20 dark:bg-blue-600/10 blur-[120px] rounded-full mix-blend-multiply dark:mix-blend-screen"></div>
</div>

<!-- Navigation -->
<header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/30 transition-transform group-hover:scale-105">
                    J
                </div>
                <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">
                    JOBZ <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">CA</span>
                </span>
            </a>
            
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('jobs.index') }}" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 transition-colors">Find Jobs</a>
                <a href="{{ route('companies.index') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Companies</a>
                <a href="{{ route('pricing') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pricing</a>
            </nav>
            
            <div class="flex items-center gap-4">
                <button @click="dark = !dark" type="button" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span x-show="!dark">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                        </svg>
                    </span>
                    <span x-show="dark" x-cloak>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </span>
                </button>
                <x-nav-auth />
            </div>
        </div>
    </div>
</header>

<main class="flex-grow relative z-10">
    
    <!-- Hero Section -->
    <section class="pt-16 pb-12 lg:pt-24 lg:pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 dark:bg-gray-800/60 backdrop-blur-md border border-gray-200/50 dark:border-gray-700/50 shadow-sm text-sm font-bold text-gray-700 dark:text-gray-300 mb-8">
                <span class="text-xl">🍁</span> Explore active listings across Canada
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black tracking-tight text-gray-900 dark:text-white mb-6">
                Find Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Dream Career</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 font-medium max-w-2xl mx-auto mb-12">
                Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds.
            </p>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('jobs.index') }}" class="max-w-5xl mx-auto relative z-50">
                <div class="flex flex-col md:flex-row items-center bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl md:rounded-full shadow-2xl shadow-indigo-900/5 p-2 gap-2 md:gap-0">
                    
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
                         class="relative w-full md:flex-1 flex items-center bg-gray-50/50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-2xl md:rounded-l-full md:rounded-r-none transition-colors border border-transparent focus-within:border-indigo-500 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-4 focus-within:ring-indigo-500/10">
                        
                        <div class="pl-6 pr-3 text-indigo-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="keyword" x-model="query" @input.debounce.250ms="fetchSuggestions" @focus="if(suggestions.length > 0) showSuggestions = true" autocomplete="off" class="w-full py-4 pr-4 text-base font-medium text-gray-900 dark:text-white bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400" placeholder="Job title, keywords, or company">
                               
                        <div x-cloak x-show="showSuggestions" class="absolute top-full left-0 w-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden z-50">
                            <ul class="py-2">
                                <template x-for="(sugg, index) in suggestions" :key="index">
                                    <li>
                                        <button type="button" @click="selectSuggestion(sugg.text)" class="w-full text-left px-5 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 flex items-center gap-3 transition-colors text-gray-900 dark:text-gray-100">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                            <span x-text="sugg.text" class="font-medium"></span>
                                        </button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="hidden md:block w-px h-10 bg-gray-200 dark:bg-gray-700"></div>

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
                         class="relative w-full md:flex-1 flex items-center bg-gray-50/50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-2xl md:rounded-none transition-colors border border-transparent focus-within:border-indigo-500 focus-within:bg-white dark:focus-within:bg-gray-900 focus-within:ring-4 focus-within:ring-indigo-500/10">
                        
                        <div class="pl-4 pr-3 text-indigo-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <input type="text" name="location" x-model="query" @input.debounce.250ms="fetchSuggestions" @focus="if(suggestions.length > 0) showSuggestions = true" autocomplete="off" class="w-full py-4 pr-4 text-base font-medium text-gray-900 dark:text-white bg-transparent border-none focus:ring-0 outline-none placeholder-gray-400" placeholder='City, province, or "remote"'>
                               
                        <div x-cloak x-show="showSuggestions" class="absolute top-full left-0 w-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden z-50">
                            <ul class="py-2">
                                <template x-for="(sugg, index) in suggestions" :key="index">
                                    <li>
                                        <button type="button" @click="selectSuggestion(sugg.text)" class="w-full text-left px-5 py-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 flex items-center gap-3 transition-colors text-gray-900 dark:text-gray-100">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span x-text="sugg.text" class="font-medium"></span>
                                        </button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="hidden md:block w-px h-10 bg-gray-200 dark:bg-gray-700"></div>

                    <!-- Sort -->
                    <div class="relative flex items-center w-full md:w-auto px-2">
                        <select name="sort" class="w-full bg-transparent border-none focus:ring-0 outline-none font-medium text-sm py-4 px-3 cursor-pointer form-input-premium">
                            <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                            <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                            <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                            <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="w-full md:w-auto p-1 shrink-0 relative z-20">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black py-4 px-10 rounded-2xl md:rounded-full transition-all shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 whitespace-nowrap text-base hover:-translate-y-0.5">
                            Search Jobs
                        </button>
                    </div>
                </div>

                <!-- Filter Pills -->
                <div class="mt-6 flex flex-wrap items-center justify-center md:justify-start gap-3 z-40 relative">
                    
                    <!-- Pay Pill -->
                    <div x-data="{ open: false, selected: '{{ request('salary_min', '') }}' }" class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="px-5 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-gray-200/60 dark:border-gray-700/60 rounded-full text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                :class="{ 'border-indigo-500 ring-1 ring-indigo-500 bg-white dark:bg-gray-800 text-indigo-700 dark:text-indigo-400': open || selected }">
                            Pay <span x-show="selected" x-cloak class="ml-1 bg-indigo-600 text-white text-[10px] py-0.5 px-2 rounded-full">1</span>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 md:left-auto md:right-0 mt-2 w-72 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 p-5">
                            <div class="max-h-64 overflow-y-auto space-y-3 pr-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="salary_min" value="" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">All Pay</span>
                                </label>
                                @foreach([30000, 50000, 70000, 100000, 150000] as $sal)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="salary_min" value="{{ $sal }}" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                        <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">${{ number_format($sal) }}+/year</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                                <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Reset</button>
                                <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                            </div>
                        </div>
                    </div>

                    <!-- Distance Pill -->
                    <div x-data="{ open: false, selected: '{{ request('distance', '') }}' }" class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="px-5 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-gray-200/60 dark:border-gray-700/60 rounded-full text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                :class="{ 'border-indigo-500 ring-1 ring-indigo-500 bg-white dark:bg-gray-800 text-indigo-700 dark:text-indigo-400': open || selected }">
                            Distance <span x-show="selected" x-cloak class="ml-1 bg-indigo-600 text-white text-[10px] py-0.5 px-2 rounded-full">1</span>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 md:left-auto md:right-0 mt-2 w-72 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 p-5">
                            <div class="max-h-64 overflow-y-auto space-y-3 pr-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="distance" value="0" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Exact location only</span>
                                </label>
                                @foreach([5, 10, 15, 25, 35] as $dist)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="distance" value="{{ $dist }}" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                        <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Within {{ $dist }} km</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                                <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Reset</button>
                                <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                            </div>
                        </div>
                    </div>

                    <!-- Job Type Pill -->
                    <div x-data="{ open: false, selected: '{{ request('employment_type', '') }}' }" class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="px-5 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-gray-200/60 dark:border-gray-700/60 rounded-full text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                :class="{ 'border-indigo-500 ring-1 ring-indigo-500 bg-white dark:bg-gray-800 text-indigo-700 dark:text-indigo-400': open || selected }">
                            Job Type <span x-show="selected" x-cloak class="ml-1 bg-indigo-600 text-white text-[10px] py-0.5 px-2 rounded-full">1</span>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 md:left-auto mt-2 w-64 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 p-5">
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="employment_type" value="" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">All Job Types</span>
                                </label>
                                @foreach(['Full-time', 'Contract', 'Internship', 'Fresher', 'Part-time'] as $type)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="employment_type" value="{{ $type }}" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                        <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                                <button type="button" @click="selected = ''; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Reset</button>
                                <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                            </div>
                        </div>
                    </div>

                    <!-- Date Posted Pill -->
                    <div x-data="{ open: false, selected: '{{ request('posted_date', 'all') }}' }" class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="px-5 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-gray-200/60 dark:border-gray-700/60 rounded-full text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                :class="{ 'border-indigo-500 ring-1 ring-indigo-500 bg-white dark:bg-gray-800 text-indigo-700 dark:text-indigo-400': open || (selected && selected !== 'all') }">
                            Date posted <span x-show="selected !== 'all'" x-cloak class="ml-1 bg-indigo-600 text-white text-[10px] py-0.5 px-2 rounded-full">1</span>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 md:left-auto mt-2 w-64 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 p-5">
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="posted_date" value="all" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                    <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">All dates</span>
                                </label>
                                @foreach([['24h', 'Last 24 hours'], ['3d', 'Last 3 days'], ['7d', 'Last 7 days'], ['14d', 'Last 14 days']] as [$val, $label])
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="posted_date" value="{{ $val }}" x-model="selected" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                        <span class="text-gray-700 dark:text-gray-300 text-sm font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                                <button type="button" @click="selected = 'all'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Reset</button>
                                <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-gray-800 gap-4">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                <span class="w-2 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full inline-block"></span>
                Browse Jobs
            </h2>
            <span class="text-sm font-bold bg-white dark:bg-gray-800 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 shadow-sm">
                <span class="text-indigo-600 dark:text-indigo-400">{{ $jobs->total() }}</span> verified results
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="jobs-grid">
            @forelse($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="md:col-span-2">
                    <x-empty-state title="No Job Listings Found" subtitle="Try clearing search inputs, broadening keyword terms, or selecting different locations." icon="🔍" />
                </div>
            @endforelse
        </div>
        
        <div x-data="{
                 loading: false,
                 nextPageUrl: '{{ $jobs->nextPageUrl() }}',
                 loadMore() {
                     if(this.loading || !this.nextPageUrl) return;
                     this.loading = true;
                     
                     fetch(this.nextPageUrl)
                        .then(res => res.text())
                        .then(html => {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(html, 'text/html');
                            
                            let newGrid = doc.querySelector('#jobs-grid');
                            if (newGrid) {
                                document.querySelector('#jobs-grid').insertAdjacentHTML('beforeend', newGrid.innerHTML);
                            }
                            
                            let newTrigger = doc.querySelector('#load-more-trigger');
                            if (newTrigger && newTrigger.getAttribute('data-url')) {
                                this.nextPageUrl = newTrigger.getAttribute('data-url');
                                $el.setAttribute('data-url', this.nextPageUrl);
                            } else {
                                this.nextPageUrl = null;
                                $el.removeAttribute('data-url');
                            }
                            this.loading = false;
                            
                            setTimeout(() => {
                                if (this.nextPageUrl) {
                                    let rect = $el.getBoundingClientRect();
                                    if (rect.top <= window.innerHeight + 400) {
                                        this.loadMore();
                                    }
                                }
                            }, 100);
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
             data-url="{{ $jobs->nextPageUrl() }}">
             
             <!-- Loading State -->
             <div x-show="loading" class="flex flex-col items-center gap-3">
                 <div class="relative w-12 h-12">
                     <div class="absolute inset-0 rounded-full border-4 border-indigo-200 dark:border-indigo-900"></div>
                     <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
                 </div>
                 <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 tracking-wide animate-pulse">Loading more jobs...</span>
             </div>

             <!-- End State -->
             <div x-cloak x-show="!nextPageUrl && !loading" class="flex flex-col items-center gap-2 opacity-60">
                 <div class="w-16 h-1 bg-gray-300 dark:bg-gray-700 rounded-full mb-2"></div>
                 <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">You've reached the end!</span>
             </div>
        </div>
    </section>

</main>

<!-- Use the existing styled footer component -->
<x-footer />

</body>
</html>
