<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Manage Applicants') }}
            </h2>
            <a href="{{ route('employer.applicants.pipeline.all') }}">
                ATS Kanban Board &rarr;
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Filter Controls -->
            <div>
                <form method="GET" action="{{ route('employer.applicants.index') }}">
                    <!-- Job select filter -->
                    <div>
                        <x-input-label for="job_select" :value="__('Filter By Job Posting')" />
                        <select id="job_select" name="job_id" onchange="window.location.href=this.value">
                            <option value="{{ route('employer.applicants.index') }}">All Job Listings</option>
                            @foreach($jobsList as $j)
                                <option value="{{ route('employer.applicants.job', $j->id) }}" @selected($jobId == $j->id)>{{ $j->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <x-input-label for="search" :value="__('Search Candidate Name')" />
                        <x-text-input id="search" name="search" type="text" placeholder="e.g. John Doe" :value="request('search')" />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label for="status" :value="__('Hiring Stage Status')" />
                        <select id="status" name="status">
                            <option value="">All Stages</option>
                            @foreach([
                                'applied' => 'Applied',
                                'pending_review' => 'Pending Review',
                                'shortlisted' => 'Shortlisted',
                                'offered' => 'Offered',
                                'hired' => 'Hired',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn'
                            ] as $key => $lbl)
                                <option value="{{ $key }}" @selected(request('status') == $key)>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div>
                            <x-input-label for="sort" :value="__('Sort')" />
                            <select id="sort" name="sort">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                            </select>
                        </div>
                        <button type="submit">
                            Apply
                        </button>
                    </div>
                </form>
            </div>

            <!-- Applicants list -->
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Candidate Name</th>
                            <th>Job Applied</th>
                            <th>Submission Date</th>
                            <th>Hiring Stage Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td>
                                    <div>
                                        <div>
                                            @if($app->applicant->jobSeekerProfile && $app->applicant->jobSeekerProfile->profile_photo)
                                                <img src="{{ asset('storage/' . $app->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" />
                                            @else
                                                {{ substr($app->applicant->first_name, 0, 1) }}{{ substr($app->applicant->last_name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p>{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</p>
                                            <p>{{ $app->applicant->jobSeekerProfile->headline ?? 'Job Seeker' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p>{{ $app->job->title }}</p>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}
                                </td>
                                <td>
                                    <span>
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ route('employer.applicants.download', $app->id) }}">Download Resume</a>
                                        <a href="{{ route('employer.applicants.show', $app->id) }}">
                                            Review Profile
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    No applicants found matching this criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div>
                    {{ $applications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
