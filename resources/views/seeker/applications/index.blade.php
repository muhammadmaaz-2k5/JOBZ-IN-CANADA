<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                {{ __('My Job Applications') }}
            </h2>
            <a href="{{ route('seeker.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-400 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Dashboard Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-4 md:p-6 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/10 dark:to-indigo-900/10 z-0"></div>
                <div class="relative z-10 flex flex-wrap gap-2 md:gap-3 items-center">
                    @php
                        $currentFilter = request()->get('filter', 'all');
                    @endphp
                    
                    <span class="text-sm font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mr-2 hidden md:block">Filter:</span>
                    
                    @foreach([
                        'all' => 'All Applications',
                        'active' => 'Active',
                        'pending' => 'Pending Review',
                        'shortlisted' => 'Shortlisted',
                        'offers' => 'Offers',
                        'rejected' => 'Rejected',
                        'withdrawn' => 'Withdrawn'
                    ] as $key => $label)
                        <a href="{{ route('seeker.applications.index', ['filter' => $key]) }}" 
                           class="px-4 py-2 text-sm font-bold rounded-xl transition-all {{ $currentFilter == $key ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">Submission History</h3>
                </div>

                <div class="space-y-4">
                    @forelse($applications as $app)
                        @php
                            $statusColors = [
                                'applied' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                'shortlisted' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
                                'offered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'hired' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                'withdrawn' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            ];
                            $colorClass = $statusColors[$app->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        @endphp
                        
                        <div class="group flex flex-col lg:flex-row items-start lg:items-center justify-between p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-800 shadow-sm hover:shadow transition-all gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        <a href="{{ route('seeker.applications.show', $app->id) }}" class="focus:outline-none before:absolute before:inset-0 relative">{{ $app->job->title }}</a>
                                    </h4>
                                    <!-- Status Badges -->
                                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $colorClass }}">
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 font-medium text-sm mb-3">
                                    <span class="text-gray-900 dark:text-white font-bold">{{ $app->job->company->company_name }}</span> 
                                    <span class="mx-2 text-gray-300 dark:text-gray-600">&bull;</span> 
                                    Applied on {{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}
                                </p>
                                <div class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 bg-gray-50 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    Resume: <span class="text-gray-700 dark:text-gray-300">{{ $app->resume->title }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full lg:w-auto relative z-10 shrink-0">
                                <a href="{{ route('seeker.applications.show', $app->id) }}" class="flex-1 lg:flex-none text-center px-6 py-2.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold rounded-xl transition-colors">
                                    View Details
                                </a>
                                
                                @if(!in_array($app->status, ['rejected', 'withdrawn', 'hired']))
                                    <form method="POST" action="{{ route('seeker.applications.withdraw', $app->id) }}" class="flex-1 lg:flex-none">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to withdraw your application? This cannot be undone.');" class="w-full text-center px-6 py-2.5 bg-gray-100 hover:bg-red-50 dark:bg-gray-700 dark:hover:bg-red-900/30 text-gray-600 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400 font-bold rounded-xl transition-colors">
                                            Withdraw
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50/50 dark:bg-gray-900/20 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                            <div class="w-20 h-20 mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2">No applications found</h3>
                            <p class="text-gray-500 font-medium mb-6">You haven't submitted any applications that match this filter.</p>
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                                Browse Jobs
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
