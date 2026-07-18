<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Settings & Privacy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-950/30 border border-red-500/30 text-red-800 dark:text-red-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Update Password Form -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Manage Active Sessions -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <div class="max-w-xl space-y-6">
                    <header>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ __('Browser Sessions') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
                        </p>
                    </header>

                    @if(count($sessions) > 0)
                        <div class="space-y-4">
                            @foreach($sessions as $sess)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200/50 dark:border-gray-700/50">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $sess['ip_address'] }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-md">{{ $sess['user_agent'] }}</div>
                                            <div class="text-xs text-indigo-500 font-medium mt-0.5">Last active: {{ $sess['last_active'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <form method="POST" action="{{ route('settings.sessions.logout') }}" class="space-y-4 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                                @csrf
                                <div>
                                    <x-input-label for="password" :value="__('Confirm Password')" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Enter password to log out other devices" required />
                                </div>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
                                    Log Out Other Browser Sessions
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No other active device sessions found.</p>
                    @endif
                </div>
            </div>

            <!-- GDPR Personal Data Download -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border border-gray-100 dark:border-gray-700/50">
                <div class="max-w-xl space-y-4">
                    <header>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ __('Export Personal Data') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Download a complete record of your personal and professional profile details stored on this platform (GDPR JSON export format).') }}
                        </p>
                    </header>

                    <a href="{{ route('settings.download-data') }}" class="inline-block px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-650 text-gray-850 dark:text-white font-bold rounded-xl text-sm transition">
                        Download My Data (JSON)
                    </a>
                </div>
            </div>

            <!-- Soft Delete / Deactivate Account -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border border-red-500/20">
                <div class="max-w-xl space-y-6">
                    <header>
                        <h2 class="text-lg font-bold text-red-600 dark:text-red-400">
                            {{ __('Deactivate Account') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Soft delete your account. This will hide your profile and jobs applications from all employers. You can request to reactivate your account at any time.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('settings.deactivate') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="deactivate_password" :value="__('Confirm Password')" />
                            <x-text-input id="deactivate_password" name="deactivate_password" type="password" class="mt-1 block w-full" placeholder="Enter password to confirm deactivation" required />
                        </div>
                        <button type="submit" onclick="return confirm('Are you sure you want to deactivate your account?');" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition shadow-sm">
                            Deactivate My Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
