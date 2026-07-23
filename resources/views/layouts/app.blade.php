<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
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
