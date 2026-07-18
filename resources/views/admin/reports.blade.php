<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Abuse Moderation Queue') }}
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
                <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Report Status')" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                            <option value="">All Reports</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending Investigation</option>
                            <option value="reviewed" @selected(request('status') == 'reviewed')>Reviewed</option>
                            <option value="dismissed" @selected(request('status') == 'dismissed')>Dismissed</option>
                        </select>
                    </div>

                    <div class="flex items-end md:col-span-2">
                        <button type="submit" class="py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs px-6 transition shadow-sm">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reports List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Reported Job</th>
                                <th class="p-4">Employer Company</th>
                                <th class="p-4">Reported By</th>
                                <th class="p-4">Reason / Description</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($reports as $rep)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4">
                                        @if($rep->job)
                                            <div class="font-bold text-gray-900 dark:text-white">
                                                <a href="{{ route('jobs.show', $rep->job->slug) }}" target="_blank" class="hover:underline">{{ $rep->job->title }}</a>
                                            </div>
                                            <div class="text-4xs text-gray-450">ID: {{ $rep->job->id }}</div>
                                        @else
                                            <span class="text-gray-400 italic">Job Deleted</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        {{ $rep->job && $rep->job->company ? $rep->job->company->company_name : 'N/A' }}
                                    </td>
                                    <td class="p-4">{{ $rep->user->first_name }} {{ $rep->user->last_name }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded bg-red-100 text-red-800 text-4xs font-bold uppercase">{{ $rep->reason }}</span>
                                        <p class="text-3xs text-gray-500 mt-1 italic">"{{ $rep->description }}"</p>
                                    </td>
                                    <td class="p-4 uppercase text-3xs">{{ $rep->status }}</td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                            @if($rep->status === 'pending')
                                                <!-- Action Modals Trigger -->
                                                <button onclick="openActionModal({{ $rep->id }})" class="px-2.5 py-1.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-3xs transition shadow-sm">
                                                    Take Action
                                                </button>
                                            @else
                                                <span class="text-4xs text-gray-400 italic">Processed</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No abuse reports in queue.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $reports->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Moderation Action Modal container -->
    <div id="actionModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl max-w-sm w-full space-y-4 shadow-xl border border-gray-100 dark:border-gray-700">
            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Investigate & Resolve Report</h3>
            
            <form id="actionForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="mod_action" :value="__('Select Action')" />
                    <select name="action" id="mod_action" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                        <option value="dismiss">Dismiss Report (No Action)</option>
                        <option value="remove_content">Close & Hide Job Listing</option>
                        <option value="warn_employer">Warn Employer Profile</option>
                        <option value="ban_employer">Ban & Suspend Employer Account</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="mod_notes" :value="__('Moderator Notes')" />
                    <textarea name="notes" id="mod_notes" rows="3" placeholder="Specify reasons or investigation logs..." class="w-full text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303 rounded-xl mt-1"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2 text-xs">
                    <button type="button" onclick="closeActionModal()" class="px-4 py-2 border border-gray-250 dark:border-gray-750 text-gray-700 dark:text-gray-300 rounded-xl font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-755 text-white rounded-xl font-bold">Submit Action</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openActionModal(reportId) {
            const modal = document.getElementById('actionModal');
            const form = document.getElementById('actionForm');
            form.action = '/admin/reports/' + reportId + '/action';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
