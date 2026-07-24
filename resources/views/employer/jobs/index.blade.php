<x-app-layout>
    <x-slot name="header">
        Manage Job Openings
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 relative z-10">
        
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[60%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        <!-- Top Action Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Job Postings</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Create, manage, and promote your active job listings.</p>
            </div>
            <a href="{{ route('employer.jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:scale-105 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Post a New Job
            </a>
        </div>

        @if(session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('warning'))
            <x-alert type="warning">
                {{ session('warning') }}
            </x-alert>
        @endif

        <!-- Job Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Active Jobs -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6 flex items-center gap-4 transform transition-all hover:-translate-y-1 hover:shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Active</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $jobs->where('status', 'published')->count() }}</h3>
                </div>
            </div>
            
            <!-- Draft Listings -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6 flex items-center gap-4 transform transition-all hover:-translate-y-1 hover:shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Drafts</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $jobs->where('status', 'draft')->count() }}</h3>
                </div>
            </div>
            
            <!-- Total Job Views -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6 flex items-center gap-4 transform transition-all hover:-translate-y-1 hover:shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Views</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $jobs->sum('views_count') }}</h3>
                </div>
            </div>
            
            <!-- Total Applications -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6 flex items-center gap-4 transform transition-all hover:-translate-y-1 hover:shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Apps</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $jobs->sum('applications_count') }}</h3>
                </div>
            </div>
        </div>

        <!-- Jobs List -->
        <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-100 dark:border-slate-700/50">
                <h3 class="text-xl font-black text-slate-900 dark:text-white">Active & Past Job Listings</h3>
            </div>

            <div class="p-6 sm:p-8">
                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="group flex flex-col lg:flex-row lg:items-center justify-between p-6 rounded-2xl border border-gray-200/60 dark:border-slate-700/50 bg-white/50 dark:bg-slate-800/40 hover:border-emerald-300 dark:hover:border-emerald-500 hover:shadow-md transition-all duration-300 gap-6">
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    
                                    <!-- Status Badges -->
                                    <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                        @if($job->status === 'published') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                        @elseif($job->status === 'paused') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                        @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400 @endif">
                                        {{ $job->status }}
                                    </span>
                                    
                                    @if($job->featured)
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white uppercase tracking-wide flex items-center gap-1 shadow-md shadow-purple-500/20" title="Active Premium Placement">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                            Promoted
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">
                                    Posted on {{ $job->created_at->format('M d, Y') }} 
                                    @if($job->application_deadline)
                                        <span class="mx-2">&bull;</span> <span class="text-rose-500 dark:text-rose-400">Deadline: {{ CarbonCarbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                                    @endif
                                </p>
                                
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-slate-800 text-blue-500"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></span>
                                        {{ $job->views_count }} Views
                                    </div>
                                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="p-1.5 rounded-lg bg-purple-50 dark:bg-slate-800 text-purple-500"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></span>
                                        {{ $job->applications_count }} Applications
                                    </div>
                                </div>
                            </div>

                            <!-- Actions Row -->
                            <div class="flex flex-wrap lg:flex-nowrap items-center gap-3 shrink-0">
                                @if(!$job->featured)
                                    <a href="{{ route('employer.jobs.promote', $job->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl transition-all shadow-md shadow-purple-500/20 hover:scale-105 text-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        Promote
                                    </a>
                                @endif
                                
                                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-white font-bold rounded-xl transition-colors text-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    Edit
                                </a>
                                
                                <!-- State Toggle Form -->
                                <form method="POST" action="{{ route('employer.jobs.status', $job->id) }}" class="inline-block">
                                    @csrf
                                    @if($job->status === 'published')
                                        <input type="hidden" name="status" value="paused" />
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/30 dark:hover:bg-amber-900/50 dark:text-amber-400 font-bold rounded-xl transition-colors text-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Pause
                                        </button>
                                    @elseif($job->status === 'paused' || $job->status === 'draft')
                                        <input type="hidden" name="status" value="published" />
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 dark:text-emerald-400 font-bold rounded-xl transition-colors text-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Publish
                                        </button>
                                    @endif
                                </form>

                                <form method="POST" action="{{ route('employer.jobs.duplicate', $job->id) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 font-bold rounded-xl transition-colors text-sm" title="Duplicate this job">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('employer.jobs.destroy', $job->id) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this job listing?');" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 dark:text-rose-400 font-bold rounded-xl transition-colors text-sm" title="Delete job">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 px-4">
                            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">No Job Listings Posted Yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 font-medium mb-8 max-w-md mx-auto">Create your first job listing to start receiving applications from talented candidates across Canada.</p>
                            <a href="{{ route('employer.jobs.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:scale-105 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                Post a New Job Now
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($jobs->hasPages())
                    <div class="mt-8">
                        {{ $jobs->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
