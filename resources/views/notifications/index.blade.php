<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('In-App Notification Center') }}
            </h2>
            <button type="button" class="text-xs font-bold text-primary-500 hover:underline cursor-pointer">
                Mark All as Read
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" 
         x-data="{ 
            activeFilter: 'all', 
            loading: true,
            init() {
                setTimeout(() => this.loading = false, 400);
            }
         }"
    >
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 rounded-xl text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap gap-2.5 no-print">
                <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-primary-500 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100'" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition cursor-pointer">All Alerts</button>
                <button @click="activeFilter = 'application'" :class="activeFilter === 'application' ? 'bg-primary-500 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100'" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition cursor-pointer">Applications</button>
                <button @click="activeFilter = 'interview'" :class="activeFilter === 'interview' ? 'bg-primary-500 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100'" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition cursor-pointer">Interviews</button>
                <button @click="activeFilter = 'system'" :class="activeFilter === 'system' ? 'bg-primary-500 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100'" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider transition cursor-pointer">System Updates</button>
            </div>

            <!-- Loader Skeletons -->
            <div x-show="loading" class="space-y-4" x-transition>
                @for($s = 1; $s <= 3; $s++)
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-700/50 flex justify-between items-center gap-4 animate-pulse">
                        <div class="space-y-2 flex-1">
                            <div class="h-4 bg-gray-200 dark:bg-dark-700 rounded-md w-1/3"></div>
                            <div class="h-3 bg-gray-100 dark:bg-dark-805 rounded-md w-3/4"></div>
                            <div class="h-2 bg-gray-100 dark:bg-dark-805 rounded-md w-1/6 pt-1"></div>
                        </div>
                        <div class="w-12 h-6 bg-gray-100 dark:bg-dark-805 rounded-md"></div>
                    </div>
                @endfor
            </div>

            <!-- Notifications List -->
            <div x-show="!loading" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 overflow-hidden" x-transition style="display: none;">
                <div class="divide-y divide-gray-100 dark:divide-gray-750">
                    @forelse ($notifications as $notification)
                        @php
                            // Resolve the category of the notification to filter dynamically on client side
                            $title = strtolower($notification->data['title'] ?? '');
                            $category = 'system';
                            if (str_contains($title, 'apply') || str_contains($title, 'application')) {
                                $category = 'application';
                            } elseif (str_contains($title, 'interview') || str_contains($title, 'schedule')) {
                                $category = 'interview';
                            }
                        @endphp
                        
                        <div x-show="activeFilter === 'all' || activeFilter === '{{ $category }}'" 
                             class="p-6 flex justify-between items-center gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-750/30 transition {{ $notification->read() ? 'opacity-60' : 'bg-indigo-50/5' }}">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    @if(!$notification->read())
                                        <span class="w-2 h-2 rounded-full bg-primary-500 block"></span>
                                    @endif
                                    <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">
                                        {{ $notification->data['title'] ?? 'System Update' }}
                                    </h4>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    {{ $notification->data['message'] ?? ($notification->data['body'] ?? '') }}
                                </p>
                                <span class="text-4xs text-gray-400 font-bold block pt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                @if(!$notification->read())
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-primary-500 hover:text-primary-600 text-xs font-bold cursor-pointer">
                                            Mark Read
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-650 text-xs font-bold cursor-pointer">
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
