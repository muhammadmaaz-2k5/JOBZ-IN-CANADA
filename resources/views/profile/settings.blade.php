<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Settings & Privacy') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ activeTab: 'security' }">
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

            <!-- Navigation Settings Tabs -->
            <div class="flex gap-4 border-b border-gray-200 dark:border-gray-800 pb-2 text-sm font-bold text-gray-500 dark:text-gray-400 no-print">
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-850 dark:hover:text-white pb-2'" class="transition cursor-pointer">Security & Sessions</button>
                <button @click="activeTab = 'privacy'" :class="activeTab === 'privacy' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-850 dark:hover:text-white pb-2'" class="transition cursor-pointer">Privacy & GDPR</button>
                <button @click="activeTab = 'accounts'" :class="activeTab === 'accounts' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-850 dark:hover:text-white pb-2'" class="transition cursor-pointer">Connected Accounts</button>
            </div>

            <!-- TAB: SECURITY & SESSIONS -->
            <div x-show="activeTab === 'security'" class="space-y-6" x-transition>
                <!-- Update Password Form -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-150 dark:border-gray-700/50">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Manage Active Sessions -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-150 dark:border-gray-700/50">
                    <div class="max-w-xl space-y-6">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Browser Sessions') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Manage and log out your active sessions on other browsers and devices.') }}
                            </p>
                        </header>

                        @if(count($sessions) > 0)
                            <div class="space-y-4">
                                @foreach($sessions as $sess)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-dark-850 rounded-xl border border-gray-150 dark:border-gray-800/80">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xl">💻</span>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 font-mono">{{ $sess['ip_address'] }}</div>
                                                <div class="text-2xs text-gray-450 truncate max-w-md font-semibold">{{ $sess['user_agent'] }}</div>
                                                <div class="text-2xs text-primary-500 font-bold mt-0.5">Last active: {{ $sess['last_active'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <form method="POST" action="{{ route('settings.sessions.logout') }}" class="space-y-4 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="password" :value="__('Confirm Password')" />
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-xs font-semibold" placeholder="Enter password to log out other devices" required />
                                    </div>
                                    <button type="submit" class="px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold rounded-xl text-xs uppercase tracking-wider transition shadow-sm cursor-pointer">
                                        Log Out Other Sessions
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No other active device sessions found.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB: PRIVACY & GDPR -->
            <div x-show="activeTab === 'privacy'" class="space-y-6" x-transition style="display: none;">
                <!-- GDPR Personal Data Download -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-150 dark:border-gray-700/50">
                    <div class="max-w-xl space-y-4">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Export Personal Data') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Download a complete record of your profile details stored on this platform (GDPR JSON export format).') }}
                            </p>
                        </header>

                        <a href="{{ route('settings.download-data') }}" class="inline-block px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-650 text-gray-800 dark:text-white font-bold rounded-xl text-xs uppercase tracking-wider transition">
                            Download My Data (JSON)
                        </a>
                    </div>
                </div>

                <!-- Soft Delete / Deactivate Account -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-red-500/20">
                    <div class="max-w-xl space-y-6">
                        <header>
                            <h2 class="text-lg font-bold text-red-650">
                                {{ __('Deactivate Account') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Soft delete your account. This will hide your profile and jobs applications from all employers. You can request to reactivate your account at any time.') }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('settings.deactivate') }}" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="deactivate_password" :value="__('Confirm Password')" />
                                <x-text-input id="deactivate_password" name="deactivate_password" type="password" class="mt-1 block w-full text-xs font-semibold" placeholder="Enter password to confirm deactivation" required />
                            </div>
                            <button type="submit" onclick="return confirm('Are you sure you want to deactivate your account?');" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-xl text-xs uppercase tracking-wider transition shadow-sm cursor-pointer">
                                Deactivate My Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TAB: CONNECTED ACCOUNTS -->
            <div x-show="activeTab === 'accounts'" class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition style="display: none;">
                <header class="border-b border-gray-100 dark:border-gray-700 pb-3">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ __('Connected Social Profiles') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Manage third-party integrations to sign in to your job board account.') }}
                    </p>
                </header>

                <div class="space-y-4 text-xs font-bold">
                    <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🔵</span>
                            <div>
                                <h4 class="text-sm font-extrabold text-gray-800 dark:text-gray-200">LinkedIn Sync</h4>
                                <p class="text-2xs text-gray-400 font-semibold mt-0.5">Used for importing resume and work experience details.</p>
                            </div>
                        </div>
                        <button type="button" class="px-3.5 py-1.5 bg-emerald-500 text-white rounded-lg text-3xs font-extrabold cursor-pointer uppercase">Linked</button>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800/80">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🔴</span>
                            <div>
                                <h4 class="text-sm font-extrabold text-gray-800 dark:text-gray-200">Google Credentials</h4>
                                <p class="text-2xs text-gray-400 font-semibold mt-0.5">Allows one-click auth logging in.</p>
                            </div>
                        </div>
                        <button type="button" class="px-3.5 py-1.5 bg-gray-150 dark:bg-dark-800 text-gray-700 dark:text-gray-300 rounded-lg text-3xs font-extrabold cursor-pointer uppercase">Connect</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
