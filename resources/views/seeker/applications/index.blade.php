<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('My Job Applications') }}
        </h2>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dashboard Filters -->
            <div>
                @foreach([
                    'all' => 'All Applications',
                    'active' => 'Active',
                    'pending' => 'Pending Review',
                    'shortlisted' => 'Shortlisted',
                    'interviews' => 'Interviews',
                    'offers' => 'Offers',
                    'rejected' => 'Rejected',
                    'withdrawn' => 'Withdrawn'
                ] as $key => $label)
                    <a href="{{ route('seeker.applications.index', ['filter' => $key]) }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Applications List -->
            <div>
                <div>
                    <h3>Submission History</h3>
                </div>

                <div>
                    @forelse($applications as $app)
                        <div>
                            <div>
                                <div>
                                    <h4>
                                        <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                    </h4>
                                    
                                    <!-- Status Badges -->
                                    <span>
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </div>
                                <p>
                                    {{ $app->job->company->company_name }} &bull; Applied on {{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}
                                </p>
                                <div>
                                    Resume: {{ $app->resume->title }}
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('seeker.applications.show', $app->id) }}">View Details</a>
                                
                                @if(!in_array($app->status, ['rejected', 'withdrawn', 'hired']))
                                    <form method="POST" action="{{ route('seeker.applications.withdraw', $app->id) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to withdraw your application? This cannot be undone.');">
                                            Withdraw
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div>
                            No job applications found in this category. Let's find some openings!
                        </div>
                    @endforelse
                </div>

                <div>
                    {{ $applications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
