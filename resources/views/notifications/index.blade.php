<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('In-App Notification Center') }}
            </h2>
            <button type="button">
                Mark All as Read
            </button>
        </div>
    </x-slot>

    <div 
         x-data="{ 
            activeFilter: 'all', 
            loading: true,
            init() {
                setTimeout(() => this.loading = false, 400);
            }
         }"
    >
        <div>

            @if (session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Category Filter Pills -->
            <div>
                <button @click="activeFilter = 'all'" :>All Alerts</button>
                <button @click="activeFilter = 'application'" :>Applications</button>
                <button @click="activeFilter = 'interview'" :>Interviews</button>
                <button @click="activeFilter = 'system'" :>System Updates</button>
            </div>

            <!-- Loader Skeletons -->
            <div x-show="loading" x-transition>
                @for($s = 1; $s <= 3; $s++)
                    <div>
                        <div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div></div>
                    </div>
                @endfor
            </div>

            <!-- Notifications List -->
            <div x-show="!loading" x-transition>
                <div>
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
                        
                        <div x-show="activeFilter === 'all' || activeFilter === '{{ $category }}'">
                            <div>
                                <div>
                                    @if(!$notification->read())
                                        <span></span>
                                    @endif
                                    <h4>
                                        {{ $notification->data['title'] ?? 'System Update' }}
                                    </h4>
                                </div>
                                <p>
                                    {{ $notification->data['message'] ?? ($notification->data['body'] ?? '') }}
                                </p>
                                <span>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div>
                                @if(!$notification->read())
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">
                                            Mark Read
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div>
                            No notifications to display.
                        </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div>
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
