<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Account Settings & Privacy') }}
        </h2>
    </x-slot>

    <div x-data="{ activeTab: 'security' }">
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Navigation Settings Tabs -->
            <div>
                <button @click="activeTab = 'security'" :>Security & Sessions</button>
                <button @click="activeTab = 'privacy'" :>Privacy & GDPR</button>
                <button @click="activeTab = 'accounts'" :>Connected Accounts</button>
            </div>

            <!-- TAB: SECURITY & SESSIONS -->
            <div x-show="activeTab === 'security'" x-transition>
                <!-- Update Password Form -->
                <div>
                    <div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Manage Active Sessions -->
                <div>
                    <div>
                        <header>
                            <h2>
                                {{ __('Browser Sessions') }}
                            </h2>
                            <p>
                                {{ __('Manage and log out your active sessions on other browsers and devices.') }}
                            </p>
                        </header>

                        @if(count($sessions) > 0)
                            <div>
                                @foreach($sessions as $sess)
                                    <div>
                                        <div>
                                            <span>💻</span>
                                            <div>
                                                <div>{{ $sess['ip_address'] }}</div>
                                                <div>{{ $sess['user_agent'] }}</div>
                                                <div>Last active: {{ $sess['last_active'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <form method="POST" action="{{ route('settings.sessions.logout') }}">
                                    @csrf
                                    <div>
                                        <x-input-label for="password" :value="__('Confirm Password')" />
                                        <x-text-input id="password" name="password" type="password" placeholder="Enter password to log out other devices" required />
                                    </div>
                                    <button type="submit">
                                        Log Out Other Sessions
                                    </button>
                                </form>
                            </div>
                        @else
                            <p>No other active device sessions found.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB: PRIVACY & GDPR -->
            <div x-show="activeTab === 'privacy'" x-transition>
                <!-- GDPR Personal Data Download -->
                <div>
                    <div>
                        <header>
                            <h2>
                                {{ __('Export Personal Data') }}
                            </h2>
                            <p>
                                {{ __('Download a complete record of your profile details stored on this platform (GDPR JSON export format).') }}
                            </p>
                        </header>

                        <a href="{{ route('settings.download-data') }}">
                            Download My Data (JSON)
                        </a>
                    </div>
                </div>

                <!-- Soft Delete / Deactivate Account -->
                <div>
                    <div>
                        <header>
                            <h2>
                                {{ __('Deactivate Account') }}
                            </h2>
                            <p>
                                {{ __('Soft delete your account. This will hide your profile and jobs applications from all employers. You can request to reactivate your account at any time.') }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('settings.deactivate') }}">
                            @csrf
                            <div>
                                <x-input-label for="deactivate_password" :value="__('Confirm Password')" />
                                <x-text-input id="deactivate_password" name="deactivate_password" type="password" placeholder="Enter password to confirm deactivation" required />
                            </div>
                            <button type="submit" onclick="return confirm('Are you sure you want to deactivate your account?');">
                                Deactivate My Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TAB: CONNECTED ACCOUNTS -->
            <div x-show="activeTab === 'accounts'" x-transition>
                <header>
                    <h2>
                        {{ __('Connected Social Profiles') }}
                    </h2>
                    <p>
                        {{ __('Manage third-party integrations to sign in to your job board account.') }}
                    </p>
                </header>

                <div>
                    <div>
                        <div>
                            <span>🔵</span>
                            <div>
                                <h4>LinkedIn Sync</h4>
                                <p>Used for importing resume and work experience details.</p>
                            </div>
                        </div>
                        <button type="button">Linked</button>
                    </div>

                    <div>
                        <div>
                            <span>🔴</span>
                            <div>
                                <h4>Google Credentials</h4>
                                <p>Allows one-click auth logging in.</p>
                            </div>
                        </div>
                        <button type="button">Connect</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
