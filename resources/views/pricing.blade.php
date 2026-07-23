<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing — JOBZ IN CANADA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Scripts/Styles -->
    @vite('resources/js/app.js')
</head>
<body class="antialiased bg-[#f8fafc] text-slate-800 transition-colors duration-300" x-data="{ dark: false }" :class="{'dark bg-slate-900 text-slate-100': dark}">

<!-- Ambient Background Blobs -->
<div class="ambient-blobs" aria-hidden="true">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

{{-- ══════════════════════════════════════
     NAVBAR
══════════════════════════════════════ --}}
<header class="home-nav">
    <div class="home-nav-inner">
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>

        <!-- Desktop Nav -->
        <nav class="nav-links">
            <a href="{{ route('home') }}" class="hnav-link">Home</a>
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="{{ route('pricing') }}" class="hnav-link font-semibold text-[#1650e1]">Pricing</a>
        </nav>

        <!-- Actions -->
        <div class="nav-actions">
            <button @click="dark = !dark" type="button" class="icon-btn" title="Toggle theme">
                <span x-show="!dark">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark" x-cloak>
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
            </button>
            <a href="{{ route('register') }}" class="nav-post">
                Post a Job
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-login">Sign In</a>
                <a href="{{ route('register') }}" class="nav-register">Register</a>
            @endauth
        </div>
    </div>
</header>

{{-- ══════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════ --}}
<main class="relative z-10 pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen" x-data="{ annual: true }">
    
    <!-- Hero Section -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6">
            Simple, transparent <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1650e1] to-indigo-500">pricing</span>
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300">
            Whether you're hiring for one role or scaling your entire team, we have a plan that fits your needs.
        </p>

        <!-- Toggle Switch -->
        <div class="mt-10 flex items-center justify-center gap-4">
            <span class="text-sm font-medium" :class="!annual ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">Monthly</span>
            <button type="button" 
                    @click="annual = !annual"
                    class="relative inline-flex h-8 w-16 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#1650e1] focus:ring-offset-2" 
                    :class="annual ? 'bg-[#1650e1]' : 'bg-gray-300 dark:bg-gray-600'">
                <span class="sr-only">Use setting</span>
                <span aria-hidden="true" 
                      class="pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" 
                      :class="annual ? 'translate-x-8' : 'translate-x-0'"></span>
            </button>
            <span class="text-sm font-medium" :class="annual ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                Annually <span class="ml-1.5 inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Save 20%</span>
            </span>
        </div>
    </div>

    <!-- Pricing Cards Grid -->
    <div class="grid lg:grid-cols-3 gap-8 max-w-7xl mx-auto items-center">
        
        <!-- Basic Plan -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Starter</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Perfect for small businesses making their first hires.</p>
            <div class="mb-6">
                <span class="text-5xl font-extrabold text-gray-900 dark:text-white">$<span x-text="annual ? '0' : '0'"></span></span>
                <span class="text-gray-500 dark:text-gray-400 font-medium">/mo</span>
            </div>
            <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white font-bold text-center rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors mb-8">
                Get Started Free
            </a>
            <ul class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    1 Active Job Posting
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Standard Visibility
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Basic Company Profile
                </li>
                <li class="flex items-center gap-3 text-gray-400 dark:text-gray-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Applicant Tracking
                </li>
            </ul>
        </div>

        <!-- Pro Plan (Highlighted) -->
        <div class="bg-[#1650e1] rounded-3xl p-8 border border-blue-500 shadow-2xl shadow-blue-500/30 transform lg:-translate-y-4 relative">
            <div class="absolute top-0 right-6 transform -translate-y-1/2">
                <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold uppercase tracking-wider py-1 px-3 rounded-full shadow-lg">Most Popular</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Professional</h3>
            <p class="text-blue-100 text-sm mb-6">For growing companies hiring multiple roles.</p>
            <div class="mb-6">
                <span class="text-5xl font-extrabold text-white">$<span x-text="annual ? '39' : '49'"></span></span>
                <span class="text-blue-200 font-medium">/mo</span>
            </div>
            <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-white text-[#1650e1] font-bold text-center rounded-xl hover:bg-gray-50 transition-colors mb-8 shadow-md">
                Start 14-Day Free Trial
            </a>
            <ul class="space-y-4 text-sm text-blue-50">
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Up to 10 Active Job Postings
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Highlighted Listings
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Verified Company Badge
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Advanced Applicant Tracking
                </li>
            </ul>
        </div>

        <!-- Enterprise Plan -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 border border-gray-200 dark:border-gray-700 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Enterprise</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">For large scale recruitment and agencies.</p>
            <div class="mb-6">
                <span class="text-5xl font-extrabold text-gray-900 dark:text-white">$<span x-text="annual ? '159' : '199'"></span></span>
                <span class="text-gray-500 dark:text-gray-400 font-medium">/mo</span>
            </div>
            <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white font-bold text-center rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors mb-8">
                Contact Sales
            </a>
            <ul class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Unlimited Job Postings
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Premium Top-of-page Placement
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Dedicated Account Manager
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    API Access & Integrations
                </li>
            </ul>
        </div>
    </div>
</main>

{{-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ --}}
<footer class="home-footer mt-auto">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="brand">
                    <div class="brand-icon">J</div>
                    <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
                </div>
                <p class="brand-desc">
                    Canada's premier job board connecting top talent with leading employers nationwide.
                </p>
                <div class="contact-info">
                    <p>📍 250 Yonge St, Toronto, ON</p>
                    <p>✉️ support@jobzincanada.ca</p>
                </div>
            </div>
            <div class="footer-links">
                <div>
                    <h4>Quick Links</h4>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('companies.index') }}">Verified Companies</a>
                    <a href="{{ route('pricing') }}">Pricing Plans</a>
                </div>
                <div>
                    <h4>Candidates</h4>
                    <a href="{{ route('jobs.index') }}">Browse Jobs</a>
                    <a href="#">Career Advice</a>
                    <a href="#">Salary Guide</a>
                </div>
                <div>
                    <h4>Employers</h4>
                    <a href="{{ route('register') }}">Post a Job</a>
                    <a href="{{ route('pricing') }}">Pricing</a>
                    <a href="#">Talent Search</a>
                </div>
            </div>
            <div class="footer-social">
                <h4>Connect</h4>
                <div class="social-icons">
                    <a href="#">LN</a>
                    <a href="#">TW</a>
                    <a href="#">FB</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div class="legal-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
