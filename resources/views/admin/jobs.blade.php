<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Listings Moderation') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
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

            <!-- Search and Filter -->
            <div>
                <form method="GET" action="{{ route('admin.jobs.index') }}">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Status')" />
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="published" @selected(request('status') == 'published')>Published</option>
                            <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                            <option value="closed" @selected(request('status') == 'closed')>Closed</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Job Title')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Laravel" value="{{ request('search') }}" />
                    </div>

                    <div>
                        <button type="submit">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Jobs Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Featured / Urgent</th>
                                <th>Views / Apps</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr>
                                    <td>
                                        <div>
                                            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank">{{ $job->title }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $job->company->company_name }}</td>
                                    <td>
                                        <span>
                                            {{ $job->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <span>
                                                Featured: {{ $job->featured ? 'Yes' : 'No' }}
                                            </span>
                                            <span>
                                                Urgent: {{ $job->urgent ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $job->views_count }} / {{ $job->applications_count }}</td>
                                    <td>
                                        <div>
                                            <!-- Approve / Reject -->
                                            @if($job->status !== 'published')
                                                <form method="POST" action="{{ route('admin.jobs.approve', $job->id) }}">
                                                    @csrf
                                                    <button type="submit">Approve</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.jobs.reject', $job->id) }}">
                                                    @csrf
                                                    <button type="submit">Reject</button>
                                                </form>
                                            @endif

                                            <!-- Toggle Featured -->
                                            <form method="POST" action="{{ route('admin.jobs.feature', $job->id) }}">
                                                @csrf
                                                <button type="submit">Featured</button>
                                            </form>

                                            <!-- Toggle Urgent -->
                                            <form method="POST" action="{{ route('admin.jobs.urgent', $job->id) }}">
                                                @csrf
                                                <button type="submit">Urgent</button>
                                            </form>

                                            <!-- Delete -->
                                            <form method="POST" action="{{ route('admin.jobs.delete', $job->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure? This will delete the listing permanent.');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No job listings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $jobs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
