<x-app-layout>
    <x-slot name="header">
        {{ __('Job Seeker Dashboard') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        @if(session('success'))
            <x-alert type="success" class="mb-8">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header Banner -->
        <x-card variant="gradient" color="blue" padding="lg">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="text-white">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-sm font-semibold tracking-wide backdrop-blur-md mb-3 shadow-sm border border-white/10">
                        Candidate Dashboard
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 drop-shadow-sm">Welcome back, {{ Auth::user()->first_name }}!</h1>
                    <p class="text-blue-50 max-w-xl text-lg font-medium leading-relaxed">
                        Find and apply for top jobs across Canada. Track your progress, manage alerts, and update your professional profile to stand out to employers.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 shrink-0 w-full md:w-auto">
                    <a href="{{ route('jobs.index') }}" class="group relative inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-blue-600 bg-white rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full sm:w-auto overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-white via-blue-50 to-white opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <svg class="w-5 h-5 relative z-10 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="relative z-10">Search Jobs</span>
                    </a>
                    <a href="{{ route('seeker.profile.edit') }}" class="group inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-white bg-blue-700/50 hover:bg-blue-600/80 backdrop-blur-md rounded-xl border border-white/20 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 w-full sm:w-auto">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Stats Grid using design system stat cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <x-card variant="stat" label="Applied" value="{{ $metrics['applied'] }}" color="blue" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Saved" value="{{ $metrics['saved'] }}" color="rose" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Interviews" value="{{ $metrics['interviews'] }}" color="amber" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Profile Strength" value="{{ $metrics['profile_completion'] }}%" color="green" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Following" value="{{ $metrics['follows'] }}" color="purple" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Alerts" value="{{ $metrics['alerts'] }}" color="indigo" padding="sm">
                <x-slot name="icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </x-slot>
            </x-card>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column (lg:col-span-2) -->
            <div class="xl:col-span-2 space-y-8">

                <!-- Profile Completion Suggestions -->
                @if(count($suggestions) > 0)
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700/30 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-amber-800 dark:text-amber-400 font-bold text-lg mb-4 flex items-center gap-2">
                            <span class="text-2xl animate-bounce">💡</span>
                            Tips to improve profile strength & get noticed:
                        </h3>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($suggestions as $sug)
                                <li class="flex items-start gap-2 text-amber-700 dark:text-amber-300/80 font-medium bg-white/50 dark:bg-black/20 p-3 rounded-lg">
                                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>{{ $sug }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Recommended Jobs -->
                <x-card variant="default">
                    <x-slot name="header">Recommended Jobs For You</x-slot>
                    <div class="space-y-4">
                        @forelse($recommendedJobs as $recJob)
                            @if(is_object($recJob) && isset($recJob->slug))
                                <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-xl border border-gray-100 dark:border-slate-700/50 bg-gray-50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all duration-300 gap-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            <a href="{{ route('jobs.show', $recJob->slug) }}">{{ $recJob->title }}</a>
                                        </h4>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium mt-1 flex items-center gap-2 flex-wrap">
                                            @if($recJob->company)
                                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg> {{ $recJob->company->company_name }}</span> 
                                                <span class="text-gray-300 dark:text-slate-600">&bull;</span>
                                            @endif
                                            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg> {{ $recJob->city }}, {{ $recJob->country }}</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('jobs.show', $recJob->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#1650e1]/10 text-[#1650e1] dark:bg-blue-500/10 dark:text-blue-400 font-bold rounded-lg hover:bg-[#1650e1] hover:text-white transition-colors">
                                        Apply Now <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </a>
                                </div>
                            @elseif(is_string($recJob))
                                <div class="p-5 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 font-medium">
                                    <p>{{ $recJob }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Recommended Jobs" subtitle="Update your profile skills to view recommendations matching your background." icon="🎯" />
                        @endforelse
                    </div>
                </x-card>

                <!-- Recent Applications -->
                <x-card variant="default">
                    <x-slot name="header">
                        <div class="flex items-center justify-between w-full">
                            <span>Recent Applications</span>
                            <a href="{{ route('seeker.applications.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">View All &rarr;</a>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-4">
                        @forelse($recentApplications as $app)
                            @if(is_object($app) && isset($app->id) && $app->job)
                                <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-xl border border-gray-100 dark:border-slate-700/50 bg-white dark:bg-slate-800 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all duration-300 gap-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                        </h4>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">
                                            @if($app->job->company)
                                                <span>{{ $app->job->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Applied {{ $app->applied_at ? $app->applied_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4 shrink-0">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full 
                                            @if($app->status === 'hired') bg-green-100 text-green-700
                                            @elseif($app->status === 'interview_scheduled') bg-blue-100 text-blue-700
                                            @elseif($app->status === 'rejected') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700 @endif
                                            uppercase tracking-wide">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('seeker.applications.show', $app->id) }}" class="text-gray-400 hover:text-[#1650e1]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                        </a>
                                    </div>
                                </div>
                            @elseif(is_string($app))
                                <div class="p-5 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 font-medium">
                                    <p>{{ $app }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Applications Yet" subtitle="You haven't submitted any job applications yet. Start applying to open roles!" icon="💼" />
                        @endforelse
                    </div>
                </x-card>

                <!-- Bookmarked Saved Jobs -->
                <x-card variant="default">
                    <x-slot name="header">Saved Jobs</x-slot>
                    
                    <div class="space-y-4">
                        @forelse($savedJobs as $sv)
                            @if(is_object($sv) && isset($sv->slug))
                                <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-xl border border-gray-100 dark:border-slate-700/50 bg-white dark:bg-slate-800 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md transition-all duration-300 gap-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            <a href="{{ route('jobs.show', $sv->slug) }}">{{ $sv->title }}</a>
                                        </h4>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">
                                            @if($sv->company)
                                                <span>{{ $sv->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Saved {{ $sv->pivot && $sv->pivot->created_at ? $sv->pivot->created_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        <form method="POST" action="{{ route('jobs.save', $sv->id) }}">
                                            @csrf
                                            <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Remove">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('jobs.show', $sv->slug) }}" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-lg transition-colors shadow-sm">
                                            Apply
                                        </a>
                                    </div>
                                </div>
                            @elseif(is_string($sv))
                                <div class="p-5 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 font-medium">
                                    <p>{{ $sv }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Saved Jobs" subtitle="Bookmark listings you are interested in to apply later." icon="⭐" />
                        @endforelse
                    </div>
                </x-card>

                <!-- Timeline Activity Log -->
                <x-card variant="default">
                    <x-slot name="header">Recent Activity Timeline</x-slot>
                    
                    <div class="pl-4">
                        @forelse($timeline as $timeItem)
                            @if(is_object($timeItem) && isset($timeItem->created_at))
                                <div class="relative pl-6 pb-6 border-l-2 border-blue-100 dark:border-slate-700 last:border-transparent last:pb-0">
                                    <div class="absolute -left-[9px] top-1 w-4 h-4 bg-white dark:bg-slate-800 border-4 border-blue-500 rounded-full"></div>
                                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">{{ $timeItem->created_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-sm font-bold text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $timeItem->action) }}</h5>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">"{{ $timeItem->description }}"</p>
                                </div>
                            @elseif(is_string($timeItem))
                                <div class="relative pl-6 pb-6 border-l-2 border-blue-100 dark:border-slate-700 last:border-transparent last:pb-0">
                                    <div class="absolute -left-[9px] top-1 w-4 h-4 bg-white dark:bg-slate-800 border-4 border-blue-500 rounded-full"></div>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $timeItem }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Activity" subtitle="No timeline events logged yet." icon="⏳" />
                        @endforelse
                    </div>
                </x-card>

            </div>

            <!-- Right Column (Sidebar) -->
            <div class="space-y-8">

                <!-- Job Alerts Manager -->
                <x-card variant="default">
                    <x-slot name="header">My Job Alerts</x-slot>
                    
                    <div class="space-y-4 mb-6">
                        @forelse($alerts as $al)
                            @if(is_object($al) && isset($al->keyword))
                                <div class="flex items-center justify-between p-4 rounded-xl border border-blue-100 dark:border-blue-900/50 bg-blue-50 dark:bg-blue-900/10 hover:border-blue-300 transition-colors">
                                    <div>
                                        <p class="font-bold text-blue-900 dark:text-blue-100">"{{ $al->keyword }}"</p>
                                        <p class="text-sm text-blue-600/80 dark:text-blue-300/80 mt-1">{{ $al->location ?? 'Anywhere' }} &bull; {{ ucfirst($al->frequency) }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('seeker.alerts.destroy', $al->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:bg-white rounded-lg transition-colors shadow-sm" title="Delete Alert">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            @elseif(is_string($al))
                                <div class="flex items-center justify-between p-4 rounded-xl border border-blue-100 bg-blue-50">
                                    <div>
                                        <p class="font-bold text-blue-900">"{{ $al }}"</p>
                                        <p class="text-sm text-blue-600/80 mt-1">Anywhere &bull; Daily</p>
                                    </div>
                                    <div>
                                        <button type="button" disabled class="p-2 text-gray-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">No job alerts set up.</p>
                        @endforelse
                    </div>

                    <!-- Create alert inline form -->
                    <form method="POST" action="{{ route('seeker.alerts.store') }}" class="border-t border-gray-100 dark:border-slate-700/50 pt-6">
                        @csrf
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4">Create New Alert</h4>
                        
                        <div class="space-y-3">
                            <input type="text" name="keyword" required placeholder="Keyword (e.g. Laravel)" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 focus:ring-[#1650e1] focus:border-[#1650e1]" />
                            <input type="text" name="location" placeholder="City or province (Optional)" class="w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 focus:ring-[#1650e1] focus:border-[#1650e1]" />
                            
                            <div class="grid grid-cols-2 gap-3 items-center">
                                <select name="frequency" class="rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 focus:ring-[#1650e1] focus:border-[#1650e1]">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <input type="checkbox" name="remote" value="1" class="rounded text-[#1650e1] focus:ring-[#1650e1]" />
                                    <span>Remote Only</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full mt-2 bg-gray-900 hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                Create Alert
                            </button>
                        </div>
                    </form>
                </x-card>

                <!-- Recent Notifications -->
                <x-card variant="default">
                    <x-slot name="header">Notifications</x-slot>
                    
                    <div class="space-y-4">
                        @forelse($notifications as $notif)
                            @if(is_object($notif) && isset($notif->title))
                                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 dark:border-slate-700/50 bg-gray-50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 hover:shadow-sm transition-all">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $notif->title }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">{{ $notif->body }}</p>
                                        <span class="text-xs text-blue-600 font-semibold mt-1.5 block">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @elseif(is_string($notif))
                                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900">Notification</h5>
                                        <p class="text-sm text-gray-500 mt-0.5 line-clamp-2">{{ $notif }}</p>
                                        <span class="text-xs text-blue-600 font-semibold mt-1.5 block">Just now</span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">No in-app alerts received.</p>
                        @endforelse
                    </div>
                </x-card>

            </div>
        </div>

    </div>
</x-app-layout>
