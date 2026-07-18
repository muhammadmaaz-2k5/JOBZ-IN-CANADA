<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listings Moderation') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('admin.jobs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Status')" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                            <option value="">All Statuses</option>
                            <option value="published" @selected(request('status') == 'published')>Published</option>
                            <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                            <option value="closed" @selected(request('status') == 'closed')>Closed</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Job Title')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Laravel" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" />
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Jobs Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Job Title</th>
                                <th class="p-4">Company</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Featured / Urgent</th>
                                <th class="p-4">Views / Apps</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($jobs as $job)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank" class="hover:underline">{{ $job->title }}</a>
                                        </div>
                                    </td>
                                    <td class="p-4">{{ $job->company->company_name }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded-full text-4xs font-black uppercase 
                                            @if($job->status === 'published') bg-emerald-100 text-emerald-850
                                            @elseif($job->status === 'draft') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-805
                                            @endif">
                                            {{ $job->status }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex gap-1.5 flex-wrap">
                                            <span class="px-2 py-0.5 rounded text-4xs font-bold {{ $job->featured ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-400' }}">
                                                Featured: {{ $job->featured ? 'Yes' : 'No' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded text-4xs font-bold {{ $job->urgent ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-400' }}">
                                                Urgent: {{ $job->urgent ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-gray-500">{{ $job->views_count }} / {{ $job->applications_count }}</td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                            <!-- Approve / Reject -->
                                            @if($job->status !== 'published')
                                                <form method="POST" action="{{ route('admin.jobs.approve', $job->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-650 font-bold rounded-lg text-4xs transition">Approve</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.jobs.reject', $job->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg text-4xs transition">Reject</button>
                                                </form>
                                            @endif

                                            <!-- Toggle Featured -->
                                            <form method="POST" action="{{ route('admin.jobs.feature', $job->id) }}">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-lg text-4xs transition">Featured</button>
                                            </form>

                                            <!-- Toggle Urgent -->
                                            <form method="POST" action="{{ route('admin.jobs.urgent', $job->id) }}">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-lg text-4xs transition">Urgent</button>
                                            </form>

                                            <!-- Delete -->
                                            <form method="POST" action="{{ route('admin.jobs.delete', $job->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure? This will delete the listing permanent.');" class="px-2 py-1 bg-red-500 hover:bg-red-655 text-white font-bold rounded-lg text-4xs transition">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No job listings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $jobs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
