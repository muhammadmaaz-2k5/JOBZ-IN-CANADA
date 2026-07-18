<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('System Audit Logs') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="action" :value="__('Filter By Action Key')" />
                        <input type="text" name="action" id="action" placeholder="e.g. user_suspended" value="{{ request('action') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" />
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Moderator Name')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Admin" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" />
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Audit Logs List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Action</th>
                                <th class="p-4">Performed By</th>
                                <th class="p-4">Description</th>
                                <th class="p-4">IP Address</th>
                                <th class="p-4">Date Performed</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-305 font-semibold">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-3xs font-black rounded-lg uppercase">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        {{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System / Guest' }}
                                    </td>
                                    <td class="p-4 text-gray-900 dark:text-white">{{ $log->description }}</td>
                                    <td class="p-4 font-mono text-gray-500">{{ $log->ip_address }}</td>
                                    <td class="p-4 text-gray-450">{{ $log->created_at->format('M d, Y - h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400 italic">No audit log records logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-750">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
