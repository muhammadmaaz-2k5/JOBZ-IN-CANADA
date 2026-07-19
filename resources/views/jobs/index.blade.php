<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Find Your Dream Job in Canada') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Global Search Bar with Autocomplete suggestions -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50"
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
                <form method="GET" action="{{ route('jobs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 relative">
                    <div class="relative">
                        <x-input-label for="keyword" :value="__('Keyword Search')" />
                        <input id="keyword" name="keyword" type="text" 
                               x-model="keyword"
                               @input.debounce.300ms="fetchSuggestions()"
                               @focus="showSuggestions = true"
                               @click.away="setTimeout(() => showSuggestions = false, 200)"
                               class="mt-1 block w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl shadow-sm" 
                               placeholder="e.g. Laravel, React, Senior" />

                        <!-- Suggestions Dropdown List -->
                        <div x-show="showSuggestions && suggestions.length > 0" 
                             class="absolute left-0 right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-150 dark:border-gray-700 rounded-xl shadow-2xl z-50 overflow-hidden divide-y divide-gray-50 dark:divide-gray-750 max-h-60 overflow-y-auto">
                            <template x-for="item in suggestions">
                                <button type="button" 
                                        @click="keyword = item.text; showSuggestions = false; $el.closest('form').submit()"
                                        class="w-full text-left px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-950/40 flex justify-between items-center transition">
                                    <span x-text="item.text"></span>
                                    <span class="text-3xs uppercase font-extrabold text-gray-400 bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded" x-text="item.type.replace('_', ' ')"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. Toronto, Vancouver, Remote" :value="request('location')" />
                    </div>

                    <div class="flex items-end gap-3">
                        <div class="w-full">
                            <x-input-label for="sort" :value="__('Sort By')" />
                            <select id="sort" name="sort" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl shadow-sm">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                                <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                                <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                                <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                                <option value="most_viewed" @selected(request('sort') == 'most_viewed')>Most Viewed</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-sm transition shadow-md">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Searches History chips -->
            @if(session()->has('recent_searches') && count(session('recent_searches')) > 0)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50 flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-3xs font-extrabold uppercase text-gray-400">Recent Searches:</span>
                        @foreach(session('recent_searches') as $search)
                            <a href="{{ $search['url'] }}" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-950 text-xs font-bold text-gray-650 dark:text-gray-300 rounded-lg transition border border-gray-200 dark:border-gray-800">
                                "{{ $search['keyword'] }}" {{ $search['location'] ? 'in ' . $search['location'] : '' }}
                            </a>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('jobs.history.clear-search') }}">
                        @csrf
                        <button type="submit" class="text-3xs font-bold text-red-500 hover:underline">Clear History</button>
                    </form>
                </div>
            @endif

            <!-- Content Grid: Filters Sidebar + Job Listings -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Sidebar Filters (Left) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-6">
                        <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                            Filters
                            <a href="{{ route('jobs.index') }}" class="text-xs text-indigo-650 dark:text-indigo-400 hover:underline">Clear All</a>
                        </h3>

                        <form method="GET" action="{{ route('jobs.index') }}" class="space-y-6">
                            <!-- Keep search criteria -->
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}" />
                            <input type="hidden" name="location" value="{{ request('location') }}" />
                            <input type="hidden" name="sort" value="{{ request('sort') }}" />

                            <!-- Workplace Type -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Workplace Type</h4>
                                <div class="space-y-1">
                                    @foreach(['remote' => 'Remote', 'hybrid' => 'Hybrid', 'on-site' => 'On-site'] as $key => $label)
                                        <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                            <input type="checkbox" name="workplace_type[]" value="{{ $key }}" @checked(in_array($key, (array)request('workplace_type')))>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Employment Type -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Employment Type</h4>
                                <div class="space-y-1">
                                    @foreach(['full-time' => 'Full-time', 'part-time' => 'Part-time', 'contract' => 'Contract', 'internship' => 'Internship'] as $key => $label)
                                        <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                            <input type="checkbox" name="employment_type[]" value="{{ $key }}" @checked(in_array($key, (array)request('employment_type')))>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Experience Level -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Experience Level</h4>
                                <div class="space-y-1">
                                    @foreach(['entry' => 'Entry Level', 'junior' => 'Junior', 'mid' => 'Mid-Level', 'senior' => 'Senior'] as $key => $label)
                                        <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                            <input type="checkbox" name="experience_level[]" value="{{ $key }}" @checked(in_array($key, (array)request('experience_level')))>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Salary Bounds -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Salary Range (CAD)</h4>
                                <div class="flex gap-2">
                                    <input type="number" name="salary_min" placeholder="Min" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" value="{{ request('salary_min') }}" />
                                    <input type="number" name="salary_max" placeholder="Max" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" value="{{ request('salary_max') }}" />
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Category</h4>
                                <select name="category" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303">
                                    <option value="">All Categories</option>
                                    @foreach($parentCategories as $parent)
                                        <optgroup label="{{ $parent->name }}">
                                            <option value="{{ $parent->id }}" @selected(request('category') == $parent->id)>{{ $parent->name }} (All)</option>
                                            @foreach($parent->children as $child)
                                                <option value="{{ $child->id }}" @selected(request('category') == $child->id)>{{ $child->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Posted Date filter -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Date Posted</h4>
                                <select name="posted_date" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303">
                                    <option value="">Anytime</option>
                                    <option value="24h" @selected(request('posted_date') == '24h')>Last 24 Hours</option>
                                    <option value="3d" @selected(request('posted_date') == '3d')>Last 3 Days</option>
                                    <option value="week" @selected(request('posted_date') == 'week')>Last Week</option>
                                    <option value="month" @selected(request('posted_date') == 'month')>Last Month</option>
                                </select>
                            </div>

                            <!-- Verification & Easy Apply flags -->
                            <div class="space-y-2 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                                <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                                    <input type="checkbox" name="verified_companies" value="1" @checked(request('verified_companies')) class="rounded border-gray-300">
                                    Verified Companies Only
                                </label>
                                <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                                    <input type="checkbox" name="urgent" value="1" @checked(request('urgent')) class="rounded border-gray-300">
                                    Urgent Hiring Only
                                </label>
                                <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                                    <input type="checkbox" name="easy_apply" value="1" @checked(request('easy_apply')) class="rounded border-gray-300">
                                    ⚡ Easy Apply Only
                                </label>
                                <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                                    <input type="checkbox" name="salary_visible" value="1" @checked(request('salary_visible')) class="rounded border-gray-300">
                                    💵 Salary Visible Only
                                </label>
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                                Apply Filters
                            </button>
                        </form>
                    </div>

                    <!-- Recently Viewed Jobs sidebar widget -->
                    @if(count($recentlyViewed) > 0)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-750">
                                <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Recently Viewed</h4>
                                <form method="POST" action="{{ route('jobs.history.clear-viewed') }}">
                                    @csrf
                                    <button type="submit" class="text-4xs text-red-500 hover:underline">Clear</button>
                                </form>
                            </div>
                            <div class="space-y-3">
                                @foreach($recentlyViewed as $viewedJob)
                                    <div class="text-xs">
                                        <a href="{{ route('jobs.show', $viewedJob->slug) }}" class="font-bold text-gray-900 dark:text-white hover:text-indigo-650 transition">{{ $viewedJob->title }}</a>
                                        <p class="text-3xs text-gray-500 mt-0.5">{{ $viewedJob->company->company_name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Job listings cards list (Right) -->
                <div class="lg:col-span-3 space-y-4" x-data="{ loading: false }">
                    
                    <!-- Skeletons Overlay placeholder during loading state -->
                    <div x-show="loading" class="space-y-4">
                        <template x-for="i in [1,2,3]">
                            <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-750 animate-pulse flex flex-col gap-4">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/2"></div>
                            </div>
                        </template>
                    </div>

                    <div x-show="!loading" class="space-y-4">
                        @forelse($jobs as $job)
                            <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/40 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
                                @if($job->featured)
                                    <span class="absolute top-0 right-0 bg-yellow-500 text-white text-3xs font-extrabold px-3 py-1 rounded-bl-xl rounded-tr-2xl uppercase">Featured</span>
                                @endif

                                <div class="flex items-start gap-4">
                                    <!-- Company Logo -->
                                    <div class="w-16 h-16 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex items-center justify-center p-2 flex-shrink-0">
                                        @if($job->company->logo)
                                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain" />
                                        @else
                                            <span class="text-xs text-gray-400 font-bold">JOBZ</span>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-extrabold text-lg text-gray-900 dark:text-white hover:text-indigo-650 transition">
                                                <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                            </h4>
                                            @if($job->urgent)
                                                <span class="px-2 py-0.5 bg-red-100 dark:bg-red-950 text-red-650 dark:text-red-405 text-3xs font-bold rounded-full">Urgent</span>
                                            @endif
                                            @if($job->screeningQuestions->count() === 0)
                                                <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-3xs font-bold rounded-full">⚡ Easy Apply</span>
                                            @endif
                                        </div>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                            {{ $job->company->company_name }}
                                            @if($job->company->verification_status === 'verified')
                                                <span class="text-indigo-500 text-xs font-bold" title="Verified Employer">&check;</span>
                                            @endif
                                        </p>
                                        <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
                                            <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                                            <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                                            <span>⏰ {{ ucfirst($job->employment_type) }}</span>
                                        </div>
                                        
                                        <!-- Display Salary if Visible -->
                                        @if($job->salary_min || $job->salary_max)
                                            <p class="text-sm font-extrabold text-emerald-600 dark:text-emerald-450 mt-1">
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

                                <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto justify-end">
                                    <a href="{{ route('jobs.show', $job->slug) }}" class="px-5 py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold text-center rounded-xl text-xs transition shadow-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <!-- Helpful empty states layout -->
                            <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h4 class="font-extrabold text-lg text-gray-900 dark:text-white">No Job Listings Found</h4>
                                <p class="text-xs text-gray-500 mt-2">Try clearing your filters, broadening your keyword query, or selecting different locations.</p>
                                <div class="pt-4 flex justify-center">
                                    <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-950 text-indigo-650 dark:text-indigo-400 font-bold text-xs rounded-xl hover:bg-indigo-100 transition border border-indigo-200">
                                        Reset Search & Filters
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- SEO friendly Pagination -->
                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
