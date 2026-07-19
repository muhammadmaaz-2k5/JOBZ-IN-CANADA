<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Search & Query Analytics') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Stats Overview Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-3xl font-black text-indigo-650">{{ number_format($avgSearchTime, 0) }} ms</h3>
                    <p class="text-xs text-gray-500 font-bold uppercase mt-0.5">Average Execution Speed</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-650 dark:bg-indigo-950 dark:text-indigo-300 font-extrabold text-2xs rounded-xl border border-indigo-150">
                        ⚡ Highly Optimized Caching & Indexes
                    </span>
                </div>
            </div>

            <!-- Two Column Stats Lists -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Top Keywords -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-155">Top Search Keywords</h3>
                    <div class="divide-y divide-gray-100 dark:divide-gray-750">
                        @forelse($topKeywords as $item)
                            <div class="py-3 flex justify-between items-center text-xs font-bold">
                                <span class="text-gray-900 dark:text-white">"{{ $item->query_string }}"</span>
                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-900 rounded text-3xs font-extrabold text-gray-400">{{ $item->count }} searches</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-3 text-center">No search query analytics recorded.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Zero Result Searches -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-155">Zero-Result Searches (Opportunities)</h3>
                    <div class="divide-y divide-gray-100 dark:divide-gray-750">
                        @forelse($zeroResults as $item)
                            <div class="py-3 flex justify-between items-center text-xs font-bold">
                                <span class="text-red-500">"{{ $item->query_string }}"</span>
                                <span class="px-2 py-0.5 bg-red-50 dark:bg-red-950/20 rounded text-3xs font-extrabold text-red-400">{{ $item->count }} failures</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-3 text-center">No failed searches recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Two Column Popular Listings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Most Viewed Jobs -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-155">Most Viewed Postings</h3>
                    <div class="divide-y divide-gray-100 dark:divide-gray-750">
                        @forelse($mostViewed as $job)
                            <div class="py-3 flex justify-between items-center text-xs font-bold">
                                <span class="text-gray-900 dark:text-white truncate max-w-xs">{{ $job->title }}</span>
                                <span class="text-gray-400 font-extrabold">{{ $job->views_count }} views</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-3 text-center">No postings views logged.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Applied Jobs -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-155">Most Applied Postings</h3>
                    <div class="divide-y divide-gray-100 dark:divide-gray-750">
                        @forelse($mostApplied as $job)
                            <div class="py-3 flex justify-between items-center text-xs font-bold">
                                <span class="text-gray-900 dark:text-white truncate max-w-xs">{{ $job->title }}</span>
                                <span class="text-indigo-650 font-extrabold">{{ $job->applications_count }} applications</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic py-3 text-center">No applications submitted.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Queries Log -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Recent Search Query Stream</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Search Term</th>
                                <th class="p-4">Filters Applied</th>
                                <th class="p-4">Results Matches</th>
                                <th class="p-4">Speed (ms)</th>
                                <th class="p-4">User</th>
                                <th class="p-4 text-right">Date Performed</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($recentQueries as $q)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4 font-bold text-gray-900 dark:text-white">"{{ $q->query_string ?? '(empty)' }}"</td>
                                    <td class="p-4 text-gray-500 font-mono text-3xs">{{ json_encode($q->filters) }}</td>
                                    <td class="p-4">{{ $q->results_count }} matches</td>
                                    <td class="p-4 font-mono text-emerald-600">{{ $q->search_time_ms }} ms</td>
                                    <td class="p-4">{{ $q->user ? $q->user->first_name . ' ' . $q->user->last_name : 'Guest' }}</td>
                                    <td class="p-4 text-right text-gray-400">{{ $q->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No search stream recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $recentQueries->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
