<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark', sidebarOpen: window.innerWidth >= 1024 }"
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        
        

        <!-- Scripts -->
        
    </head>
    <body>
        <div>
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Content Area -->
            <div>
                <!-- Top Navbar Header -->
                <header>
                    <div>
                        <button @click="sidebarOpen = !sidebarOpen">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        @isset($header)
                            <span>
                                {{ strip_tags($header) }}
                            </span>
                        @endisset
                    </div>

                    <!-- Actions Panel -->
                    <div>
                        <!-- Dark Mode Toggle Button -->
                        <button @click="dark = !dark" type="button" title="Toggle Theme">
                            <span x-show="!dark">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="dark">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </span>
                        </button>

                        @auth
                            <div></div>
                            
                            <!-- Authentication Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    Sign Out
                                </button>
                            </form>
                        @endauth
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>

                <!-- Footer -->
                @include('layouts.footer')
            </div>
        </div>
    </body>
</html>
