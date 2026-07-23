<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Why choose JOBZ IN CANADA">
    <title>Why Choose Us — JOBZ IN CANADA</title>
    @vite('resources/js/app.js')
</head>
<body>

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
            <button class="icon-btn" title="Search">
                <svg width=".9rem" height=".9rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            <a href="{{ route('register') }}" class="nav-post">
                Sign In
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
            @endauth
        </div>
    </div>
</header>

<section class="section" style="min-height: 70vh; padding-top: 60px;">
    <div class="section-inner">
        <div class="portal-card portal-card-candidate">
            <div class="portal-card-glow portal-glow-candidate"></div>

            <div class="why-inner">
                {{-- Left text --}}
                <div class="why-visual">
                    <h2 class="why-title">Why choose JOBZINCANADA?</h2>
                    <p class="why-desc">
                        Built with candidates and local employers in mind. Trusted by thousands of Canadians every month.
                    </p>
                    <a href="{{ route('register') }}" class="why-link">
                        Get Started Free &rarr;
                    </a>
                </div>

                {{-- Right features --}}
                <div class="why-features">
                    @php
                        $whys = [
                            ['icon'=>'✔️','title'=>'Verified Employers',    'desc'=>'All job posts are double-checked for corporate credentials.'],
                            ['icon'=>'📍','title'=>'Canada-Wide Positions', 'desc'=>'Remote roles plus local jobs in Toronto, Vancouver & Montreal.'],
                            ['icon'=>'💵','title'=>'Salary Transparency',   'desc'=>'See salary ranges and full benefits before applying.'],
                        ];
                    @endphp
                    @foreach($whys as $w)
                        <div class="why-feature">
                            <div class="why-feature-icon">{{ $w['icon'] }}</div>
                            <div class="why-feature-title">{{ $w['title'] }}</div>
                            <div class="why-feature-desc">{{ $w['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<x-footer />

</body>
</html>
