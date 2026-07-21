<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Search & Query Analytics') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Stats Overview Card -->
            <div>
                <div>
                    <h3>{{ number_format($avgSearchTime, 0) }} ms</h3>
                    <p>Average Execution Speed</p>
                </div>
                <div>
                    <span>
                        ⚡ Highly Optimized Caching & Indexes
                    </span>
                </div>
            </div>

            <!-- Two Column Stats Lists -->
            <div>
                <!-- Top Keywords -->
                <div>
                    <h3>Top Search Keywords</h3>
                    <div>
                        @forelse($topKeywords as $item)
                            <div>
                                <span>"{{ $item->query_string }}"</span>
                                <span>{{ $item->count }} searches</span>
                            </div>
                        @empty
                            <p>No search query analytics recorded.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Zero Result Searches -->
                <div>
                    <h3>Zero-Result Searches (Opportunities)</h3>
                    <div>
                        @forelse($zeroResults as $item)
                            <div>
                                <span>"{{ $item->query_string }}"</span>
                                <span>{{ $item->count }} failures</span>
                            </div>
                        @empty
                            <p>No failed searches recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Two Column Popular Listings -->
            <div>
                <!-- Most Viewed Jobs -->
                <div>
                    <h3>Most Viewed Postings</h3>
                    <div>
                        @forelse($mostViewed as $job)
                            <div>
                                <span>{{ $job->title }}</span>
                                <span>{{ $job->views_count }} views</span>
                            </div>
                        @empty
                            <p>No postings views logged.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Applied Jobs -->
                <div>
                    <h3>Most Applied Postings</h3>
                    <div>
                        @forelse($mostApplied as $job)
                            <div>
                                <span>{{ $job->title }}</span>
                                <span>{{ $job->applications_count }} applications</span>
                            </div>
                        @empty
                            <p>No applications submitted.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Queries Log -->
            <div>
                <div>
                    <h3>Recent Search Query Stream</h3>
                </div>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Search Term</th>
                                <th>Filters Applied</th>
                                <th>Results Matches</th>
                                <th>Speed (ms)</th>
                                <th>User</th>
                                <th>Date Performed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentQueries as $q)
                                <tr>
                                    <td>"{{ $q->query_string ?? '(empty)' }}"</td>
                                    <td>{{ json_encode($q->filters) }}</td>
                                    <td>{{ $q->results_count }} matches</td>
                                    <td>{{ $q->search_time_ms }} ms</td>
                                    <td>{{ $q->user ? $q->user->first_name . ' ' . $q->user->last_name : 'Guest' }}</td>
                                    <td>{{ $q->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No search stream recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $recentQueries->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
