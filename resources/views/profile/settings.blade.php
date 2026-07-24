<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tight relative z-10">
            {!! __('Account Settings & Privacy') !!}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10" x-data="{ activeTab: 'security' }">
        
        <!-- Decorative Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-400/10 blur-[120px]"></div>
            <div class="absolute top-[40%] -right-[10%] w-[40%] h-[60%] rounded-full bg-rose-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[40%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        <div class="space-y-8">

            @if(session('success'))
                <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 backdrop-blur-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-800 backdrop-blur-md shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Navigation Settings Tabs -->
            <div class="flex flex-wrap gap-2 p-2 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl rounded-[1.5rem] border border-slate-200/50 dark:border-slate-700/50 shadow-sm w-max">
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 font-bold hover:bg-white/50 dark:hover:bg-slate-800/50'" class="px-6 py-3 rounded-xl transition-all duration-300">Security & Sessions</button>
                <button @click="activeTab = 'privacy'" :class="activeTab === 'privacy' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 font-bold hover:bg-white/50 dark:hover:bg-slate-800/50'" class="px-6 py-3 rounded-xl transition-all duration-300">Privacy & GDPR</button>
                <button @click="activeTab = 'accounts'" :class="activeTab === 'accounts' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 font-bold hover:bg-white/50 dark:hover:bg-slate-800/50'" class="px-6 py-3 rounded-xl transition-all duration-300">Connected Accounts</button>
            </div>

            <!-- TAB: SECURITY & SESSIONS -->
            <div x-show="activeTab === 'security'" x-transition.opacity.duration.400ms class="space-y-8">
                <!-- Update Password Form -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 shadow-xl p-8 md:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Manage Active Sessions -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 shadow-xl p-8 md:p-10">
                    <div class="max-w-2xl">
                        <header class="mb-8">
                            <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                                {{ __('Browser Sessions') }}
                            </h2>
                            <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium">
                                {{ __('Manage and log out your active sessions on other browsers and devices. If necessary, you may log out of all of your other browser sessions across all of your devices.') }}
                            </p>
                        </header>

                        @if(count($sessions) > 0)
                            <div class="space-y-6">
                                <div class="grid gap-4">
                                @foreach($sessions as $sess)
                                    <div class="flex items-center gap-4 p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/50 dark:bg-slate-800/40 shadow-sm">
                                        <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                            💻
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 dark:text-white">{{ $sess['ip_address'] }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ $sess['user_agent'] }}</div>
                                            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-1">Last active: {{ $sess['last_active'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>

                                <form method="POST" action="{{ route('settings.sessions.logout') }}" class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700/50">
                                    @csrf
                                    <div class="max-w-md space-y-4">
                                        <div>
                                            <x-input-label for="password" :value="__('Confirm Password')" class="font-bold" />
                                            <x-text-input id="password" name="password" type="password" placeholder="Enter password to log out other devices" class="mt-2 block w-full rounded-xl" required />
                                        </div>
                                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 text-white font-bold rounded-xl transition-colors">
                                            Log Out Other Sessions
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 text-center text-slate-500 font-medium">
                                No other active device sessions found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB: PRIVACY & GDPR -->
            <div x-show="activeTab === 'privacy'" x-transition.opacity.duration.400ms style="display: none;" class="space-y-8">
                <!-- Soft Delete / Deactivate Account -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2.5rem] border border-rose-100 dark:border-rose-900/30 shadow-xl shadow-rose-900/5 p-8 md:p-10">
                    <div class="max-w-2xl">
                        <header class="mb-6">
                            <h2 class="text-2xl font-black text-rose-600 dark:text-rose-400">
                                {{ __('Deactivate Account') }}
                            </h2>
                            <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium">
                                {{ __('Soft delete your account. This will hide your profile and jobs applications from all employers. You can request to reactivate your account at any time by contacting support.') }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('settings.deactivate') }}" class="p-6 rounded-2xl bg-rose-50/50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/30">
                            @csrf
                            <div class="max-w-md space-y-4">
                                <div>
                                    <x-input-label for="deactivate_password" :value="__('Confirm Password')" class="text-rose-900 dark:text-rose-300 font-bold" />
                                    <x-text-input id="deactivate_password" name="deactivate_password" type="password" placeholder="Enter password to confirm deactivation" class="mt-2 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500" required />
                                </div>
                                <button type="submit" onclick="return confirm('Are you sure you want to deactivate your account?');" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                                    Deactivate My Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TAB: CONNECTED ACCOUNTS -->
            <div x-show="activeTab === 'accounts'" x-transition.opacity.duration.400ms style="display: none;" class="space-y-8">
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 shadow-xl p-8 md:p-10">
                    <header class="mb-8">
                        <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                            {{ __('Connected Social Profiles') }}
                        </h2>
                        <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium">
                            {{ __('Manage third-party integrations to sign in to your job board account.') }}
                        </p>
                    </header>

                    <div class="grid gap-6 max-w-2xl">
                        <!-- Google -->
                        <div class="flex items-center justify-between p-6 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/50 dark:bg-slate-800/40 shadow-sm">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl shrink-0">
                                    <svg class="w-6 h-6" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-lg">Google Credentials</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Allows one-click auth logging in.</p>
                                </div>
                            </div>
                            <button type="button" class="px-5 py-2.5 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 font-bold rounded-xl shadow-sm cursor-default flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        Connected
    </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>