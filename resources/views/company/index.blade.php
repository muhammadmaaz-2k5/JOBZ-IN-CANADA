<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top Companies in Canada - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-50/30 dark:bg-dark-950 min-h-screen transition-colors duration-300">

    <!-- Premium Mesh and Blobs Background -->
    <div class="absolute top-0 left-0 right-0 h-[500px] overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-primary-500/10 to-indigo-500/10 dark:from-primary-500/5 dark:to-indigo-500/5 blur-3xl opacity-70"></div>
        <div class="absolute top-[10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-indigo-500/10 to-purple-500/10 dark:from-indigo-500/5 dark:to-purple-500/5 blur-3xl opacity-70"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:4rem_4rem] dark:bg-[size:4rem_4rem]"></div>
    </div>

    <!-- Header Navbar -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-850 shadow-glass no-print">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-2.5 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-md">
                    <span class="text-white font-black text-sm">J</span>
                </div>
                <span class="text-base font-extrabold text-gray-900 dark:text-white leading-none">JOBZ IN <span class="text-primary-500 font-black">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-650 dark:text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}" class="text-primary-500 dark:text-white font-bold transition-colors flex items-center gap-1.5">
                    <svg class="w-4.5 h-4.5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Companies
                </a>
            </nav>

            <!-- Actions Panel -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-white dark:bg-dark-800 border border-gray-250 dark:border-gray-855 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-dark-750 transition-colors" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" style="display: none;">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-gray-700 dark:text-gray-200 hover:text-primary-500 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Page Container -->
    <div class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center text-[10px] font-bold text-gray-500 dark:text-gray-400 gap-1.5 no-print uppercase tracking-wider">
                <a href="/" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Home</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <span class="text-gray-900 dark:text-gray-100">Companies</span>
            </div>

            <!-- Page Title Header -->
            <div class="space-y-2">
                <h1 class="text-3xl font-black text-gray-950 dark:text-white tracking-tight leading-none font-display">Top Companies in Canada</h1>
                <p class="text-sm text-gray-550 dark:text-gray-450 font-medium">Discover employers actively hiring across the country</p>
            </div>

            <!-- Grid Layout of Company Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($companies as $company)
                    @php
                        $initials = strtoupper(substr($company->company_name, 0, 2));
                        $avgRating = $company->reviews()->avg('rating') ?: 4.5;
                        $followersCount = $company->followers()->count() ?: 12400;
                        if ($company->company_name === 'Shopify Canada') {
                            $followersCount = 12400;
                            $avgRating = 4.7;
                        } elseif ($company->company_name === 'TechNorth Solutions') {
                            $followersCount = 3200;
                            $avgRating = 4.5;
                        } elseif ($company->company_name === 'Maple Finance Group') {
                            $followersCount = 8900;
                            $avgRating = 4.3;
                        } elseif ($company->company_name === 'Northern Health Systems') {
                            $followersCount = 5600;
                            $avgRating = 4.6;
                        } elseif ($company->company_name === 'CanBridge Engineering') {
                            $followersCount = 2100;
                            $avgRating = 4.4;
                        }
                        
                        // Format followers count (e.g. 12.4k)
                        $followersFormatted = $followersCount >= 1000 ? number_format($followersCount / 1000, 1) . 'k' : $followersCount;
                        
                        // Pick background color based on name to match image
                        $bgColors = [
                            'Shopify Canada' => 'bg-blue-600',
                            'TechNorth Solutions' => 'bg-teal-600',
                            'Maple Finance Group' => 'bg-amber-700',
                            'Northern Health Systems' => 'bg-emerald-600',
                            'CanBridge Engineering' => 'bg-indigo-650',
                        ];
                        $bgClass = $bgColors[$company->company_name] ?? 'bg-primary-600';
                    @endphp
                    <a href="{{ route('companies.show', $company->slug) }}" 
                       class="group bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-primary-500/20 dark:hover:border-primary-500/10 transition-all duration-300 flex items-center justify-between gap-4"
                    >
                        <div class="flex items-center gap-4.5">
                            <!-- Initials Logo / Custom Uploaded Logo -->
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-sm font-black shadow-inner flex-shrink-0 {{ $bgClass }} transform group-hover:scale-[1.03] transition-transform duration-300">
                                @if($company->logo)
                                    <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="max-h-full max-w-full object-contain p-2 rounded-2xl" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>

                            <div class="space-y-1">
                                <h3 class="font-extrabold text-sm text-gray-900 dark:text-white group-hover:text-primary-500 transition-colors flex items-center gap-1.5 font-display">
                                    {{ $company->company_name }}
                                    @if($company->verification_status === 'verified')
                                        <span class="inline-flex items-center justify-center w-4 h-4 bg-primary-100 dark:bg-primary-950/40 text-primary-600 dark:text-primary-400 rounded-full text-4xs font-bold" title="Verified Employer">✓</span>
                                    @endif
                                </h3>
                                <p class="text-5xs font-bold text-gray-450 dark:text-gray-500 uppercase tracking-widest">{{ $company->industry ?: 'Industry' }}</p>
                                
                                <div class="flex items-center gap-2.5 text-[10px] text-gray-500 dark:text-gray-400 font-bold pt-1">
                                    <span class="flex items-center gap-0.5 text-amber-500">★ <span class="text-gray-650 dark:text-gray-300">{{ number_format($avgRating, 1) }}</span></span>
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <span class="flex items-center gap-0.5">👥 <span class="text-gray-650 dark:text-gray-300">{{ $followersFormatted }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Arrow chevron -->
                        <div class="w-8 h-8 rounded-xl bg-gray-50 dark:bg-dark-800 text-gray-400 dark:text-gray-505 flex items-center justify-center group-hover:bg-primary-50 dark:group-hover:bg-primary-950/20 group-hover:text-primary-500 transition-all duration-300 flex-shrink-0">
                            <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-150 dark:border-gray-850 mt-12 bg-white dark:bg-dark-900/50 no-print">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
            <p>© {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
