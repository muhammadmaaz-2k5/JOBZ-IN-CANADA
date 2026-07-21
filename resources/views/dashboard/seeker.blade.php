<x-app-layout>
    <x-slot name="header">
        {{ __('Job Seeker Dashboard') }}
    </x-slot>

    <div>
        
        @if(session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header Banner -->
        <x-card variant="gradient" color="blue" padding="lg">
            <div>
                <div>
                    <span>
                        Candidate Dashboard
                    </span>
                    <h1>Welcome back, {{ Auth::user()->first_name }}!</h1>
                    <p>
                        Find and apply for top jobs across Canada. Track your progress, manage alerts, and update your professional profile to stand out to employers.
                    </p>
                </div>
                <div>
                    <a href="{{ route('jobs.index') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Jobs
                    </a>
                    <a href="{{ route('seeker.profile.edit') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Stats Grid using design system stat cards -->
        <div>
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

        <div>
            <!-- Left Column (lg:col-span-2) -->
            <div>

                <!-- Profile Completion Suggestions -->
                @if(count($suggestions) > 0)
                    <div>
                        <h3>
                            <span>💡</span>
                            Tips to improve profile strength & get noticed:
                        </h3>
                        <ul>
                            @foreach($suggestions as $sug)
                                <li>
                                    <span>&bull;</span>
                                    <span>{{ $sug }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Recommended Jobs -->
                <x-card variant="default">
                    <x-slot name="header">Recommended Jobs For You</x-slot>
                    <div>
                        @forelse($recommendedJobs as $recJob)
                            @if(is_object($recJob) && isset($recJob->slug))
                                <div>
                                    <div>
                                        <h4>
                                            <a href="{{ route('jobs.show', $recJob->slug) }}">{{ $recJob->title }}</a>
                                        </h4>
                                        <p>
                                            @if($recJob->company)
                                                <span>{{ $recJob->company->company_name }}</span> &bull;
                                            @endif
                                            <span>{{ $recJob->city }}, {{ $recJob->country }}</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('jobs.show', $recJob->slug) }}">
                                        Apply Now
                                    </a>
                                </div>
                            @elseif(is_string($recJob))
                                <div>
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
                        <div>
                            <span>Recent Applications</span>
                            <a href="{{ route('seeker.applications.index') }}">View All</a>
                        </div>
                    </x-slot>
                    
                    <div>
                        @forelse($recentApplications as $app)
                            @if(is_object($app) && isset($app->id) && $app->job)
                                <div>
                                    <div>
                                        <h4>
                                            <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                        </h4>
                                        <p>
                                            @if($app->job->company)
                                                <span>{{ $app->job->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Applied {{ $app->applied_at ? $app->applied_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span>
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('seeker.applications.show', $app->id) }}">View</a>
                                    </div>
                                </div>
                            @elseif(is_string($app))
                                <div>
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
                    
                    <div>
                        @forelse($savedJobs as $sv)
                            @if(is_object($sv) && isset($sv->slug))
                                <div>
                                    <div>
                                        <h4>
                                            <a href="{{ route('jobs.show', $sv->slug) }}">{{ $sv->title }}</a>
                                        </h4>
                                        <p>
                                            @if($sv->company)
                                                <span>{{ $sv->company->company_name }}</span> &bull;
                                            @endif
                                            <span>Saved {{ $sv->pivot && $sv->pivot->created_at ? $sv->pivot->created_at->diffForHumans() : 'recently' }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <form method="POST" action="{{ route('jobs.save', $sv->id) }}">
                                            @csrf
                                            <button type="submit">Remove</button>
                                        </form>
                                        <a href="{{ route('jobs.show', $sv->slug) }}">Apply</a>
                                    </div>
                                </div>
                            @elseif(is_string($sv))
                                <div>
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
                    
                    <div>
                        @forelse($timeline as $timeItem)
                            @if(is_object($timeItem) && isset($timeItem->created_at))
                                <div>
                                    <div></div>
                                    <p>{{ $timeItem->created_at->format('M d, Y - h:i A') }}</p>
                                    <h5>{{ str_replace('_', ' ', $timeItem->action) }}</h5>
                                    <p>"{{ $timeItem->description }}"</p>
                                </div>
                            @elseif(is_string($timeItem))
                                <div>
                                    <div></div>
                                    <p>{{ $timeItem }}</p>
                                </div>
                            @endif
                        @empty
                            <x-empty-state title="No Activity" subtitle="No timeline events logged yet." icon="⏳" />
                        @endforelse
                    </div>
                </x-card>

            </div>

            <!-- Right Column (Sidebar) -->
            <div>

                <!-- Job Alerts Manager -->
                <x-card variant="default">
                    <x-slot name="header">My Job Alerts</x-slot>
                    
                    <div>
                        @forelse($alerts as $al)
                            <div>
                                <div>
                                    <p>"{{ $al->keyword }}"</p>
                                    <p>{{ $al->location ?? 'Anywhere' }} &bull; {{ ucfirst($al->frequency) }}</p>
                                </div>
                                <form method="POST" action="{{ route('seeker.alerts.destroy', $al->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        @empty
                            <p>No job alerts set up.</p>
                        @endforelse
                    </div>

                    <!-- Create alert inline form -->
                    <form method="POST" action="{{ route('seeker.alerts.store') }}">
                        @csrf
                        <h4>Create New Alert</h4>
                        
                        <div>
                            <input type="text" name="keyword" required placeholder="Keyword (e.g. Laravel)" />
                            <input type="text" name="location" placeholder="City or province (Optional)" />
                        </div>
                        <div>
                            <select name="frequency">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                            <label>
                                <input type="checkbox" name="remote" value="1" />
                                <span>Remote Only</span>
                            </label>
                        </div>

                        <button type="submit">
                            Create Alert
                        </button>
                    </form>
                </x-card>

                <!-- Recent Notifications -->
                <x-card variant="default">
                    <x-slot name="header">Notifications</x-slot>
                    
                    <div>
                        @forelse($notifications as $notif)
                            <div>
                                <h5>{{ $notif->title }}</h5>
                                <p>{{ $notif->body }}</p>
                                <span>{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p>No in-app alerts received.</p>
                        @endforelse
                    </div>
                </x-card>

            </div>
        </div>

    </div>
</x-app-layout>
