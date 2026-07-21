@if(session()->has('impersonator_id'))
    <div>
        <span>⚠️ You are currently impersonating another user.</span>
        <form method="POST" action="{{ route('admin.impersonate.revert') }}">
            @csrf
            <button type="submit">
                Revert to Admin
            </button>
        </form>
    </div>
@endif

<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div>
        <div>
            <div>
                <!-- Logo -->
                <div>
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Users') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.companies.index')" :active="request()->routeIs('admin.companies.*')">
                                {{ __('Companies') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.jobs.index')" :active="request()->routeIs('admin.jobs.*')">
                                {{ __('Jobs') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                                {{ __('Reports') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                {{ __('Categories') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.coupons.index')" :active="request()->routeIs('admin.coupons.*')">
                                {{ __('Coupons') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.revenue-analytics.index')" :active="request()->routeIs('admin.revenue-analytics.*')">
                                {{ __('Revenue') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div>
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button>
                            <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>

                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->hasRole('job_seeker'))
                            <x-dropdown-link :href="route('seeker.profile.edit')">
                                {{ __('My Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('seeker.boost.index')">
                                {{ __('Boost Profile') }}
                            </x-dropdown-link>
                        @elseif(Auth::user()->hasRole('employer'))
                            <x-dropdown-link :href="route('employer.profile.edit')">
                                {{ __('Company Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('employer.billing.index')">
                                {{ __('Billing & Plans') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('settings.edit')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <div>
                    <a href="{{ route('login') }}">Log In</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div>
                <button @click="open = ! open">
                    <svg stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path : stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path : stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :>
        <div>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div>
            <div>
                <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                <div>{{ Auth::user()->email }}</div>
            </div>

            <div>
                @if(Auth::user()->hasRole('job_seeker'))
                    <x-responsive-nav-link :href="route('seeker.profile.edit')">
                        {{ __('My Profile') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('employer'))
                    <x-responsive-nav-link :href="route('employer.profile.edit')">
                        {{ __('Company Profile') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('settings.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div>
            <x-responsive-nav-link :href="route('login')">{{ __('Log In') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
        </div>
        @endauth
    </div>
</nav>
