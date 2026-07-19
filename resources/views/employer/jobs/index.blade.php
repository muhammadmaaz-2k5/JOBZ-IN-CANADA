<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Job Openings') }}
            </h2>
            <a href="{{ route('employer.jobs.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
                + Post a New Job
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-500/30 text-amber-800 dark:text-amber-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Job Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Total Active Jobs</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $jobs->where('status', 'published')->count() }}</h3>
                </div>
                <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Draft Listings</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $jobs->where('status', 'draft')->count() }}</h3>
                </div>
                <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Total Job Views</span>
                    <h3 class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-1">{{ $jobs->sum('views_count') }}</h3>
                </div>
                <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">Total Applications</span>
                    <h3 class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-1">{{ $jobs->sum('applications_count') }}</h3>
                </div>
            </div>

            <!-- Jobs List Table/Cards -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/50">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Active & Past Job Listings</h3>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($jobs as $job)
                        <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-extrabold text-base text-gray-900 dark:text-white">
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="hover:underline">{{ $job->title }}</a>
                                    </h4>
                                    
                                    <!-- Status Badges -->
                                    <span class="px-2.5 py-0.5 rounded-full text-3xs font-extrabold uppercase 
                                        @if($job->status === 'published') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                        @elseif($job->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @elseif($job->status === 'paused') bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300
                                        @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                                        @endif">
                                        {{ $job->status }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Posted on {{ $job->created_at->format('M d, Y') }} 
                                    @if($job->application_deadline)
                                        &bull; Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                    @endif
                                </p>
                                <div class="flex items-center gap-4 text-xs text-gray-400 pt-1">
                                    <span>Views: <strong class="text-gray-700 dark:text-gray-200">{{ $job->views_count }}</strong></span>
                                    <span>Applications: <strong class="text-gray-700 dark:text-gray-200">{{ $job->applications_count }}</strong></span>
                                </div>
                            </div>

                            <!-- Actions Row -->
                            <div class="flex items-center gap-3 flex-wrap">
                                @if(!$job->featured)
                                    <a href="{{ route('employer.jobs.promote', $job->id) }}" class="text-xs font-bold text-emerald-600 hover:underline">⭐ Promote</a>
                                @else
                                    <span class="text-xs text-yellow-500 font-extrabold" title="Active Premium Placement">&#9733; Promoted</span>
                                @endif
                                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:underline">Edit</a>
                                
                                <form method="POST" action="{{ route('employer.jobs.duplicate', $job->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Duplicate</button>
                                </form>

                                <!-- State Toggle Form -->
                                <form method="POST" action="{{ route('employer.jobs.status', $job->id) }}">
                                    @csrf
                                    @if($job->status === 'published')
                                        <input type="hidden" name="status" value="paused" />
                                        <button type="submit" class="text-xs font-semibold text-amber-600 hover:underline">Pause</button>
                                    @elseif($job->status === 'paused' || $job->status === 'draft')
                                        <input type="hidden" name="status" value="published" />
                                        <button type="submit" class="text-xs font-semibold text-emerald-600 hover:underline">Publish</button>
                                    @endif
                                </form>

                                <form method="POST" action="{{ route('employer.jobs.destroy', $job->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this job listing?');" class="text-xs font-semibold text-red-650 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500">
                            No job listings posted yet. Click "+ Post a New Job" to list your first vacancy.
                        </div>
                    @endforelse
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-900/30">
                    {{ $jobs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
