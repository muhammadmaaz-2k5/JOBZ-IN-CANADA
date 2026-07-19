<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center text-xs font-semibold text-gray-500 gap-1 mb-2 no-print">
            <a href="/" class="hover:text-primary-500">Home</a>
            <span>/</span>
            <a href="#" class="hover:text-primary-500">Companies</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-gray-300 font-bold" x-text="'{{ addslashes($company->company_name) }}'"></span>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ currentTab: 'about' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Company Cover & Logo Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm border border-gray-150 dark:border-gray-700/50">
                <!-- Cover Image -->
                <div class="h-48 md:h-64 bg-gradient-to-r from-primary-600 to-indigo-700 relative">
                    @if($company->cover_image)
                        <img src="{{ $company->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>

                <!-- Profile Header Details -->
                <div class="px-6 md:px-8 pb-8 pt-4 relative flex flex-col md:flex-row items-center md:items-end justify-between gap-6">
                    <!-- Logo & Basic Info -->
                    <div class="flex flex-col md:flex-row items-center md:items-end gap-6 -mt-16 md:-mt-24 relative z-10 w-full md:w-auto text-center md:text-left">
                        <!-- Logo -->
                        <div class="w-28 h-28 md:w-32 md:h-32 rounded-2xl border-4 border-white dark:border-gray-800 bg-white shadow-md overflow-hidden flex items-center justify-center p-2">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-3xl font-black text-primary-500 uppercase">{{ substr($company->company_name, 0, 2) }}</span>
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                                    {{ $company->company_name }}
                                </h1>
                                @if($company->verification_status === 'verified')
                                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-500 text-white rounded-full text-3xs font-extrabold shadow-sm" title="Verified Employer">✓</span>
                                @endif
                            </div>

                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-semibold flex items-center justify-center md:justify-start gap-1">
                                📍 {{ $company->headquarters ?: 'Canada' }} &bull; 🏷️ {{ $company->industry ?: 'Industry' }}
                            </p>

                            <!-- Rating summary -->
                            <div class="flex items-center justify-center md:justify-start gap-2 pt-1">
                                <div class="flex text-amber-500 font-bold text-sm">
                                    @php $avg = $company->reviews()->avg('rating') ?: 0; @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-bold">({{ number_format($avg, 1) }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action items -->
                    <div class="flex items-center gap-3 relative z-10 shrink-0 w-full md:w-auto justify-center">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener" class="px-5 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 font-semibold text-xs transition shadow-sm text-gray-700 dark:text-gray-300">
                                Visit Website ↗
                            </a>
                        @endif
                        
                        <button type="button" class="px-5 py-2.5 rounded-xl bg-primary-500 text-white hover:bg-primary-600 font-semibold text-xs transition shadow-premium">
                            Follow Company
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-t border-gray-100 dark:border-gray-700 flex px-6 md:px-8 gap-6 text-sm font-bold text-gray-500 dark:text-gray-400">
                    <button @click="currentTab = 'about'" :class="currentTab === 'about' ? 'text-primary-500 border-b-2 border-primary-500 py-4' : 'hover:text-gray-800 dark:hover:text-white py-4'" class="transition cursor-pointer">About</button>
                    <button @click="currentTab = 'jobs'" :class="currentTab === 'jobs' ? 'text-primary-500 border-b-2 border-primary-500 py-4' : 'hover:text-gray-800 dark:hover:text-white py-4'" class="transition cursor-pointer">Current Jobs ({{ $jobs->count() }})</button>
                    <button @click="currentTab = 'reviews'" :class="currentTab === 'reviews' ? 'text-primary-500 border-b-2 border-primary-500 py-4' : 'hover:text-gray-800 dark:hover:text-white py-4'" class="transition cursor-pointer">Reviews ({{ $reviews->count() }})</button>
                    <button @click="currentTab = 'gallery'" :class="currentTab === 'gallery' ? 'text-primary-500 border-b-2 border-primary-500 py-4' : 'hover:text-gray-800 dark:hover:text-white py-4'" class="transition cursor-pointer">Gallery & Culture</button>
                </div>
            </div>

            <!-- Tab Panels Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Main Content Pane -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Tab: About -->
                    <div x-show="currentTab === 'about'" class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition>
                        <div class="space-y-3">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Company Overview</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $company->description ?: 'No description provided for this company yet.' }}
                            </p>
                        </div>
                        
                        <!-- Core Details Grid -->
                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-gray-400">Industry</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $company->industry ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-gray-400">Company Size</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $company->company_size ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-gray-400">Founded</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $company->founded_year ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-gray-400">Headquarters</span>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $company->headquarters ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Open Jobs -->
                    <div x-show="currentTab === 'jobs'" class="space-y-4" x-transition>
                        @forelse($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 flex justify-between items-start gap-4 flex-wrap hover:border-primary-500/25 transition">
                                <div class="space-y-2">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white hover:text-primary-500 transition">
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span>📍 {{ $job->location }}</span>
                                        <span>&bull;</span>
                                        <span>💼 {{ $job->employment_type }}</span>
                                        <span>&bull;</span>
                                        <span>💰 {{ $job->salary_min ? '$' . number_format($job->salary_min) . ' CAD' : 'Salary Undisclosed' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="px-4 py-2 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-bold text-xs transition shadow-premium">
                                    View details
                                </a>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-gray-150 dark:border-gray-700/50 text-center text-gray-400 italic">
                                No active job opportunities published at the moment. Check back soon!
                            </div>
                        @endforelse
                    </div>

                    <!-- Tab: Reviews -->
                    <div x-show="currentTab === 'reviews'" class="space-y-6" x-transition>
                        
                        <!-- Summary and Rating Grid -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                            <div class="text-center sm:border-r border-gray-100 dark:border-gray-700 py-2">
                                <h4 class="text-[10px] uppercase font-bold text-gray-400">Average Rating</h4>
                                <p class="text-4xl font-black text-primary-500 mt-2">{{ number_format($avg, 1) }}</p>
                                <div class="flex justify-center text-amber-500 font-bold text-sm mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-4xs text-gray-450 mt-1">Based on {{ $reviews->count() }} ratings</p>
                            </div>
                            <div class="sm:col-span-2 space-y-2">
                                <h4 class="text-xs font-bold text-gray-850 dark:text-gray-250">Candidate Opinion</h4>
                                <p class="text-xs text-gray-500">Company culture, hiring processes, management, and work-life balance feedback.</p>
                                
                                <!-- Fake progress bars to show rating distribution -->
                                <div class="space-y-1 text-xs">
                                    <div class="flex items-center justify-between gap-3 text-gray-450">
                                        <span>5 ★</span>
                                        <div class="flex-1 h-2 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-emerald-500 w-3/4 rounded"></div>
                                        </div>
                                        <span>75%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-450">
                                        <span>4 ★</span>
                                        <div class="flex-1 h-2 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-primary-500 w-1/5 rounded"></div>
                                        </div>
                                        <span>20%</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-gray-450">
                                        <span>3 ★</span>
                                        <div class="flex-1 h-2 bg-gray-100 dark:bg-dark-700 rounded overflow-hidden">
                                            <div class="h-full bg-amber-500 w-[5%] rounded"></div>
                                        </div>
                                        <span>5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Write a Review Form (Collapsible/Hidden by default, triggered by action) -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-4" x-data="{ openForm: false }">
                            <div class="flex justify-between items-center">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Have you worked here?</h4>
                                <button @click="openForm = !openForm" class="px-3.5 py-1.5 rounded-lg border border-gray-200 dark:border-gray-750 text-xs font-semibold hover:bg-gray-50 transition cursor-pointer text-gray-700 dark:text-gray-300">
                                    Write a Review
                                </button>
                            </div>
                            
                            <form x-show="openForm" class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-700" style="display: none;">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Rating Stars</label>
                                    <select class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white dark:bg-dark-800 text-sm">
                                        <option value="5">★★★★★ (5 - Excellent)</option>
                                        <option value="4">★★★★☆ (4 - Very Good)</option>
                                        <option value="3">★★★☆☆ (3 - Average)</option>
                                        <option value="2">★★☆☆☆ (2 - Poor)</option>
                                        <option value="1">★☆☆☆☆ (1 - Very Poor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Review Summary / Title</label>
                                    <input type="text" placeholder="e.g. Great work-life balance and supportive team" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white dark:bg-dark-800 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Detailed Feedback</label>
                                    <textarea rows="3.5" placeholder="Share details about the interview process, company culture, benefits, or general work experience..." class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white dark:bg-dark-800 text-sm"></textarea>
                                </div>
                                <button type="button" @click="openForm = false" class="px-4 py-2 bg-primary-500 text-white rounded-xl text-xs font-semibold hover:bg-primary-600 transition shadow-premium">
                                    Submit Review
                                </button>
                            </form>
                        </div>

                        <!-- Review Cards list -->
                        <div class="space-y-4">
                            @forelse($reviews as $rev)
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex text-amber-500 font-bold text-xs">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                            <h5 class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $rev->title }}</h5>
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-semibold">{{ $rev->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-650 dark:text-gray-300 leading-relaxed">{{ $rev->comment }}</p>
                                    <p class="text-[10px] font-bold text-gray-450 uppercase">By: {{ $rev->user->first_name ?? 'Anonymous Candidate' }}</p>
                                </div>
                            @empty
                                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-150 dark:border-gray-700/50 text-center text-gray-400 italic">
                                    No reviews posted yet. Be the first to share your experience!
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab: Gallery & Culture -->
                    <div x-show="currentTab === 'gallery'" class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition>
                        <div class="space-y-3">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Our Core Values</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-bold text-xs text-primary-500 uppercase">Innovation</h4>
                                    <p class="text-3xs text-gray-500 mt-1 leading-relaxed">Constantly seeking newer solutions to help candidates scale in their domains.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-bold text-xs text-primary-500 uppercase">Inclusion</h4>
                                    <p class="text-3xs text-gray-500 mt-1 leading-relaxed">Embracing diverse candidates and backgrounds to enrich the local marketplace.</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                                    <h4 class="font-bold text-xs text-primary-500 uppercase">Reliability</h4>
                                    <p class="text-3xs text-gray-500 mt-1 leading-relaxed">Ensuring verified jobs, safe billing transactions, and responsive layouts.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery section -->
                        <div class="space-y-3">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Office & Team Gallery</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div class="h-28 bg-gray-100 dark:bg-dark-850 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden flex items-center justify-center text-xs text-gray-400 font-bold uppercase relative group">
                                    Office Space
                                    <div class="absolute inset-0 bg-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <div class="h-28 bg-gray-100 dark:bg-dark-850 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden flex items-center justify-center text-xs text-gray-400 font-bold uppercase relative group">
                                    Team Meeting
                                    <div class="absolute inset-0 bg-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <div class="h-28 bg-gray-100 dark:bg-dark-850 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden flex items-center justify-center text-xs text-gray-400 font-bold uppercase relative group">
                                    Collaboration Hub
                                    <div class="absolute inset-0 bg-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar Details Pane -->
                <div class="space-y-6">
                    
                    <!-- Quick Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Quick Stats</h3>
                        <div class="space-y-3 text-xs">
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
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-3">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Office Location</h3>
                        <div class="h-32 bg-gray-100 dark:bg-dark-850 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center text-xs text-gray-400 font-bold uppercase relative overflow-hidden">
                            <!-- Simulated Map details -->
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary-500/5 to-transparent pointer-events-none"></div>
                            <span>📍 {{ $company->headquarters ?: 'Toronto, ON' }}</span>
                        </div>
                        <p class="text-[10px] text-gray-400 font-semibold leading-normal text-center">Interactive sitemap locator simulated.</p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
