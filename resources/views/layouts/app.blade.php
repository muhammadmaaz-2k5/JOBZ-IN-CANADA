<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Firebase Init -->
    <x-firebase-init />
</head>
<body class="bg-gray-50 dark:bg-[#0b1120] text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
    <div class="min-h-screen flex w-full">
        <!-- Sidebar Navigation -->
        @include('layouts.sidebar')

        <!-- Content Area -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 lg:pl-72" :class="sidebarOpen ? 'lg:pl-72' : 'lg:pl-0'">
            <!-- Top Navbar Header -->
            <header class="bg-white/80 dark:bg-[#0f172a]/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 sticky top-0 z-30 px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between shadow-sm transition-all duration-300">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 focus:outline-none transition-colors lg:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    @isset($header)
                        <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight hidden sm:block">
                            {{ strip_tags($header) }}
                        </span>
                    @endisset
                </div>

                <!-- Actions Panel -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="hidden sm:flex items-center gap-3 pr-4 border-r border-gray-200 dark:border-gray-700">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(Auth::user()->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex flex-col text-sm">
                                <span class="font-bold text-gray-900 dark:text-white leading-tight">{{ Auth::user()->first_name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Online</span>
                            </div>
                        </div>
                        
                        <!-- Authentication Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-xl text-gray-600 bg-gray-100 hover:bg-rose-50 hover:text-rose-600 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-rose-900/30 dark:hover:text-rose-400 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                <span class="hidden sm:inline">Sign Out</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden">
                {{ $slot }}
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
