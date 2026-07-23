<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JOBZ IN CANADA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Firebase Init -->
    <x-firebase-init />
</head>
<body class="bg-[#f8fafc] text-slate-800 selection:bg-[#1650e1] selection:text-white font-sans">
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Decorative Ambient Glows -->
        <div class="absolute top-0 -left-40 w-96 h-96 bg-[#1650e1]/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
        <div class="absolute top-0 -right-40 w-96 h-96 bg-amber-400/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse delay-75"></div>
        <div class="absolute -bottom-40 left-20 w-96 h-96 bg-indigo-400/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse delay-150"></div>

        <div class="w-full max-w-xl relative z-10">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#1650e1] to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-[#1650e1]/30 group-hover:scale-105 transition-transform">
                        <span>J</span>
                    </div>
                    <span class="text-2xl font-black tracking-tight text-gray-900">
                        JOBZ IN <span class="text-[#1650e1]">CANADA</span>
                    </span>
                </a>
            </div>

            <!-- Custom Elevated Card container -->
            <div class="bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-3xl p-8 sm:p-10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/40 to-white/10 pointer-events-none"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
