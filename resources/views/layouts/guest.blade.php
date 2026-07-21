<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
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
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50/50 dark:bg-dark-950 min-h-screen transition-colors duration-300">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-gradient-to-tr from-gray-50 via-white to-primary-50/20 dark:from-dark-950 dark:via-dark-950 dark:to-primary-950/10 relative overflow-hidden">
            <!-- Decorative Ambient Glows -->
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-primary-500/5 dark:bg-primary-500/3 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] rounded-full bg-accent-500/5 dark:bg-accent-500/3 blur-3xl pointer-events-none"></div>

            <div class="w-full max-w-md relative z-10 flex flex-col items-center">
                <!-- Logo -->
                <div class="mb-8">
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg shadow-primary-500/20">
                            <span class="text-white font-black text-xl">J</span>
                        </div>
                        <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none">
                            JOBZ <span class="text-primary-500 font-extrabold">CA</span>
                        </span>
                    </a>
                </div>

                <!-- Custom Elevated Card container -->
                <x-card variant="elevated" padding="lg" class="w-full shadow-2xl relative border border-gray-150/60 dark:border-gray-800">
                    <!-- Absolute Theme Toggle inside Auth layout for user convenience -->
                    <div class="absolute top-4 right-4 z-20">
                        <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-gray-50 hover:bg-gray-150 dark:bg-gray-800 dark:hover:bg-gray-700 border border-gray-200/50 dark:border-gray-700/50 text-gray-500 dark:text-gray-400 transition" title="Toggle Theme">
                            <span x-show="!dark">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="dark">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    {{ $slot }}
                </x-card>
            </div>
        </div>
    </body>
</html>

