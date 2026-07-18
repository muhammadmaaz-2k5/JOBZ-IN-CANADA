<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Global Announcements Broadcast') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-6">
                <div>
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Broadcast In-App Notification Update</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">Sends an immediate system notification alert directly into the notification widgets of every user registered on JOBZ IN CANADA.</p>
                </div>

                <form method="POST" action="{{ route('admin.announcements.broadcast') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="title" :value="__('Announcement Title')" />
                        <input type="text" name="title" id="title" required placeholder="e.g. Planned Server Maintenance Notice" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs shadow-sm" />
                    </div>

                    <div>
                        <x-input-label for="body" :value="__('Announcement Message')" />
                        <textarea name="body" id="body" required rows="6" placeholder="Write full broadcast alert text here..." class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303 rounded-xl text-xs shadow-sm"></textarea>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" onclick="return confirm('Send announcement broadcast immediately to all users?');" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-extrabold rounded-xl text-xs transition shadow shadow-indigo-500/10">
                            Broadcast Announcement
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
