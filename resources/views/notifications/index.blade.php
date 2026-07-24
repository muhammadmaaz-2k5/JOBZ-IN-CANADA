<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
            <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tight">
                {{ __('In-App Notification Center') }}
            </h2>
            <form method="POST" action="#">
                <!-- Assuming mark all as read route doesn't exist yet, but styling the button anyway -->
                <button type="button" class="px-5 py-2.5 bg-blue-600/10 hover:bg-blue-600 text-blue-700 dark:text-blue-400 hover:text-white dark:hover:text-white rounded-xl font-bold transition-all duration-300 backdrop-blur-md border border-blue-600/20 shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Mark All as Read
                </button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10"
         x-data="{ 
            activeFilter: 'all', 
            loading: true,
            init() {
                setTimeout(() => this.loading = false, 400);
            }
         }"
    >
        <!-- Decorative Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-400/10 blur-[120px]"></div>
            <div class="absolute top-[40%] -right-[10%] w-[40%] h-[60%] rounded-full bg-purple-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[40%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        <div class="space-y-8">

            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 backdrop-blur-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap gap-3 pb-2">
                <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-[#1650e1] text-white shadow-md' : 'bg-white/60 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700'" class="px-6 py-2.5 rounded-xl font-bold transition-all duration-300 backdrop-blur-md border border-slate-200 dark:border-slate-700/50">All Alerts</button>
                <button @click="activeFilter = 'application'" :class="activeFilter === 'application' ? 'bg-[#1650e1] text-white shadow-md' : 'bg-white/60 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700'" class="px-6 py-2.5 rounded-xl font-bold transition-all duration-300 backdrop-blur-md border border-slate-200 dark:border-slate-700/50">Applications</button>
                <button @click="activeFilter = 'system'" :class="activeFilter === 'system' ? 'bg-[#1650e1] text-white shadow-md' : 'bg-white/60 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700'" class="px-6 py-2.5 rounded-xl font-bold transition-all duration-300 backdrop-blur-md border border-slate-200 dark:border-slate-700/50">System Updates</button>
            </div>

            <!-- Loader Skeletons -->
            <div x-show="loading" x-transition.opacity.duration.300ms class="space-y-4">
                @for($s = 1; $s <= 3; $s++)
                    <div class="p-6 rounded-[2rem] bg-white/40 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-sm animate-pulse flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-700 shrink-0"></div>
                        <div class="flex-1 space-y-3 py-1">
                            <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-1/4"></div>
                            <div class="h-3 bg-slate-200 dark:bg-slate-700 rounded w-3/4"></div>
                            <div class="h-3 bg-slate-200 dark:bg-slate-700 rounded w-1/2"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Notifications List -->
            <div x-show="!loading" x-transition.opacity.duration.500ms style="display: none;">
                <div class="space-y-4">
                    @forelse ($notifications as $notification)
                        @php
                            $title = strtolower($notification->data['title'] ?? '');
                            $category = 'system';
                            if (str_contains($title, 'apply') || str_contains($title, 'application')) {
                                $category = 'application';
                            }
                        @endphp
                        
                        <div x-show="activeFilter === 'all' || activeFilter === '{{ $category }}'" x-transition 
                             class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 rounded-[2rem] border border-white/60 dark:border-slate-700/50 bg-white/70 dark:bg-slate-800/70 backdrop-blur-2xl shadow-xl shadow-slate-200/20 dark:shadow-none hover:-translate-y-1 hover:shadow-2xl hover:border-blue-500/30 transition-all duration-300 gap-6">
                            
                            <div class="flex gap-4 items-start w-full sm:w-auto">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 ring-4 ring-blue-100 dark:ring-blue-800/40">
                                    @if($category === 'application')
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                        {{ $notification->data['title'] ?? 'System Update' }}
                                        @if(!$notification->read())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">New</span>
                                        @endif
                                    </h4>
                                    <p class="text-slate-600 dark:text-slate-400 font-medium mt-1 leading-relaxed">
                                        {{ $notification->data['message'] ?? ($notification->data['body'] ?? '') }}
                                    </p>
                                    <span class="text-sm text-slate-400 dark:text-slate-500 font-semibold mt-2 block flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full sm:w-auto mt-4 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-0 border-slate-100 dark:border-slate-700/50">
                                @if(!$notification->read())
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="flex-1 sm:flex-none">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-bold rounded-xl transition-colors">
                                            Mark Read
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" class="flex-1 sm:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 font-bold rounded-xl transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 rounded-[2.5rem] border border-dashed border-slate-300 dark:border-slate-700 bg-white/50 dark:bg-slate-800/30 backdrop-blur-xl flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-6">
                                <span class="text-4xl">📭</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">You're all caught up!</h3>
                            <p class="text-slate-500 dark:text-slate-400 font-medium max-w-sm">No new notifications to display right now. Check back later for updates.</p>
                        </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div class="mt-8">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>