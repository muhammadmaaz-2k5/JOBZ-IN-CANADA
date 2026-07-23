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
    <meta name="description" content="Browse verified Canadian jobs. Filter by location, salary, and work type.">
    <title>Find Jobs — JOBZ IN CANADA</title>
    @vite('resources/js/app.js')
</head>
<body>

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
            <a href="#" class="hnav-link">Pricing</a>
            <a href="#" class="hnav-link">Resources</a>
        </nav>
        <div class="nav-actions">
            <button @click="dark = !dark" type="button"
                    class="icon-btn" title="Toggle theme">
                <span x-show="!dark" class="icon-svg">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark" class="icon-svg">
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

<section class="hero">
    <div class="hero-inner">
        <div class="hero-badge">
            🍁 Explore active listings across Canada
        </div>
        <h1 class="hero-title">
            Find Your <span class="hero-title-accent">Dream Career</span>
        </h1>
        <p class="hero-subtitle">
            Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds.
        </p>
        <form method="GET" action="{{ route('jobs.index') }}" class="search-form">
            <div class="search-input-wrap">
                <svg class="icon-svg text-indigo" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="keyword" placeholder="Job title, keywords, or company..."
                       value="{{ request('keyword') }}" class="search-input">
            </div>
            <div class="search-divider"></div>
            <div class="search-input-wrap">
                <svg class="icon-svg text-rose" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="location" placeholder="City, province, or Remote..."
                       value="{{ request('location') }}" class="search-input">
            </div>
            <div class="search-actions">
                <select name="sort" class="search-select">
                    <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                    <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                    <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                    <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                </select>
                <button type="submit" class="search-btn">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
            </div>
        </form>
    </div>
</section>

<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-indigo"></span>
                <h2 class="section-heading">Browse Jobs</h2>
            </div>
            <span class="results-count">{{ $jobs->total() }} results</span>
        </div>
        <div class="recent-grid">
            @forelse($jobs as $job)
                <x-job-card :job="$job" />
            @empty
                <x-empty-state title="No Job Listings Found" subtitle="Try clearing search inputs, broadening keyword terms, or selecting different locations." icon="🔍" />
            @endforelse
        </div>
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
    </div>
</section>

{{-- RECENTLY VIEWED --}}
@if(count($recentlyViewed) > 0)
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-amber"></span>
                <h2 class="section-heading">Recently Viewed</h2>
            </div>
        </div>
        <div class="recent-grid">
            @foreach($recentlyViewed as $viewedJob)
                <x-job-card :job="$viewedJob" :compact="true" />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-footer />

</body>
</html>
