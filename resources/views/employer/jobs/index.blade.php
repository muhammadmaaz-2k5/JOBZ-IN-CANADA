<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Manage Job Openings') }}
            </h2>
            <a href="{{ route('employer.jobs.create') }}">
                + Post a New Job
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div>
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Job Statistics Cards -->
            <div>
                <div>
                    <span>Total Active Jobs</span>
                    <h3>{{ $jobs->where('status', 'published')->count() }}</h3>
                </div>
                <div>
                    <span>Draft Listings</span>
                    <h3>{{ $jobs->where('status', 'draft')->count() }}</h3>
                </div>
                <div>
                    <span>Total Job Views</span>
                    <h3>{{ $jobs->sum('views_count') }}</h3>
                </div>
                <div>
                    <span>Total Applications</span>
                    <h3>{{ $jobs->sum('applications_count') }}</h3>
                </div>
            </div>

            <!-- Jobs List Table/Cards -->
            <div>
                <div>
                    <h3>Active & Past Job Listings</h3>
                </div>

                <div>
                    @forelse($jobs as $job)
                        <div>
                            <div>
                                <div>
                                    <h4>
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    
                                    <!-- Status Badges -->
                                    <span>
                                        {{ $job->status }}
                                    </span>
                                </div>
                                <p>
                                    Posted on {{ $job->created_at->format('M d, Y') }} 
                                    @if($job->application_deadline)
                                        &bull; Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                    @endif
                                </p>
                                <div>
                                    <span>Views: <strong>{{ $job->views_count }}</strong></span>
                                    <span>Applications: <strong>{{ $job->applications_count }}</strong></span>
                                </div>
                            </div>

                            <!-- Actions Row -->
                            <div>
                                @if(!$job->featured)
                                    <a href="{{ route('employer.jobs.promote', $job->id) }}">⭐ Promote</a>
                                @else
                                    <span title="Active Premium Placement">&#9733; Promoted</span>
                                @endif
                                <a href="{{ route('employer.jobs.edit', $job->id) }}">Edit</a>
                                
                                <form method="POST" action="{{ route('employer.jobs.duplicate', $job->id) }}">
                                    @csrf
                                    <button type="submit">Duplicate</button>
                                </form>

                                <!-- State Toggle Form -->
                                <form method="POST" action="{{ route('employer.jobs.status', $job->id) }}">
                                    @csrf
                                    @if($job->status === 'published')
                                        <input type="hidden" name="status" value="paused" />
                                        <button type="submit">Pause</button>
                                    @elseif($job->status === 'paused' || $job->status === 'draft')
                                        <input type="hidden" name="status" value="published" />
                                        <button type="submit">Publish</button>
                                    @endif
                                </form>

                                <form method="POST" action="{{ route('employer.jobs.destroy', $job->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this job listing?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div>
                            No job listings posted yet. Click "+ Post a New Job" to list your first vacancy.
                        </div>
                    @endforelse
                </div>

                <div>
                    {{ $jobs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
