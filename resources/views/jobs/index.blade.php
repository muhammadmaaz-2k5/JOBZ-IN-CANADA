<x-app-layout>
    <!-- Visual Gradient Background wave -->
    <div class="relative overflow-hidden pt-12 pb-16 bg-gradient-to-b from-primary-50/50 via-transparent to-transparent dark:from-primary-950/10 no-print">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(99,102,241,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(99,102,241,0.04)_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-6">
            <!-- Alert Badge -->
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[10px] font-bold bg-primary-100/80 text-primary-700 dark:bg-primary-950/40 dark:text-primary-400 border border-primary-200/20 backdrop-blur-sm uppercase tracking-wider">
                🍁 Explore active opportunities across Canada
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-none text-gray-900 dark:text-white">
                Find your next <span class="bg-gradient-to-r from-primary-500 to-indigo-600 bg-clip-text text-transparent">career move</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-xl mx-auto font-medium">
                Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds with our unified wizard.
            </p>

            <!-- Centered Global Search Form -->
            <div class="bg-white dark:bg-dark-800 p-2.5 rounded-2xl md:rounded-full shadow-premium border border-gray-150 dark:border-gray-800 max-w-3xl mx-auto relative mt-6"
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
                <form method="GET" action="{{ route('jobs.index') }}" class="flex flex-col md:flex-row items-center gap-2">
                    
                    <!-- Keyword input with suggestions dropdown -->
                    <div class="flex-1 w-full flex items-center px-4 py-2 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700 relative">
                        <span class="text-gray-450 text-sm">🔍</span>
                        <input id="keyword" name="keyword" type="text" 
                               x-model="keyword"
                               @input.debounce.300ms="fetchSuggestions()"
                               @focus="showSuggestions = true"
                               @click.away="setTimeout(() => showSuggestions = false, 200)"
                               class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold dark:placeholder-gray-500 dark:text-gray-200" 
                               placeholder="Job title, keywords, or company" />

                        <!-- Suggestions Dropdown List -->
                        <div x-show="showSuggestions && suggestions.length > 0" 
                             class="absolute left-0 right-0 top-full mt-2 bg-white dark:bg-gray-800 border border-gray-150 dark:border-gray-700 rounded-xl shadow-2xl z-50 overflow-hidden divide-y divide-gray-50 dark:divide-gray-750 max-h-60 overflow-y-auto text-left">
                            <template x-for="item in suggestions">
                                <button type="button" 
                                        @click="keyword = item.text; showSuggestions = false; $el.closest('form').submit()"
                                        class="w-full text-left px-4 py-2.5 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-950/40 flex justify-between items-center transition">
                                    <span x-text="item.text"></span>
                                    <span class="text-[9px] uppercase font-black text-gray-400 bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded" x-text="item.type.replace('_', ' ')"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Location input -->
                    <div class="flex-1 w-full flex items-center px-4 py-2 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700">
                        <span class="text-gray-450 text-sm">📍</span>
                        <input id="location" name="location" type="text" 
                               class="w-full bg-transparent border-0 focus:ring-0 focus:outline-none ml-3 text-xs font-semibold dark:placeholder-gray-500 dark:text-gray-200" 
                               placeholder="City, province, or 'Remote'" 
                               value="{{ request('location') }}" />
                    </div>

                    <!-- Sort Selection & Button -->
                    <div class="w-full md:w-auto flex items-center gap-2 pl-2">
                        <select id="sort" name="sort" class="bg-transparent border-0 focus:ring-0 focus:outline-none text-xs font-bold text-gray-500 dark:text-gray-400 cursor-pointer">
                            <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                            <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                            <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                            <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                        </select>
                        
                        <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-xl md:rounded-full bg-primary-500 hover:bg-primary-600 text-white font-extrabold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer shrink-0">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Searches History chips -->
            @if(session()->has('recent_searches') && count(session('recent_searches')) > 0)
                <div class="flex items-center justify-center flex-wrap gap-2.5 text-xs">
                    <span class="text-[10px] font-black uppercase text-gray-400">Recent:</span>
                    @foreach(session('recent_searches') as $search)
                        <a href="{{ $search['url'] }}" class="px-3 py-1 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-dark-750 text-gray-650 dark:text-gray-300 rounded-full transition border border-gray-150 dark:border-gray-750 font-bold text-3xs">
                            "{{ $search['keyword'] }}" {{ $search['location'] ? 'in ' . $search['location'] : '' }}
                        </a>
                    @endforeach
                    <form method="POST" action="{{ route('jobs.history.clear-search') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[9px] font-bold text-red-500 hover:underline cursor-pointer">Clear</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Listings Column (Centered) -->
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Recently Viewed list horizontally in head, if exists -->
            @if(count($recentlyViewed) > 0)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-150 dark:border-gray-700/50 space-y-3 no-print">
                    <div class="flex justify-between items-center pb-1.5 border-b border-gray-100 dark:border-gray-750">
                        <h4 class="font-extrabold text-xs text-gray-900 dark:text-white uppercase tracking-wider">Recently Viewed Listings</h4>
                        <form method="POST" action="{{ route('jobs.history.clear-viewed') }}">
                            @csrf
                            <button type="submit" class="text-[10px] font-bold text-red-500 hover:underline cursor-pointer">Clear Viewed</button>
                        </form>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        @foreach($recentlyViewed as $viewedJob)
                            <div class="text-xs bg-gray-50 dark:bg-dark-850 p-2.5 rounded-xl border border-gray-100 dark:border-gray-750 flex-1 min-w-[200px]">
                                <a href="{{ route('jobs.show', $viewedJob->slug) }}" class="font-extrabold text-gray-950 dark:text-white hover:text-primary-500 transition">{{ $viewedJob->title }}</a>
                                <p class="text-4xs text-gray-400 mt-1 uppercase font-bold">{{ $viewedJob->company->company_name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Job listings cards list -->
            <div class="space-y-4">
                @forelse($jobs as $job)
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/40 hover:border-primary-500/25 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
                        @if($job->featured)
                            <span class="absolute top-0 right-0 bg-accent-500 text-white text-[9px] font-black px-3.5 py-1 rounded-bl-xl rounded-tr-3xl uppercase tracking-widest">Featured</span>
                        @endif

                        <div class="flex items-start gap-4">
                            <!-- Company Logo -->
                            <div class="w-16 h-16 rounded-2xl border border-gray-150 dark:border-gray-750 bg-gray-50 dark:bg-gray-900 flex items-center justify-center p-2 flex-shrink-0">
                                @if($job->company->logo)
                                    <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain" />
                                @else
                                    <span class="text-xs text-gray-450 font-bold">JOBZ</span>
                                @endif
                            </div>
                            
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-extrabold text-base text-gray-900 dark:text-white hover:text-primary-500 transition">
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    @if($job->urgent)
                                        <span class="px-2 py-0.5 bg-red-55/10 text-red-500 text-[9px] font-black rounded-full uppercase tracking-wider">Urgent</span>
                                    @endif
                                    @if($job->screeningQuestions->count() === 0)
                                        <span class="px-2 py-0.5 bg-emerald-55/10 text-emerald-500 text-[9px] font-black rounded-full uppercase tracking-wider">⚡ Easy Apply</span>
                                    @endif
                                </div>
                                <p class="text-xs font-extrabold text-gray-750 dark:text-gray-300 flex items-center gap-1.5">
                                    {{ $job->company->company_name }}
                                    @if($job->company->verification_status === 'verified')
                                        <span class="text-primary-500 text-xs font-bold" title="Verified Employer">&check;</span>
                                    @endif
                                </p>
                                <div class="flex items-center gap-3 text-[11px] text-gray-450 dark:text-gray-400 flex-wrap font-semibold">
                                    <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                                    <span>&bull;</span>
                                    <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                                    <span>&bull;</span>
                                    <span>⏰ {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                                </div>
                                
                                <!-- Display Salary if Visible -->
                                @if($job->salary_min || $job->salary_max)
                                    <p class="text-xs font-extrabold text-emerald-600 dark:text-emerald-450 mt-1">
                                        💵 {{ $job->currency }} 
                                        @if($job->salary_min && $job->salary_max)
                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                        @elseif($job->salary_min)
                                            {{ number_format($job->salary_min) }}
                                        @endif
                                        / {{ ucfirst($job->salary_type ?? 'yearly') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto justify-end shrink-0">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold text-center rounded-xl text-xs uppercase tracking-wider transition shadow-sm w-full md:w-auto">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Empty state illustration -->
                    <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <div class="w-12 h-12 bg-gray-50 dark:bg-dark-850 text-gray-300 flex items-center justify-center text-3xl mx-auto rounded-2xl">
                            ⚠️
                        </div>
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white">No Job Listings Found</h4>
                        <p class="text-xs text-gray-500 mt-2 max-w-sm mx-auto">Try clearing search inputs, broadening keyword terms, or selecting different locations.</p>
                        <div class="pt-2 flex justify-center">
                            <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-primary-50 hover:bg-primary-100 dark:bg-dark-850 text-primary-500 font-extrabold text-xs rounded-xl transition border border-primary-250/20">
                                Reset Search & Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
