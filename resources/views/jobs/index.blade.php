<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore Opportunities - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-100 bg-gray-50/30 dark:bg-dark-950 min-h-screen transition-colors duration-300">

    <!-- Premium Glow Background Elements -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-48 right-1/4 w-80 h-80 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Navbar (Homepage Style) -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-855 shadow-glass">
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
                <a href="{{ route('jobs.index') }}" class="text-primary-500 dark:text-white font-bold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
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
                <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-white dark:bg-dark-800 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-dark-750 transition-colors" title="Toggle Theme">
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

    <!-- Top Hero and Search Hub Section -->
    <div class="relative overflow-hidden pt-12 pb-14 bg-gradient-to-b from-primary-50/30 via-transparent to-transparent dark:from-primary-950/5 no-print">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_80%,transparent_100%)] pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10 text-center space-y-6">
            <!-- Alert Badge -->
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-semibold bg-white dark:bg-dark-850 text-primary-600 dark:text-primary-400 border border-gray-150 dark:border-gray-800 shadow-sm uppercase tracking-widest">
                🍁 Explore active listings across Canada
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-none text-gray-900 dark:text-white">
                Find Your <span class="bg-gradient-to-r from-primary-500 to-indigo-650 bg-clip-text text-transparent">Dream Career</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-lg mx-auto font-medium">
                Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds with our unified wizard.
            </p>

            <!-- Search Console Form -->
            <div class="bg-white/80 dark:bg-dark-900/80 backdrop-blur-xl p-3.5 rounded-3xl md:rounded-full shadow-premium border border-gray-200/60 dark:border-gray-800 max-w-4xl mx-auto relative mt-6"
                 x-data="{ 
                     keyword: '{{ request('keyword') }}', 
                     suggestions: [], 
                     showSuggestions: false,
                     fetchSuggestions() {
                          if (this.keyword.length < 2) {
                              this.suggestions = [];
                              return;
                          }
                          fetch('/api/jobs/suggestions?query=' + encodeURIComponent(this.keyword))
                              .then(res => res.json())
                              .then(data => {
                                  this.suggestions = data;
                              });
                     }
                 }">
                <form method="GET" action="{{ route('jobs.index') }}" class="flex flex-col md:flex-row items-center gap-3">
                    
                    <!-- Keyword input -->
                    <div class="flex-1 w-full flex items-center px-4 py-2.5 border-b md:border-b-0 md:border-r border-gray-150 dark:border-gray-800 relative">
                        <span class="text-gray-400 dark:text-gray-500 text-sm">🔍</span>
                        <input id="keyword" name="keyword" type="text" 
                                x-model="keyword"
                                @input.debounce.300ms="fetchSuggestions()"
                                @focus="showSuggestions = true"
                                @click.away="setTimeout(() => showSuggestions = false, 200)"
                                class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold placeholder-gray-400 dark:placeholder-gray-600 dark:text-gray-200" 
                                placeholder="Job title, keywords, or company..." />

                        <!-- Suggestions Dropdown -->
                        <div x-show="showSuggestions && suggestions.length > 0" 
                             class="absolute left-0 right-0 top-full mt-3 bg-white dark:bg-dark-900 border border-gray-200 dark:border-gray-805 rounded-2xl shadow-2xl z-50 overflow-hidden divide-y divide-gray-100 dark:divide-gray-850 max-h-60 overflow-y-auto text-left"
                             x-transition>
                            <template x-for="item in suggestions">
                                <button type="button" 
                                        @click="keyword = item.text; showSuggestions = false; $el.closest('form').submit()"
                                        class="w-full text-left px-4.5 py-3 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-850/60 flex justify-between items-center transition">
                                    <span x-text="item.text"></span>
                                    <span class="text-[9px] uppercase font-black text-gray-400 bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded" x-text="item.type.replace('_', ' ')"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Location input -->
                    <div class="flex-1 w-full flex items-center px-4 py-2.5 border-b md:border-b-0 md:border-r border-gray-150 dark:border-gray-800">
                        <span class="text-gray-400 dark:text-gray-500 text-sm">📍</span>
                        <input id="location" name="location" type="text" 
                               class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold placeholder-gray-400 dark:placeholder-gray-600 dark:text-gray-200" 
                               placeholder="City, province, or 'Remote'..." 
                               value="{{ request('location') }}" />
                    </div>

                    <!-- Sort Options & Submit -->
                    <div class="w-full md:w-auto flex items-center gap-3 pl-2">
                        <div class="flex items-center bg-gray-50 dark:bg-dark-850 px-3 py-1.5 rounded-xl border border-gray-150 dark:border-gray-800 shrink-0">
                            <span class="text-gray-400 text-3xs font-black uppercase tracking-wider mr-1.5">Sort:</span>
                            <select id="sort" name="sort" class="bg-transparent border-0 p-0 text-3xs font-bold text-gray-700 dark:text-gray-350 cursor-pointer focus:ring-0">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                                <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                                <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                                <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full md:w-auto btn btn-primary px-8 py-3 rounded-full shrink-0 font-bold text-xs shadow-md">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Searches history chips -->
            @if(session()->has('recent_searches') && count(session('recent_searches')) > 0)
                <div class="flex items-center justify-center flex-wrap gap-2.5 text-xs pt-1">
                    <span class="text-[9px] font-black uppercase text-gray-400 dark:text-gray-500 tracking-widest">Recent Searches:</span>
                    @foreach(session('recent_searches') as $search)
                        <a href="{{ $search['url'] }}" class="inline-flex items-center px-3.5 py-1.5 bg-white dark:bg-dark-900 hover:bg-primary-50 dark:hover:bg-dark-800 hover:text-primary-600 dark:hover:text-primary-400 text-gray-600 dark:text-gray-350 rounded-full transition-all duration-200 border border-gray-150 dark:border-gray-800 font-bold text-3xs shadow-sm">
                            "{{ $search['keyword'] }}" {{ $search['location'] ? 'in ' . $search['location'] : '' }}
                        </a>
                    @endforeach
                    <form method="POST" action="{{ route('jobs.history.clear-search') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[9px] font-bold text-rose-500 hover:text-rose-650 hover:underline transition cursor-pointer">Clear History</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Listings Section -->
    <div class="py-6 bg-gray-50/30 dark:bg-dark-950 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Recently Viewed horizontally -->
            @if(count($recentlyViewed) > 0)
                <x-card variant="glass" class="p-5 border border-gray-200/50 dark:border-gray-850/80 shadow-sm space-y-3 no-print">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100 dark:border-gray-850">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm">🕒</span>
                            <h4 class="font-bold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest">Recently Viewed Listings</h4>
                        </div>
                        <form method="POST" action="{{ route('jobs.history.clear-viewed') }}">
                            @csrf
                            <button type="submit" class="text-[10px] font-bold text-rose-500 hover:text-rose-600 hover:underline transition">Clear history</button>
                        </form>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($recentlyViewed as $viewedJob)
                            <div class="text-xs bg-white/40 dark:bg-dark-900/30 p-3 rounded-xl border border-gray-150/40 dark:border-gray-800/80 hover:border-primary-500/20 transition-all duration-200 flex flex-col justify-between">
                                <a href="{{ route('jobs.show', $viewedJob->slug) }}" class="font-bold text-gray-900 dark:text-white hover:text-primary-500 transition line-clamp-1 leading-snug">{{ $viewedJob->title }}</a>
                                <p class="text-4xs text-gray-400 dark:text-gray-500 mt-1.5 uppercase font-black tracking-widest">{{ $viewedJob->company->company_name }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif

            <!-- Job listings grid cards -->
            <div class="space-y-4">
                @forelse($jobs as $job)
                    <x-card variant="default" class="group relative p-6 transition-all duration-300 hover:shadow-premium hover:-translate-y-0.5 border border-gray-200/40 dark:border-gray-800">
                        @if($job->featured)
                            <div class="absolute top-0 right-0 bg-gradient-to-l from-primary-600 to-indigo-650 text-white text-[8px] font-black px-3.5 py-1 rounded-bl-xl rounded-tr-2xl uppercase tracking-widest shadow-sm">
                                Featured
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                            <div class="flex items-start gap-4">
                                <!-- Company Logo wrapper -->
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
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-sm font-black shadow-inner flex-shrink-0 {{ $bgClass }} border border-gray-250 dark:border-gray-800 group-hover:scale-[1.03] transition-all duration-300">
                                    @if($job->company->logo)
                                        <img src="{{ $job->company->logo }}" alt="Logo" class="max-h-full max-w-full object-contain p-2 rounded-2xl" />
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-base text-gray-900 dark:text-white group-hover:text-primary-500 transition duration-150 leading-snug">
                                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                        </h4>
                                        @if($job->urgent)
                                            <span class="px-2.5 py-0.5 rounded-full text-[8px] font-extrabold bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-455 border border-rose-100 dark:border-rose-900/30 uppercase tracking-widest">Urgent</span>
                                        @endif
                                        @if($job->screeningQuestions->count() === 0)
                                            <span class="px-2.5 py-0.5 rounded-full text-[8px] font-extrabold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-455 border border-emerald-100 dark:border-emerald-900/30 uppercase tracking-widest">⚡ Easy Apply</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                        {{ $job->company->company_name }}
                                        @if($job->company->verification_status === 'verified')
                                            <span class="inline-flex items-center justify-center w-4.5 h-4.5 bg-primary-100 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold" title="Verified Employer">✓</span>
                                        @endif
                                    </p>
                                    
                                    <div class="flex items-center gap-3.5 text-xs text-gray-450 dark:text-gray-400 flex-wrap font-semibold">
                                        <span class="flex items-center gap-1">📍 {{ $job->city }}, {{ $job->country }}</span>
                                        <span class="text-gray-300 dark:text-gray-700">&bull;</span>
                                        <span class="flex items-center gap-1">💼 {{ ucfirst($job->workplace_type) }}</span>
                                        <span class="text-gray-300 dark:text-gray-700">&bull;</span>
                                        <span class="flex items-center gap-1">⏰ {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                                    </div>
                                    
                                    <!-- Display Salary if Visible -->
                                    @if($job->salary_min || $job->salary_max)
                                        <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-100/40 dark:border-emerald-900/20 text-xs font-bold text-emerald-600 dark:text-emerald-450 mt-1">
                                            💵 {{ $job->currency }} 
                                            @if($job->salary_min && $job->salary_max)
                                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            @elseif($job->salary_min)
                                                {{ number_format($job->salary_min) }}
                                            @endif
                                            / {{ ucfirst($job->salary_type ?? 'yearly') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full sm:w-auto flex shrink-0 justify-end">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-sm btn-primary w-full sm:w-auto py-2.5 px-6 font-bold shadow-md">
                                    View details
                                </a>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <x-empty-state title="No Job Listings Found" subtitle="Try clearing search inputs, broadening keyword terms, or selecting different locations." icon="🔍" />
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobs->links() }}
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
