<x-app-layout>
    <x-slot name="header">
        {{ __('Job Seeker Dashboard') }}
    </x-slot>

    <div class="space-y-8 animate-fade-in">
        
        @if(session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header Banner -->
        <x-card variant="gradient" color="blue" padding="lg" class="relative overflow-hidden shadow-xl border-0">
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                        Candidate Dashboard
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white">Welcome back, {{ Auth::user()->first_name }}!</h1>
                    <p class="text-blue-150 max-w-xl text-sm leading-relaxed">
                        Find and apply for top jobs across Canada. Track your progress, manage alerts, and update your professional profile to stand out to employers.
                    </p>
                </div>
                <div class="mt-6 md:mt-0 flex gap-3 flex-wrap">
                    <a href="{{ route('jobs.index') }}" class="btn bg-white hover:bg-gray-50 text-primary-600 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Jobs
                    </a>
                    <a href="{{ route('seeker.profile.edit') }}" class="btn bg-white/10 hover:bg-white/20 text-white border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Stats Grid using design system stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
            <x-card variant="stat" label="Applied" value="{{ $metrics['applied'] }}" color="blue" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Saved" value="{{ $metrics['saved'] }}" color="rose" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Interviews" value="{{ $metrics['interviews'] }}" color="amber" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Profile Strength" value="{{ $metrics['profile_completion'] }}%" color="green" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Following" value="{{ $metrics['follows'] }}" color="purple" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-slot>
            </x-card>

            <x-card variant="stat" label="Alerts" value="{{ $metrics['alerts'] }}" color="indigo" padding="sm">
                <x-slot name="icon">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </x-slot>
            </x-card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (lg:col-span-2) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Profile Completion Suggestions -->
                @if(count($suggestions) > 0)
                    <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-500/20 rounded-2xl p-5 animate-fade-in">
                        <h3 class="font-bold text-sm text-amber-800 dark:text-amber-300 flex items-center gap-2 mb-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-600">💡</span>
                            Tips to improve profile strength & get noticed:
                        </h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2.5 text-xs text-amber-700 dark:text-amber-400">
                            @foreach($suggestions as $sug)
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 font-bold mt-0.5">&bull;</span>
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
                                <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800/60 flex justify-between items-center gap-4 flex-wrap hover:border-primary-500/25 transition">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $recJob->slug) }}" class="hover:text-primary-650 transition">{{ $recJob->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold mt-1">
                                            @if($recJob->company)
                                                <span class="text-gray-700 dark:text-gray-300">{{ $recJob->company->company_name }}</span> &bull;
                                            @endif
                                            <span>{{ $recJob->city }}, {{ $recJob->country }}</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('jobs.show', $recJob->slug) }}" class="btn btn-sm btn-primary">
                                        Apply Now
                                    </a>
                                </div>
                            @elseif(is_string($recJob))
                                <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800/60 flex justify-between items-center">
                                    <p class="text-xs text-gray-700 dark:text-gray-300 font-semibold">{{ $recJob }}</p>
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
                        <div class="flex justify-between items-center w-full">
                            <span>Recent Applications</span>
                            <a href="{{ route('seeker.applications.index') }}" class="text-xs font-bold text-primary-550 hover:underline">View All</a>
                        </div>
                    </x-slot>
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-800/60">
                        @forelse($recentApplications as $app)
                            @if(is_object($app) && isset($app->id) && $app->job)
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white hover:text-primary-500 transition">
                                            <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold mt-1">
                                            @if($app->job->company)
                                                <span class="text-gray-750 dark:text-gray-300">{{ $app->job->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Applied {{ $app->applied_at ? $app->applied_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="status-badge 
                                            @if($app->status === 'applied') status-draft
                                            @elseif($app->status === 'pending_review') status-pending
                                            @elseif($app->status === 'shortlisted') status-hired
                                            @elseif(str_contains($app->status, 'interview')) status-interview
                                            @elseif($app->status === 'offered') status-active
                                            @elseif($app->status === 'hired') status-active
                                            @elseif($app->status === 'withdrawn') status-draft
                                            @else status-closed
                                            @endif">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('seeker.applications.show', $app->id) }}" class="btn btn-sm btn-ghost">View</a>
                                    </div>
                                </div>
                            @elseif(is_string($app))
                                <div class="py-4 flex justify-between items-center first:pt-0 last:pb-0">
                                    <p class="text-xs text-gray-750 dark:text-gray-300 font-semibold">{{ $app }}</p>
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
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-800/60">
                        @forelse($savedJobs as $sv)
                            @if(is_object($sv) && isset($sv->slug))
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $sv->slug) }}" class="hover:text-primary-500 transition">{{ $sv->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold mt-1">
                                            @if($sv->company)
                                                <span class="text-gray-700 dark:text-gray-300">{{ $sv->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Saved {{ $sv->pivot && $sv->pivot->created_at ? $sv->pivot->created_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('jobs.save', $sv->id) }}">
                                            @csrf
                                            <button type="submit" class="text-2xs text-rose-500 font-bold hover:underline">Remove</button>
                                        </form>
                                        <a href="{{ route('jobs.show', $sv->slug) }}" class="btn btn-sm btn-ghost">Apply</a>
                                    </div>
                                </div>
                            @elseif(is_string($sv))
                                <div class="py-4 flex justify-between items-center first:pt-0 last:pb-0">
                                    <p class="text-xs text-gray-750 dark:text-gray-300 font-semibold">{{ $sv }}</p>
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
                    
                    <div class="relative border-s border-gray-250 dark:border-gray-800 ms-3 space-y-6 pt-2 pb-2">
                        @forelse($timeline as $timeItem)
                            @if(is_object($timeItem) && isset($timeItem->created_at))
                                <div class="mb-4 ms-4 relative">
                                    <div class="absolute -left-6 top-1.5 w-3 h-3 bg-primary-500 rounded-full border-2 border-white dark:border-gray-900 shadow-sm"></div>
                                    <p class="text-4xs text-gray-400 font-semibold">{{ $timeItem->created_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-xs font-bold text-gray-900 dark:text-white uppercase mt-1">{{ str_replace('_', ' ', $timeItem->action) }}</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 italic mt-0.5">"{{ $timeItem->description }}"</p>
                                </div>
                            @elseif(is_string($timeItem))
                                <div class="mb-4 ms-4 relative">
                                    <div class="absolute -left-6 top-1.5 w-3 h-3 bg-gray-400 rounded-full border-2 border-white dark:border-gray-900"></div>
                                    <p class="text-xs text-gray-750 dark:text-gray-300 font-semibold mt-1">{{ $timeItem }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Activity" subtitle="No timeline events logged yet." icon="⏳" />
                        @endforelse
                    </div>
                </x-card>

            </div>

            <!-- Right Column (Sidebar) -->
            <div class="space-y-6">

                <!-- Job Alerts Manager -->
                <x-card variant="default">
                    <x-slot name="header">My Job Alerts</x-slot>
                    
                    <div class="space-y-3">
                        @forelse($alerts as $al)
                            <div class="p-3 bg-gray-50 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 rounded-xl flex justify-between items-center gap-3">
                                <div>
                                    <p class="font-bold text-xs text-gray-900 dark:text-white">"{{ $al->keyword }}"</p>
                                    <p class="text-4xs text-gray-500 mt-0.5">{{ $al->location ?? 'Anywhere' }} &bull; {{ ucfirst($al->frequency) }}</p>
                                </div>
                                <form method="POST" action="{{ route('seeker.alerts.destroy', $al->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-3xs font-bold text-rose-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-2">No job alerts set up.</p>
                        @endforelse
                    </div>

                    <!-- Create alert inline form -->
                    <form method="POST" action="{{ route('seeker.alerts.store') }}" class="border-t border-gray-100 dark:border-gray-800 pt-4 space-y-3">
                        @csrf
                        <h4 class="font-bold text-xs text-gray-700 dark:text-gray-300">Create New Alert</h4>
                        
                        <div class="space-y-2">
                            <input type="text" name="keyword" required placeholder="Keyword (e.g. Laravel)" class="w-full text-xs" />
                            <input type="text" name="location" placeholder="City or province (Optional)" class="w-full text-xs" />
                        </div>
                        <div class="grid grid-cols-2 gap-2 items-center">
                            <select name="frequency" class="text-xs py-2">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                            <label class="inline-flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer">
                                <input type="checkbox" name="remote" value="1" />
                                <span class="text-3xs font-bold">Remote Only</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full btn btn-sm btn-primary">
                            Create Alert
                        </button>
                    </form>
                </x-card>

                <!-- Recent Notifications -->
                <x-card variant="default">
                    <x-slot name="header">Notifications</x-slot>
                    
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                        @forelse($notifications as $notif)
                            <div class="p-3 bg-gray-50 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 rounded-xl space-y-1">
                                <h5 class="font-bold text-2xs text-gray-850 dark:text-gray-200">{{ $notif->title }}</h5>
                                <p class="text-3xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $notif->body }}</p>
                                <span class="text-4xs text-gray-400 block pt-0.5">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-2">No in-app alerts received.</p>
                        @endforelse
                    </div>
                </x-card>

            </div>
        </div>

    </div>
</x-app-layout>
