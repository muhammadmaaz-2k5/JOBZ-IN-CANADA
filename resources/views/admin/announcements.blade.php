<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Global Announcements Broadcast') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>
            
            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <div>
                    <h3>Broadcast In-App Notification Update</h3>
                    <p>Sends an immediate system notification alert directly into the notification widgets of every user registered on JOBZ IN CANADA.</p>
                </div>

                <form method="POST" action="{{ route('admin.announcements.broadcast') }}">
                    @csrf
                    <div>
                        <x-input-label for="title" :value="__('Announcement Title')" />
                        <input type="text" name="title" id="title" required placeholder="e.g. Planned Server Maintenance Notice" />
                    </div>

                    <div>
                        <x-input-label for="body" :value="__('Announcement Message')" />
                        <textarea name="body" id="body" required rows="6" placeholder="Write full broadcast alert text here..."></textarea>
                    </div>

                    <div>
                        <button type="submit" onclick="return confirm('Send announcement broadcast immediately to all users?');">
                            Broadcast Announcement
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
