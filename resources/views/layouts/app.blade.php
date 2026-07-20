<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark', sidebarOpen: window.innerWidth >= 1024 }"
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50/50 dark:bg-dark-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Content Area -->
            <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden">
                <!-- Top Navbar Header -->
                <header class="glass sticky top-0 z-30 h-16 flex items-center justify-between px-6 border-b border-gray-100 dark:border-gray-850 shadow-glass">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-xl bg-white dark:bg-dark-800 border border-gray-150 dark:border-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-700 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        @isset($header)
                            <span class="text-sm md:text-base font-extrabold text-gray-900 dark:text-white leading-none">
                                {{ strip_tags($header) }}
                            </span>
                        @endisset
                    </div>

                    <!-- Actions Panel -->
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle Button -->
                        <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-dark-800 dark:hover:bg-dark-100 border border-gray-200/40 dark:border-gray-700/30 text-gray-700 dark:text-gray-300 transition-colors duration-200" title="Toggle Theme">
                            <span x-show="!dark">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="dark">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </span>
                        </button>

                        @auth
                            <div class="h-8 border-l border-gray-200 dark:border-gray-800"></div>
                            
                            <!-- Authentication Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-rose-500 hover:bg-rose-600 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        @endauth
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-6 md:p-8">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                @include('layouts.footer')
            </div>
        </div>
    </body>
</html>
