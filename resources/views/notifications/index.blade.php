<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('In-App Notification Center') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-xl text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="divide-y divide-gray-100 dark:divide-gray-750">
                    @forelse ($notifications as $notification)
                        <div class="p-6 flex justify-between items-center gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-750/30 transition {{ $notification->read() ? 'opacity-60' : 'bg-indigo-50/10' }}">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    @if(!$notification->read())
                                        <span class="w-2 h-2 rounded-full bg-indigo-650 block"></span>
                                    @endif
                                    <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">
                                        {{ $notification->data['title'] ?? 'System Update' }}
                                    </h4>
                                </div>
                                <p class="text-xs text-gray-650 dark:text-gray-300">
                                    {{ $notification->data['message'] ?? ($notification->data['body'] ?? '') }}
                                </p>
                                <span class="text-3xs text-gray-400 font-bold block pt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                @if(!$notification->read())
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-indigo-650 hover:text-indigo-755 text-xs font-bold">
                                            Mark Read
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-750 text-xs font-bold">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-400 text-xs italic">
                            No notifications to display.
                        </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div class="p-6 border-t border-gray-100 dark:border-gray-750">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
