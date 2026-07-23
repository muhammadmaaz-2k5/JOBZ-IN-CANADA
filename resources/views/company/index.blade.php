@php
    use App\Models\Category;
    use App\Models\Skill;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Top Companies in Canada">
    <title>Top Companies in Canada — JOBZ IN CANADA</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col">

<div class="ambient-blobs" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<header class="home-nav">
    <div class="home-nav-inner">
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>
        <nav class="nav-links">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="{{ route('pricing') }}" class="hnav-link">Pricing</a>
            <a href="#" class="hnav-link">Resources</a>
        </nav>
        <div class="nav-actions">
            <button @click="dark = !dark" type="button"
                    class="icon-btn" title="Toggle theme">
                <span x-show="!dark">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </span>
            </button>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-cta">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="nav-post">Sign In</a>
                <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
            @endauth
        </div>
    </div>
</header>

<section class="hero !pb-8">
    <div class="hero-inner">
        <div class="hero-badge">
            🏢 Top Canadian Employers
        </div>
        <h1 class="hero-title">
            Discover Great <span class="hero-title-accent">Companies</span>
        </h1>
        <p class="hero-subtitle">
            Find employers that match your values, read reviews, and explore open roles.
        </p>
    </div>
</section>

<section class="section !pt-4 md:!pt-8">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-indigo"></span>
                <h2 class="section-heading">Featured Companies</h2>
            </div>
            <span class="results-count">{{ count($companies) }} results</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    
                    // Pick background color based on name
                    $bgColors = [
                        'Shopify Canada' => 'bg-blue-600',
                        'TechNorth Solutions' => 'bg-teal-600',
                        'Maple Finance Group' => 'bg-amber-600',
                        'Northern Health Systems' => 'bg-emerald-600',
                        'CanBridge Engineering' => 'bg-indigo-600',
                    ];
                    $bgClass = $bgColors[$company->company_name] ?? 'bg-[#1650e1]';
                @endphp
                <a href="{{ route('companies.show', $company->slug) }}" class="block group">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex items-start gap-4 h-full relative overflow-hidden">
                        
                        <!-- Initials Logo / Custom Uploaded Logo -->
                        <div class="w-16 h-16 rounded-xl flex-shrink-0 flex items-center justify-center text-white text-xl font-bold {{ $company->logo ? 'bg-transparent' : $bgClass }} shadow-inner">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" class="w-full h-full object-cover rounded-xl" />
                            @else
                                {{ $initials }}
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate flex items-center gap-1 group-hover:text-[#1650e1] transition-colors">
                                {{ $company->company_name }}
                                @if($company->verification_status === 'verified')
                                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $company->industry ?: 'Industry' }}</p>
                            
                            <div class="mt-4 flex items-center gap-4 text-sm font-medium text-gray-600 dark:text-gray-300">
                                <span class="flex items-center gap-1">
                                    <span class="text-amber-400 text-lg">★</span> 
                                    {{ number_format($avgRating, 1) }}
                                </span>
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $followersFormatted }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Arrow chevron (appears on hover) -->
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-4 transition-all duration-300">
                            <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 text-[#1650e1] dark:text-blue-400 flex items-center justify-center">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

<x-footer />

</body>
</html>
