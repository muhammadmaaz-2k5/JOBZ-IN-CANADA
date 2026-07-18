<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Seeker Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-indigo-650 to-purple-600 rounded-3xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="md:flex md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Welcome back, {{ Auth::user()->first_name }}!</h1>
                        <p class="mt-2 text-indigo-100 max-w-xl text-sm">Find and apply for top jobs across Canada. Track your progress, manage alerts, and update your professional profile.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex gap-3 flex-wrap">
                        <a href="{{ route('jobs.index') }}" class="px-5 py-2.5 bg-white text-indigo-650 font-bold rounded-xl shadow-md hover:bg-indigo-50 transition text-xs">
                            Search Jobs
                        </a>
                        <a href="{{ route('seeker.profile.edit') }}" class="px-5 py-2.5 bg-indigo-800/40 text-white font-bold rounded-xl hover:bg-indigo-800/60 transition text-xs border border-indigo-400/20">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-650 dark:text-blue-400 rounded-xl">
                        📈
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['applied'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Applied</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-rose-50 dark:bg-rose-950/30 text-rose-650 dark:text-rose-400 rounded-xl">
                        ❤️
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['saved'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Saved</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-650 dark:text-amber-400 rounded-xl">
                        📅
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['interviews'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Interviews</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-650 dark:text-emerald-400 rounded-xl">
                        🎯
                    </div>
                    <div class="flex-grow">
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['profile_completion'] }}%</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Profile Strength</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-purple-50 dark:bg-purple-950/30 text-purple-650 dark:text-purple-400 rounded-xl">
                        🏢
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['follows'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Following</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-650 dark:text-indigo-400 rounded-xl">
                        🔔
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['alerts'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Alerts</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Profile Completion Suggestions -->
                    @if(count($suggestions) > 0)
                        <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-500/20 rounded-2xl p-6">
                            <h3 class="font-extrabold text-sm text-amber-800 dark:text-amber-300 flex items-center gap-2 mb-3">
                                💡 Tip: Improve Your Profile Strength
                            </h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-amber-700 dark:text-amber-400">
                                @foreach($suggestions as $sug)
                                    <li class="flex items-center gap-2">
                                        <span class="text-amber-500 font-bold">&check;</span> {{ $sug }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Recommended Jobs -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Recommended Jobs For You</h3>
                        
                        <div class="space-y-3">
                            @forelse($recommendedJobs as $recJob)
                                <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-150 dark:border-gray-800 flex justify-between items-center gap-4 flex-wrap">
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $recJob->slug) }}" class="hover:text-indigo-650 transition">{{ $recJob->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold">{{ $recJob->company->company_name }} &bull; {{ $recJob->city }}, {{ $recJob->country }}</p>
                                    </div>
                                    <a href="{{ route('jobs.show', $recJob->slug) }}" class="px-3.5 py-1.5 bg-indigo-650 hover:bg-indigo-750 text-white font-bold rounded-xl text-2xs transition">
                                        Apply Now
                                    </a>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-3 text-center">No recommended jobs found. Update your profile skills to view recommendations.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Recent Applications</h3>
                            <a href="{{ route('seeker.applications.index') }}" class="text-xs font-bold text-indigo-650 hover:underline">View All</a>
                        </div>
                        
                        <div class="divide-y divide-gray-100 dark:divide-gray-750">
                            @forelse($recentApplications as $app)
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white hover:text-indigo-650 transition">
                                            <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold">{{ $app->job->company->company_name }} &bull; Applied {{ $app->applied_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-3xs font-extrabold uppercase 
                                            @if($app->status === 'applied') bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                                            @elseif($app->status === 'pending_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300
                                            @elseif($app->status === 'shortlisted') bg-indigo-100 text-indigo-850 dark:bg-indigo-950 dark:text-indigo-300
                                            @elseif(str_contains($app->status, 'interview')) bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300
                                            @elseif($app->status === 'offered') bg-pink-100 text-pink-855 dark:bg-pink-950 dark:text-pink-300
                                            @elseif($app->status === 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                            @elseif($app->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                                            @endif">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('seeker.applications.show', $app->id) }}" class="text-2xs font-semibold text-gray-500 hover:underline">View</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-6 text-center">You haven't submitted any job applications yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Bookmarked Saved Jobs -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Saved Jobs</h3>
                        
                        <div class="divide-y divide-gray-100 dark:divide-gray-750">
                            @forelse($savedJobs as $sv)
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $sv->slug) }}" class="hover:text-indigo-650 transition">{{ $sv->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 font-semibold">{{ $sv->company->company_name }} &bull; Saved {{ $sv->pivot->created_at ? $sv->pivot->created_at->diffForHumans() : '' }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('jobs.save', $sv->id) }}">
                                            @csrf
                                            <button type="submit" class="text-2xs text-red-500 font-bold hover:underline">Remove</button>
                                        </form>
                                        <a href="{{ route('jobs.show', $sv->slug) }}" class="px-3 py-1 bg-indigo-50 dark:bg-indigo-950 text-indigo-650 dark:text-indigo-400 font-bold text-2xs rounded-lg transition">Apply</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-6 text-center">No saved job listings bookmarks found.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Timeline Activity Log -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Recent Activity Timeline</h3>
                        
                        <div class="relative border-s border-gray-200 dark:border-gray-700 ms-3 space-y-6 pt-2 pb-2">
                            @forelse($timeline as $timeItem)
                                <div class="mb-4 ms-4 relative">
                                    <div class="absolute -left-6 top-1.5 w-3 h-3 bg-indigo-600 rounded-full border border-white dark:border-gray-800"></div>
                                    <p class="text-3xs text-gray-400">{{ $timeItem->created_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-xs font-bold text-gray-900 dark:text-white uppercase mt-0.5">{{ str_replace('_', ' ', $timeItem->action) }}</h5>
                                    <p class="text-xs text-gray-500 italic mt-0.5">"{{ $timeItem->description }}"</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-3 text-center">No timeline events logged.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar) -->
                <div class="space-y-6">

                    <!-- Job Alerts Manager -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">My Job Alerts</h3>
                        
                        <div class="space-y-3">
                            @forelse($alerts as $al)
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl flex justify-between items-center gap-3">
                                    <div>
                                        <p class="font-extrabold text-xs text-gray-900 dark:text-white">"{{ $al->keyword }}"</p>
                                        <p class="text-3xs text-gray-500">{{ $al->location ?? 'Anywhere' }} &bull; {{ ucfirst($al->frequency) }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('seeker.alerts.destroy', $al->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-3xs font-bold text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No job alerts set up.</p>
                            @endforelse
                        </div>

                        <!-- Create alert inline form -->
                        <form method="POST" action="{{ route('seeker.alerts.store') }}" class="border-t border-gray-100 dark:border-gray-700/50 pt-4 space-y-3">
                            @csrf
                            <h4 class="font-bold text-xs text-gray-700 dark:text-gray-300">Create New Alert</h4>
                            
                            <div>
                                <input type="text" name="keyword" required placeholder="Keyword (e.g. Laravel)" class="w-full text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl" />
                            </div>
                            <div>
                                <input type="text" name="location" placeholder="City or province (Optional)" class="w-full text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl" />
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <select name="frequency" class="text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl py-1.5">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                                <label class="inline-flex items-center gap-1.5 text-xs text-gray-550 dark:text-gray-400">
                                    <input type="checkbox" name="remote" value="1" class="rounded border-gray-300" />
                                    Remote Only
                                </label>
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-750 text-white font-bold rounded-xl text-xs transition shadow-sm">
                                Create Alert
                            </button>
                        </form>
                    </div>

                    <!-- Recent Notifications -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Notifications</h3>
                        
                        <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                            @forelse($notifications as $notif)
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl space-y-1">
                                    <h5 class="font-extrabold text-2xs text-gray-800 dark:text-gray-200">{{ $notif->title }}</h5>
                                    <p class="text-3xs text-gray-550 dark:text-gray-400 leading-relaxed">{{ $notif->body }}</p>
                                    <span class="text-4xs text-gray-400 block">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No in-app alerts received.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
