<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="How JOBZ IN CANADA works">
    <title>How It Works — JOBZ IN CANADA</title>
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
            <a href="{{ route('pricing') }}" class="hnav-link">Pricing</a>
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
        <div class="text-center mt-8">
            <h2 class="section-heading">How JOBZINCANADA Works</h2>
            <p class="text-muted-sm m-0">Three simple steps to your next role</p>
        </div>

        <div class="step-grid mt-12">
            @php
                $steps = [
                    ['n'=>'1','title'=>'Create Your Profile',     'desc'=>'Sign up and build a professional profile. Upload your resume, skills, experience and preferences.', 'color'=>'#6366f1'],
                    ['n'=>'2','title'=>'Discover Opportunities',  'desc'=>'Search and filter thousands of verified Canadian jobs by role, location, salary and work type.', 'color'=>'#f43f5e'],
                    ['n'=>'3','title'=>'Apply & Get Hired',       'desc'=>'Apply with one click using your saved profile. Track your applications and land your dream job.', 'color'=>'#34d399'],
                ];
            @endphp
            @foreach($steps as $step)
                <div class="step-card">
                    <div class="step-row">
                        <div class="step-icon">
                            <span class="step-n">{{ $step['n'] }}</span>
                        </div>
                        <h3 class="step-title">{{ $step['title'] }}</h3>
                    </div>
                    <p class="step-desc">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-footer />

</body>
</html>
