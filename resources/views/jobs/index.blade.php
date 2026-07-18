<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Find Your Dream Job in Canada') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Global Search Bar -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('jobs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="keyword" :value="__('Keyword Search')" />
                        <x-text-input id="keyword" name="keyword" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. Laravel, React, Senior" :value="request('keyword')" />
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
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Content Grid: Filters Sidebar + Job Listings -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Sidebar Filters (Left) -->
                <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-6 h-fit">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        Filters
                        <a href="{{ route('jobs.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Clear All</a>
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

                        <!-- Popular categories -->
                        <div class="space-y-2">
                            <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Category</h4>
                            <select name="category" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300">
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
                            <select name="posted_date" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300">
                                <option value="">Anytime</option>
                                <option value="24h" @selected(request('posted_date') == '24h')>Last 24 Hours</option>
                                <option value="3d" @selected(request('posted_date') == '3d')>Last 3 Days</option>
                                <option value="week" @selected(request('posted_date') == 'week')>Last Week</option>
                                <option value="month" @selected(request('posted_date') == 'month')>Last Month</option>
                            </select>
                        </div>

                        <!-- Verification flags -->
                        <div class="space-y-2 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="verified_companies" value="1" @checked(request('verified_companies'))>
                                Verified Companies Only
                            </label>
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="urgent" value="1" @checked(request('urgent'))>
                                Urgent Hiring Only
                            </label>
                        </div>

                        <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Apply Filters
                        </button>
                    </form>
                </div>

                <!-- Job listings cards list (Right) -->
                <div class="lg:col-span-3 space-y-4">
                    @forelse($jobs as $job)
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/40 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
                            @if($job->featured)
                                <span class="absolute top-0 right-0 bg-yellow-500 text-white text-3xs font-extrabold px-3 py-1 rounded-bl-xl rounded-tr-2xl uppercase">Featured</span>
                            @endif

                            <div class="flex items-start gap-4">
                                <!-- Company Logo -->
                                <div class="w-16 h-16 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 flex items-center justify-center p-2 flex-shrink-0">
                                    @if($job->company->logo)
                                        <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain" />
                                    @else
                                        <span class="text-xs text-gray-400 font-bold">JOBZ</span>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 hover:text-indigo-600 transition">
                                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                        </h4>
                                        @if($job->urgent)
                                            <span class="px-2 py-0.5 bg-red-100 dark:bg-red-950 text-red-650 dark:text-red-400 text-3xs font-bold rounded-full">Urgent</span>
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
                                    @if($job->salary_visibility !== 'hidden')
                                        <p class="text-sm font-extrabold text-emerald-600 dark:text-emerald-450 mt-1">
                                            💵 {{ $job->currency }} 
                                            @if($job->salary_visibility === 'range' && $job->min_salary && $job->max_salary)
                                                {{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }}
                                            @elseif($job->min_salary)
                                                {{ number_format($job->min_salary) }}
                                            @endif
                                            / {{ ucfirst($job->salary_period) }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto justify-end">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center rounded-xl text-sm transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">No Job Postings Found</h4>
                            <p class="text-sm text-gray-500 mt-1">Try refining your keyword search, filters, or location parameters.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
