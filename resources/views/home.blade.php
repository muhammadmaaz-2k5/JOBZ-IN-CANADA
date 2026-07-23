@php
    try {
        $featuredJobs = \App\Models\Job::with(['company', 'skills', 'screeningQuestions'])
            ->where('status', 'published')->where('featured', true)->latest()->take(4)->get();
        if ($featuredJobs->count() < 4) {
            $extra = \App\Models\Job::with(['company', 'skills', 'screeningQuestions'])
                ->where('status', 'published')->where('featured', false)
                ->latest()->take(4 - $featuredJobs->count())->get();
            $featuredJobs = $featuredJobs->concat($extra);
        }
        $recentJobs = \App\Models\Job::with(['company', 'skills', 'screeningQuestions'])
            ->where('status', 'published')->latest()->take(6)->get();
        if ($recentJobs->count() > 0 && $recentJobs->count() < 6) {
            $needed = 6 - $recentJobs->count();
            for ($i = 0; $i < $needed; $i++) {
                $recentJobs->push($recentJobs[$i % $recentJobs->count()]);
            }
        }
        $companies  = \App\Models\Company::with('jobs')->where('verification_status', 'verified')->latest()->take(5)->get();
        $jobsCount  = \App\Models\Job::where('status', 'published')->count();
    } catch (\Throwable $e) {
        $featuredJobs = collect(); $recentJobs = collect(); $companies = collect(); $jobsCount = 0;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: true }"
      x-init="
        if(localStorage.getItem('theme') !== null){ dark = localStorage.getItem('theme') === 'dark'; }
        $watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));
      "
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Canada's premier job board. Find verified jobs from top Canadian employers.">
    <title>JOBZ IN CANADA — Find Your Dream Job</title>
    @vite('resources/js/app.js')
</head>
<body>

