<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Applicants') }}
            </h2>
            <a href="{{ route('employer.applicants.pipeline.all') }}" class="px-4 py-2 bg-indigo-650 text-white font-bold rounded-xl text-xs hover:bg-indigo-750 transition shadow-sm">
                ATS Kanban Board &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Controls -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('employer.applicants.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Job select filter -->
                    <div>
                        <x-input-label for="job_select" :value="__('Filter By Job Posting')" />
                        <select id="job_select" name="job_id" onchange="window.location.href=this.value" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl">
                            <option value="{{ route('employer.applicants.index') }}">All Job Listings</option>
                            @foreach($jobsList as $j)
                                <option value="{{ route('employer.applicants.job', $j->id) }}" @selected($jobId == $j->id)>{{ $j->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <x-input-label for="search" :value="__('Search Candidate Name')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. John Doe" :value="request('search')" />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label for="status" :value="__('Hiring Stage Status')" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl">
                            <option value="">All Stages</option>
                            @foreach([
                                'applied' => 'Applied',
                                'pending_review' => 'Pending Review',
                                'shortlisted' => 'Shortlisted',
                                'interview_scheduled' => 'Interview Scheduled',
                                'interview_completed' => 'Interview Completed',
                                'offered' => 'Offered',
                                'hired' => 'Hired',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn'
                            ] as $key => $lbl)
                                <option value="{{ $key }}" @selected(request('status') == $key)>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <div class="w-full">
                            <x-input-label for="sort" :value="__('Sort')" />
                            <select id="sort" name="sort" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-750 text-white font-bold rounded-xl text-sm transition">
                            Apply
                        </button>
                    </div>
                </form>
            </div>

            <!-- Applicants list -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                            <th class="p-6">Candidate Name</th>
                            <th class="p-6">Job Applied</th>
                            <th class="p-6">Submission Date</th>
                            <th class="p-6">Hiring Stage Status</th>
                            <th class="p-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-sm">
                        @forelse($applications as $app)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-1 font-bold text-gray-400">
                                            @if($app->applicant->jobSeekerProfile && $app->applicant->jobSeekerProfile->profile_photo)
                                                <img src="{{ asset('storage/' . $app->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" class="w-full h-full rounded-full object-cover" />
                                            @else
                                                {{ substr($app->applicant->first_name, 0, 1) }}{{ substr($app->applicant->last_name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-gray-900 dark:text-white">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</p>
                                            <p class="text-3xs text-gray-400">{{ $app->applicant->jobSeekerProfile->headline ?? 'Job Seeker' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <p class="font-bold text-gray-800 dark:text-gray-200">{{ $app->job->title }}</p>
                                </td>
                                <td class="p-6 text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}
                                </td>
                                <td class="p-6">
                                    <span class="px-2.5 py-0.5 rounded-full text-3xs font-extrabold uppercase 
                                        @if($app->status === 'applied') bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                                        @elseif($app->status === 'pending_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300
                                        @elseif($app->status === 'shortlisted') bg-indigo-100 text-indigo-850 dark:bg-indigo-950 dark:text-indigo-300
                                        @elseif(str_contains($app->status, 'interview')) bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300
                                        @elseif($app->status === 'offered') bg-pink-100 text-pink-850 dark:bg-pink-950 dark:text-pink-300
                                        @elseif($app->status === 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                        @elseif($app->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                                        @endif">
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('employer.applicants.download', $app->id) }}" class="text-xs font-semibold text-indigo-650 hover:underline">Download Resume</a>
                                        <a href="{{ route('employer.applicants.show', $app->id) }}" class="px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-900 dark:hover:bg-gray-950 text-gray-750 dark:text-gray-200 font-bold rounded-xl text-xs transition">
                                            Review Profile
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-500">
                                    No applicants found matching this criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-6 bg-gray-50 dark:bg-gray-900/30">
                    {{ $applications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
