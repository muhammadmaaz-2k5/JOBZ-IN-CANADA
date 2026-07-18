<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Company Review Moderation') }}
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

            <!-- Reviews List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Company</th>
                                <th class="p-4">User</th>
                                <th class="p-4">Rating</th>
                                <th class="p-4">Title / Review content</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($reviews as $rev)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $rev->company->company_name }}</td>
                                    <td class="p-4">{{ $rev->user->first_name }} {{ $rev->user->last_name }}</td>
                                    <td class="p-4 text-amber-500 font-bold">
                                        @for($i=1;$i<=5;$i++)
                                            {{ $i <= $rev->rating ? '★' : '☆' }}
                                        @endfor
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">"{{ $rev->title }}"</div>
                                        <p class="text-3xs text-gray-500 italic mt-0.5">"{{ $rev->review }}"</p>
                                    </td>
                                    <td class="p-4 text-right">
                                        <!-- Actions (Delete) -->
                                        <form method="POST" action="{{ route('admin.reviews.status', $rev->id) }}">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Remove review permanent?');" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold rounded-xl text-3xs transition">
                                                Delete Review
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400 italic">No company reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-750">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