{{-- ══════════════════════════════════════
     AMBIENT BLOBS
══════════════════════════════════════ --}}
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

        {{-- Brand --}}
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="nav-links">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="#" class="hnav-link">Pricing</a>
            <a href="#" class="hnav-link">Resources</a>
        </nav>

        {{-- Actions --}}
        <div class="nav-actions">
            {{-- Search icon --}}
            <button class="icon-btn" title="Search">
                <svg width=".9rem" height=".9rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- Theme toggle --}}
            <button @click="dark = !dark" type="button" class="icon-btn" title="Toggle theme">
                <span x-show="!dark" class="icon-wrap">
                    <svg width=".9rem" height=".9rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark" class="icon-wrap">
                    <svg width=".9rem" height=".9rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2 5 0 11-5 0 2.5 2 5 0 015 0z"/>
                    </svg>
                </span>
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

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section class="hero">
    <div class="hero-inner">

        {{-- Pill --}}
        <div class="hero-badge">
            🇨🇦 Canada Wide Jobs &bull;
            <span class="text-white font-bold">{{ $jobsCount > 0 ? number_format($jobsCount) : '12,480' }}+</span>
            Active Roles
        </div>

        {{-- H1 --}}
        <h1 class="hero-title">
            Find your dream job<br>
            in <span class="hero-title-accent">Canada</span>
        </h1>

        <p class="hero-subtitle">
            Discover thousands of exciting opportunities from Canada's top verified employers.
            Transparent salaries, remote options &amp; one-click applications.
        </p>

        {{-- Search bar --}}
        <form class="search-form" action="{{ route('jobs.index') }}" method="GET">

            {{-- What --}}
            <div class="search-input-wrap">
                <svg width="1rem" height="1rem" class="text-indigo" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" class="search-input" placeholder="Job title, keywords or company...">
            </div>

            <div class="search-divider"></div>

            {{-- Where --}}
            <div class="search-input-wrap">
                <svg width="1rem" height="1rem" class="text-rose" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="location" class="search-input" placeholder="City, province or Remote...">
            </div>

            {{-- Button --}}
            <div class="search-actions">
                <button type="submit" class="search-btn">
                    <svg width=".875rem" height=".875rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
            </div>
        </form>

        {{-- Popular tags --}}
        <div class="popular-chips">
            <span class="popular-label">Popular:</span>
            @foreach(['Tech', 'Remote', 'Software Engineering', 'Healthcare', 'Finance', 'Design'] as $cat)
                <a href="{{ route('jobs.index', ['category' => $cat]) }}" class="chip">{{ $cat }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     STATS
═════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="stats-grid">
            @php
                $stats = [
                    ['val' => number_format($jobsCount ?: 12480).'+', 'label' => 'Jobs Posted',       'color' => '#6366f1'],
                    ['val' => '3,200+',                               'label' => 'Companies',          'color' => '#f43f5e'],
                    ['val' => '450K+',                                'label' => 'Job Seekers',        'color' => '#34d399'],
                    ['val' => '8,000+',                               'label' => 'Monthly Applies',    'color' => '#f59e0b'],
                ];
            @endphp
            @foreach($stats as $s)
                <div class="stat-card">
                    <div class="stat-value stat-value-dynamic">{{ $s['val'] }}</div>
                    <div class="stat-label">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     BROWSE BY CATEGORY
══════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-indigo"></span>
                <h2 class="section-heading">Browse by Category</h2>
            </div>
            <a href="{{ route('jobs.index') }}" class="chip chip-link">
                View All &rarr;
            </a>
        </div>

        @php
            $cats = [
                ['title'=>'Tech & Dev',   'icon'=>'💻','count'=>'1,420','val'=>'Software Development','from'=>'#6366f1','to'=>'#818cf8'],
                ['title'=>'Healthcare',   'icon'=>'🩺','count'=>'850',  'val'=>'Healthcare',          'from'=>'#10b981','to'=>'#34d399'],
                ['title'=>'Finance',      'icon'=>'💵','count'=>'640',  'val'=>'Finance',             'from'=>'#f59e0b','to'=>'#fbbf24'],
                ['title'=>'Marketing',    'icon'=>'📣','count'=>'420',  'val'=>'Marketing',           'from'=>'#f43f5e','to'=>'#fb7185'],
                ['title'=>'Construction', 'icon'=>'🏗️','count'=>'310', 'val'=>'Construction',        'from'=>'#8b5cf6','to'=>'#a78bfa'],
                ['title'=>'Remote',       'icon'=>'🏠','count'=>'980',  'val'=>'Remote',              'from'=>'#0ea5e9','to'=>'#38bdf8'],
            ];
        @endphp
        <div class="cat-grid">
            @foreach($cats as $c)
                <a href="{{ route('jobs.index', ['category' => $c['val']]) }}" class="cat-card">
                  <div class="cat-icon cat-icon-dynamic">{{ $c['icon'] }}</div>
                    <div>
                        <div class="cat-title">{{ $c['title'] }}</div>
                        <div class="cat-count">{{ $c['count'] }} jobs</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     FEATURED JOBS
══════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-title">
                <span class="section-accent accent-rose"></span>
                <h2 class="section-heading">⭐ Featured Jobs</h2>
                <span class="text-muted-xs">Promoted opportunities from certified partners</span>
            </div>
            <a href="{{ route('jobs.index', ['featured'=>1]) }}" class="chip chip-link">
                View All &rarr;
            </a>
        </div>

        <div class="feat-grid">
            @forelse($featuredJobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div class="feat-empty">
                    No featured jobs right now &mdash;
                    <a href="{{ route('jobs.index') }}" class="text-indigo">browse all jobs</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="text-center mt-8">
            <h2 class="section-heading">How JOBZINCANADA Works</h2>
            <p class="text-muted-sm m-0">Three simple steps to your next role</p>
        </div>

        <div class="step-grid">
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

{{-- ══════════════════════════════════════
     WHY CHOOSE — gradient banner
══════════════════════════════════════ --}}
<section class="section">
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

{{-- ══════════════════════════════════════
     PORTAL OPTIONS
══════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="portal-grid">

            {{-- Job Seeker --}}
            <div class="portal-card">
                <div class="portal-card-glow portal-glow-candidate2"></div>
                <div class="portal-icon">👨‍💻</div>
                <div>
                            <span class="pill-indigo">FOR CANDIDATES</span>
                    <h2 class="portal-title">I am a Job Seeker</h2>
                    <p class="portal-desc">
                        Create a professional profile, upload multiple resumes, set real-time job alerts,
                        and apply to top Canadian vacancies in seconds.
                    </p>
                </div>
                <ul class="portal-list">
                    @foreach(['Build a stunning profile','Upload & manage resumes','Set smart job alerts','One-click applications'] as $f)
                        <li>
                            <span class="portal-list-dot dot-indigo">✓</span>
                            {{ $f }}
                        </li>
                    @endforeach
                </ul>
                <div class="portal-actions">
                    <a href="{{ route('register') }}" class="portal-btn-primary">
                        Get Started Free
                    </a>
                    <a href="{{ route('jobs.index') }}" class="portal-btn-secondary">
                        Browse Jobs &rarr;
                    </a>
                </div>
            </div>

            {{-- Employer --}}
            <div class="portal-card portal-card-employer">
                <div class="portal-card-glow portal-glow-employer"></div>
                <div class="portal-icon">🏢</div>
                <div>
                            <span class="pill-rose">FOR EMPLOYERS</span>
                    <h2 class="portal-title">I am a Canadian Employer</h2>
                    <p class="portal-desc">
                        Publish roles, screen applicants via our pipeline dashboard, access premium
                        candidate search, and verify your brand credentials.
                    </p>
                </div>
                <ul class="portal-list">
                    @foreach(['Post unlimited job listings','Applicant pipeline kanban','Premium candidate database','Company verification badge'] as $f)
                        <li>
                            <span class="portal-list-dot dot-rose">✓</span>
                            {{ $f }}
                        </li>
                    @endforeach
                </ul>
                <div class="portal-actions">
                    <a href="{{ route('register') }}" class="portal-btn-primary btn-rose">
                        Post a Job
                    </a>
                    <a href="{{ route('login') }}" class="portal-btn-secondary text-white-60">
                        Employer Sign-In &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     NEWSLETTER
══════════════════════════════════════ --}}
<section class="section">
    <div class="section-inner">
        <div class="newsletter-wrap">
            <div class="newsletter-bg"></div>
            <div class="newsletter-inner">
                <div class="newsletter-icon">📬</div>
                <h3 class="newsletter-title">Subscribe to Job Alerts</h3>
                <p class="newsletter-desc">
                    Get weekly updates on new vacancies, salary reports and hiring companies across Canada.
                </p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Enter your email address...">
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
                <p class="newsletter-note">No spam. Unsubscribe anytime.</p>
            </div>
        </div>
    </div>
</section>

<x-footer />

</body>
</html>
