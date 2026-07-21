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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Page-level overrides to nail the reference design ── */
        body { background: #090c17; }
        .dark body, .dark { background: #090c17; }

        /* Navbar */
        .home-nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(9,12,23,0.92);
            backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        /* ── jcard, pill, logo styles are injected by the job-card component ── */


        /* Type badges */
        .type-badge {
            display: inline-flex; align-items: center;
            padding: .2rem .55rem; border-radius: 99px;
            font-size: .65rem; font-weight: 700; letter-spacing: .04em;
        }
        .type-full-time  { background: rgba(99,102,241,.18); color: #a5b4fc; }
        .type-part-time  { background: rgba(245,158,11,.15); color: #fbbf24; }
        .type-contract   { background: rgba(16,185,129,.15); color: #6ee7b7; }
        .type-remote     { background: rgba(14,165,233,.15); color: #7dd3fc; }
        .type-featured   { background: rgba(99,102,241,.25); color: #818cf8; }
        .type-urgent     { background: rgba(244,63,94,.2);   color: #fb7185; }

        /* Employer card */
        .emp-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px; padding: 1.25rem 1rem;
            text-align: center; display: flex; flex-direction: column;
            align-items: center; gap: .625rem;
            transition: border-color .18s, transform .18s;
            text-decoration: none;
        }
        .emp-card:hover { border-color: rgba(99,102,241,.4); transform: translateY(-2px); }

        /* Step card */
        .step-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px; padding: 1.5rem;
            display: flex; flex-direction: column; gap: .875rem;
        }

        /* Section heading accent bar */
        .sec-accent { width: 3px; height: 1.125rem; border-radius: 99px; display: inline-block; flex-shrink: 0; }

        /* Salary green */
        .salary-green { color: #34d399; font-weight: 700; font-size: .9rem; }

        /* Nav link */
        .hnav-link {
            font-size: .875rem; color: rgba(255,255,255,.55); font-weight: 500;
            padding: .375rem .625rem; border-radius: 8px; text-decoration: none;
            transition: color .15s, background .15s;
        }
        .hnav-link:hover { color: #fff; background: rgba(255,255,255,.07); }

        /* Responsive grids */
        @media(min-width:640px) {
            .feat-grid  { grid-template-columns: repeat(2,1fr) !important; }
            .stats-grid { grid-template-columns: repeat(4,1fr) !important; }
            .emp-grid   { grid-template-columns: repeat(3,1fr) !important; }
            .portal-grid{ grid-template-columns: repeat(2,1fr) !important; }
        }
        @media(min-width:768px) {
            .cat-grid   { grid-template-columns: repeat(4,1fr) !important; }
            .recent-grid{ grid-template-columns: repeat(2,1fr) !important; }
            .why-inner  { flex-direction: row !important; }
        }
        @media(min-width:1024px) {
            .cat-grid    { grid-template-columns: repeat(6,1fr) !important; }
            .recent-grid { grid-template-columns: repeat(3,1fr) !important; }
            .emp-grid    { grid-template-columns: repeat(5,1fr) !important; }
            .step-grid   { grid-template-columns: repeat(3,1fr) !important; }
            .footer-grid { grid-template-columns: 1.8fr 1fr 1fr 1fr .9fr !important; }
            .nav-links   { display: flex !important; }
            .nav-post    { display: inline-flex !important; }
        }
    </style>
</head>
<body style="min-height:100dvh;font-family:'Poppins',sans-serif;color:#f1f5f9;">

{{-- ══════════════════════════════════════
     AMBIENT BLOBS
══════════════════════════════════════ --}}
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;" aria-hidden="true">
    <div style="position:absolute;top:-15%;left:-10%;width:700px;height:700px;
                background:radial-gradient(circle,rgba(99,102,241,.14) 0%,transparent 68%);
                filter:blur(80px);border-radius:50%;"></div>
    <div style="position:absolute;top:-5%;right:-8%;width:550px;height:550px;
                background:radial-gradient(circle,rgba(244,63,94,.09) 0%,transparent 68%);
                filter:blur(90px);border-radius:50%;"></div>
    <div style="position:absolute;bottom:0;left:30%;width:900px;height:400px;
                background:radial-gradient(ellipse,rgba(99,102,241,.05) 0%,transparent 70%);
                filter:blur(100px);"></div>
</div>

{{-- ══════════════════════════════════════
     NAVBAR
══════════════════════════════════════ --}}
<header class="home-nav">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;
                display:flex;align-items:center;justify-content:space-between;
                height:3.75rem;gap:1rem;position:relative;z-index:1;">

        {{-- Brand --}}
        <a href="/" style="display:flex;align-items:center;gap:.5rem;text-decoration:none;flex-shrink:0;">
            <div style="width:1.875rem;height:1.875rem;border-radius:8px;
                        background:linear-gradient(135deg,#6366f1,#f43f5e);
                        display:flex;align-items:center;justify-content:center;
                        font-size:.7rem;font-weight:800;color:#fff;box-shadow:0 4px 12px rgba(99,102,241,.4);">J</div>
            <span style="font-size:.813rem;font-weight:800;letter-spacing:-.02em;color:#fff;">
                JOBZ IN <span style="color:#6366f1;">CANADA</span>
            </span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="nav-links" style="display:none;align-items:center;gap:.125rem;">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="#" class="hnav-link">Pricing</a>
            <a href="#" class="hnav-link">Resources</a>
        </nav>

        {{-- Actions --}}
        <div style="display:flex;align-items:center;gap:.5rem;">
            {{-- Search icon --}}
            <button style="width:2rem;height:2rem;border-radius:8px;border:none;
                           background:rgba(255,255,255,.07);color:rgba(255,255,255,.5);
                           cursor:pointer;display:flex;align-items:center;justify-content:center;"
                    title="Search">
                <svg style="width:.9rem;height:.9rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- Theme toggle --}}
            <button @click="dark = !dark" type="button"
                    style="width:2rem;height:2rem;border-radius:8px;border:none;
                           background:rgba(255,255,255,.07);color:rgba(255,255,255,.5);
                           cursor:pointer;display:flex;align-items:center;justify-content:center;"
                    title="Toggle theme">
                <span x-show="!dark" style="display:flex;">
                    <svg style="width:.9rem;height:.9rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark" style="display:flex;">
                    <svg style="width:.9rem;height:.9rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </span>
            </button>

            <a href="{{ route('register') }}" class="nav-post"
               style="display:none;font-size:.8125rem;font-weight:600;color:rgba(255,255,255,.65);
                      padding:.375rem .875rem;border-radius:8px;border:1px solid rgba(255,255,255,.12);
                      text-decoration:none;transition:all .15s;"
               onmouseover="this.style.borderColor='rgba(99,102,241,.5)';this.style.color='#fff';"
               onmouseout="this.style.borderColor='rgba(255,255,255,.12)';this.style.color='rgba(255,255,255,.65)';">
                Sign In
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                   style="font-size:.8125rem;font-weight:700;color:#fff;padding:.4rem 1rem;
                          border-radius:8px;background:#6366f1;text-decoration:none;
                          box-shadow:0 2px 12px rgba(99,102,241,.4);transition:background .15s;"
                   onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                   style="font-size:.8125rem;font-weight:700;color:#fff;padding:.4rem 1rem;
                          border-radius:8px;background:#6366f1;text-decoration:none;
                          box-shadow:0 2px 12px rgba(99,102,241,.4);transition:background .15s;"
                   onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    Get Started
                </a>
            @endauth
        </div>
    </div>
</header>

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section style="padding:4.5rem 0 3.5rem;text-align:center;position:relative;z-index:1;">
    <div style="max-width:780px;margin:0 auto;padding:0 1.25rem;">

        {{-- Pill --}}
        <div style="margin-bottom:1.375rem;">
            <span style="display:inline-flex;align-items:center;gap:.5rem;
                         padding:.3rem .875rem;border-radius:99px;
                         background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);
                         font-size:.75rem;font-weight:600;color:#a5b4fc;letter-spacing:.03em;">
                🇨🇦 Canada Wide Jobs &bull;
                <span style="color:#fff;font-weight:700;">{{ $jobsCount > 0 ? number_format($jobsCount) : '12,480' }}+</span>
                Active Roles
            </span>
        </div>

        {{-- H1 --}}
        <h1 style="font-size:clamp(2.125rem,5.5vw,3.5rem);font-weight:800;
                   letter-spacing:-.045em;line-height:1.1;color:#fff;margin:0 0 1.125rem;">
            Find your dream job<br>
            in <span style="background:linear-gradient(135deg,#6366f1,#f43f5e);
                            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                            background-clip:text;">Canada</span>
        </h1>

        <p style="font-size:.9375rem;color:rgba(255,255,255,.55);max-width:520px;
                  margin:0 auto 2.25rem;line-height:1.7;">
            Discover thousands of exciting opportunities from Canada's top verified employers.
            Transparent salaries, remote options &amp; one-click applications.
        </p>

        {{-- Search bar --}}
        <form action="{{ route('jobs.index') }}" method="GET"
              style="display:flex;align-items:center;gap:0;flex-wrap:wrap;justify-content:center;
                     background:#111827;border:1px solid rgba(255,255,255,.09);
                     border-radius:14px;padding:.5rem;
                     box-shadow:0 0 0 1px rgba(99,102,241,.1),0 8px 40px rgba(0,0,0,.4);
                     max-width:700px;margin:0 auto 1.375rem;">

            {{-- What --}}
            <div style="flex:2;min-width:180px;display:flex;align-items:center;gap:.5rem;
                         padding:.5rem .75rem;">
                <svg style="width:1rem;height:1rem;color:#6366f1;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Job title, keywords or company..."
                       style="flex:1;background:transparent;border:none;outline:none;
                              font-size:.875rem;color:#f1f5f9;font-family:'Poppins',sans-serif;"
                       placeholder-color="rgba(255,255,255,.3)">
            </div>

            <div style="width:1px;background:rgba(255,255,255,.08);align-self:stretch;margin:.25rem 0;flex-shrink:0;"></div>

            {{-- Where --}}
            <div style="flex:1.2;min-width:140px;display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;">
                <svg style="width:1rem;height:1rem;color:#f43f5e;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="location" placeholder="City, province or Remote..."
                       style="flex:1;background:transparent;border:none;outline:none;
                              font-size:.875rem;color:#f1f5f9;font-family:'Poppins',sans-serif;">
            </div>

            {{-- Button --}}
            <button type="submit"
                    style="background:#6366f1;color:#fff;border:none;border-radius:10px;
                           padding:.625rem 1.5rem;font-size:.875rem;font-weight:700;cursor:pointer;
                           display:flex;align-items:center;gap:.375rem;white-space:nowrap;
                           font-family:'Poppins',sans-serif;
                           box-shadow:0 2px 12px rgba(99,102,241,.45);transition:background .15s;"
                    onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                <svg style="width:.875rem;height:.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search
            </button>
        </form>

        {{-- Popular tags --}}
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:.5rem;">
            <span style="font-size:.75rem;color:rgba(255,255,255,.35);font-weight:500;">Popular:</span>
            @foreach(['Tech', 'Remote', 'Software Engineering', 'Healthcare', 'Finance', 'Design'] as $cat)
                <a href="{{ route('jobs.index', ['category' => $cat]) }}"
                   style="font-size:.75rem;font-weight:500;padding:.2rem .625rem;border-radius:99px;
                          border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.55);
                          text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.borderColor='rgba(99,102,241,.5)';this.style.color='#a5b4fc';"
                   onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.55)';">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     STATS
══════════════════════════════════════ --}}
<section style="padding:.25rem 0 3rem;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">
        <div class="stats-grid" style="display:grid;grid-template-columns:repeat(2,1fr);gap:1px;
                                       border:1px solid rgba(255,255,255,.07);border-radius:14px;
                                       overflow:hidden;background:rgba(255,255,255,.07);">
            @php
                $stats = [
                    ['val' => number_format($jobsCount ?: 12480).'+', 'label' => 'Jobs Posted',       'color' => '#6366f1'],
                    ['val' => '3,200+',                               'label' => 'Companies',          'color' => '#f43f5e'],
                    ['val' => '450K+',                                'label' => 'Job Seekers',        'color' => '#34d399'],
                    ['val' => '8,000+',                               'label' => 'Monthly Applies',    'color' => '#f59e0b'],
                ];
            @endphp
            @foreach($stats as $s)
                <div style="background:#111827;padding:1.5rem 1.25rem;text-align:center;">
                    <div style="font-size:1.75rem;font-weight:800;color:{{ $s['color'] }};
                                letter-spacing:-.04em;line-height:1;margin-bottom:.25rem;">{{ $s['val'] }}</div>
                    <div style="font-size:.8rem;color:rgba(255,255,255,.4);font-weight:500;">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     BROWSE BY CATEGORY
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">

        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.375rem;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <span class="sec-accent" style="background:#6366f1;"></span>
                <h2 style="font-size:1.125rem;font-weight:700;color:#fff;margin:0;letter-spacing:-.02em;">Browse by Category</h2>
            </div>
            <a href="{{ route('jobs.index') }}"
               style="font-size:.8125rem;color:#6366f1;text-decoration:none;font-weight:600;
                      transition:color .15s;" onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6366f1'">
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
        <div class="cat-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;">
            @foreach($cats as $c)
                <a href="{{ route('jobs.index', ['category' => $c['val']]) }}"
                   style="background:#111827;border:1px solid rgba(255,255,255,.07);border-radius:12px;
                          padding:1.125rem;display:flex;flex-direction:column;align-items:flex-start;gap:.625rem;
                          text-decoration:none;transition:all .18s;"
                   onmouseover="this.style.borderColor='rgba(99,102,241,.4)';this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.borderColor='rgba(255,255,255,.07)';this.style.transform='translateY(0)';">
                    <div style="width:2.375rem;height:2.375rem;border-radius:10px;
                                background:linear-gradient(135deg,{{ $c['from'] }},{{ $c['to'] }});
                                display:flex;align-items:center;justify-content:center;font-size:1.125rem;
                                box-shadow:0 4px 14px rgba(0,0,0,.25);">{{ $c['icon'] }}</div>
                    <div>
                        <div style="font-size:.875rem;font-weight:700;color:#fff;margin-bottom:.125rem;">{{ $c['title'] }}</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.4);">{{ $c['count'] }} jobs</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     FEATURED JOBS  (2-column grid)
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">

        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.375rem;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <span class="sec-accent" style="background:#f43f5e;"></span>
                <h2 style="font-size:1.125rem;font-weight:700;color:#fff;margin:0;letter-spacing:-.02em;">⭐ Featured Jobs</h2>
                <span style="font-size:.75rem;color:rgba(255,255,255,.35);">Promoted opportunities from certified partners</span>
            </div>
            <a href="{{ route('jobs.index', ['featured'=>1]) }}"
               style="font-size:.8125rem;color:#6366f1;text-decoration:none;font-weight:600;"
               onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6366f1'">
                View All &rarr;
            </a>
        </div>

        <div class="feat-grid" style="display:grid;grid-template-columns:1fr;gap:.875rem;">
            @forelse($featuredJobs as $job)
                <x-job-card :job="$job" />
            @empty
                <div style="text-align:center;padding:3rem;color:rgba(255,255,255,.35);">
                    No featured jobs right now &mdash;
                    <a href="{{ route('jobs.index') }}" style="color:#6366f1;">browse all jobs</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════ --}}
<section style="padding:3rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">

        <div style="text-align:center;margin-bottom:2rem;">
            <h2 style="font-size:1.125rem;font-weight:700;color:#fff;margin:0 0 .375rem;letter-spacing:-.02em;">
                How JOBZINCANADA Works
            </h2>
            <p style="font-size:.8125rem;color:rgba(255,255,255,.4);margin:0;">Three simple steps to your next role</p>
        </div>

        <div class="step-grid" style="display:grid;grid-template-columns:1fr;gap:1rem;">
            @php
                $steps = [
                    ['n'=>'1','title'=>'Create Your Profile',     'desc'=>'Sign up and build a professional profile. Upload your resume, skills, experience and preferences.', 'color'=>'#6366f1'],
                    ['n'=>'2','title'=>'Discover Opportunities',  'desc'=>'Search and filter thousands of verified Canadian jobs by role, location, salary and work type.', 'color'=>'#f43f5e'],
                    ['n'=>'3','title'=>'Apply & Get Hired',       'desc'=>'Apply with one click using your saved profile. Track your applications and land your dream job.', 'color'=>'#34d399'],
                ];
            @endphp
            @foreach($steps as $step)
                <div class="step-card">
                    <div style="display:flex;align-items:center;gap:.875rem;">
                        <div style="width:2.375rem;height:2.375rem;border-radius:99px;
                                    background:{{ $step['color'] }}22;border:1px solid {{ $step['color'] }}44;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:1rem;font-weight:800;color:{{ $step['color'] }};">{{ $step['n'] }}</span>
                        </div>
                        <h3 style="font-size:.9375rem;font-weight:700;color:#fff;margin:0;">{{ $step['title'] }}</h3>
                    </div>
                    <p style="font-size:.8125rem;color:rgba(255,255,255,.5);line-height:1.7;margin:0;padding-left:3.25rem;">
                        {{ $step['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     WHY CHOOSE — gradient banner
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">
        <div style="border-radius:18px;overflow:hidden;position:relative;
                    background:linear-gradient(135deg,#1e1b4b 0%,#312e81 40%,#4338ca 70%,#6366f1 100%);
                    padding:2.5rem 2rem;">
            {{-- Overlay noise --}}
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 80% 20%,rgba(244,63,94,.2) 0%,transparent 55%);pointer-events:none;"></div>
            <div style="position:absolute;inset:0;background:radial-gradient(circle at 10% 80%,rgba(255,255,255,.05) 0%,transparent 50%);pointer-events:none;"></div>

            <div class="why-inner" style="position:relative;display:flex;flex-direction:column;gap:2rem;align-items:flex-start;">
                {{-- Left text --}}
                <div style="flex-shrink:0;max-width:320px;">
                    <h2 style="font-size:1.5rem;font-weight:800;color:#fff;margin:0 0 .75rem;letter-spacing:-.03em;">
                        Why choose JOBZINCANADA?
                    </h2>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.7);margin:0;line-height:1.7;">
                        Built with candidates and local employers in mind. Trusted by thousands of Canadians every month.
                    </p>
                    <a href="{{ route('register') }}"
                       style="display:inline-flex;align-items:center;gap:.375rem;margin-top:1.25rem;
                              font-size:.875rem;font-weight:700;color:#fff;text-decoration:none;
                              padding:.55rem 1.25rem;border-radius:10px;background:rgba(255,255,255,.15);
                              border:1px solid rgba(255,255,255,.25);transition:all .15s;"
                       onmouseover="this.style.background='rgba(255,255,255,.22)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                        Get Started Free &rarr;
                    </a>
                </div>

                {{-- Right features --}}
                <div style="flex:1;display:grid;gap:.875rem;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));">
                    @php
                        $whys = [
                            ['icon'=>'✔️','title'=>'Verified Employers',    'desc'=>'All job posts are double-checked for corporate credentials.'],
                            ['icon'=>'📍','title'=>'Canada-Wide Positions', 'desc'=>'Remote roles plus local jobs in Toronto, Vancouver & Montreal.'],
                            ['icon'=>'💵','title'=>'Salary Transparency',   'desc'=>'See salary ranges and full benefits before applying.'],
                        ];
                    @endphp
                    @foreach($whys as $w)
                        <div style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
                                    border-radius:12px;padding:1.125rem;">
                            <div style="font-size:1.375rem;margin-bottom:.5rem;">{{ $w['icon'] }}</div>
                            <div style="font-size:.875rem;font-weight:700;color:#fff;margin-bottom:.25rem;">{{ $w['title'] }}</div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.65);line-height:1.6;">{{ $w['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     TOP EMPLOYERS
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">

        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.375rem;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <span class="sec-accent" style="background:#34d399;"></span>
                <h2 style="font-size:1.125rem;font-weight:700;color:#fff;margin:0;letter-spacing:-.02em;">Top Employers</h2>
                <span style="font-size:.75rem;color:rgba(255,255,255,.35);">Partner brands actively recruiting in Canada</span>
            </div>
            <a href="{{ route('companies.index') }}"
               style="font-size:.8125rem;color:#6366f1;text-decoration:none;font-weight:600;"
               onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6366f1'">
                All Companies &rarr;
            </a>
        </div>

        <div class="emp-grid" style="display:grid;grid-template-columns:repeat(2,1fr);gap:.875rem;">
            @forelse($companies as $company)
                @php $initials = strtoupper(substr($company->company_name ?? 'CO', 0, 2)); @endphp
                <a href="{{ route('companies.show', $company->slug) }}" class="emp-card" style="flex-direction:row;text-align:left;align-items:center;gap:.875rem;">
                    <div style="width:2.5rem;height:2.5rem;border-radius:10px;flex-shrink:0;
                                background:linear-gradient(135deg,#6366f1,#f43f5e);overflow:hidden;
                                display:flex;align-items:center;justify-content:center;
                                font-size:.75rem;font-weight:800;color:#fff;">
                        @if($company->logo)
                            <img src="{{ $company->logo }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                        @else {{ $initials }} @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:.25rem;margin-bottom:.125rem;">
                            <span style="font-size:.875rem;font-weight:700;color:#fff;
                                         white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $company->company_name }}
                            </span>
                            <span style="width:.875rem;height:.875rem;background:#6366f1;border-radius:50%;flex-shrink:0;
                                         display:inline-flex;align-items:center;justify-content:center;font-size:.45rem;color:#fff;">✓</span>
                        </div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.4);">{{ $company->industry ?: 'Industry' }}</div>
                    </div>
                    <span style="font-size:.75rem;font-weight:600;padding:.2rem .55rem;border-radius:99px;
                                  background:rgba(99,102,241,.18);color:#a5b4fc;white-space:nowrap;flex-shrink:0;">
                        {{ $company->jobs->count() }} Jobs
                    </span>
                </a>
            @empty
                @foreach(['Shopify','RBC Bank','TD Bank','TechNorth','CanBridge'] as $co)
                    <div class="emp-card" style="flex-direction:row;text-align:left;align-items:center;gap:.875rem;">
                        <div style="width:2.5rem;height:2.5rem;border-radius:10px;background:#1e2035;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:.8rem;font-weight:800;color:rgba(255,255,255,.35);">{{ strtoupper(substr($co,0,2)) }}</div>
                        <div>
                            <div style="font-size:.875rem;font-weight:700;color:rgba(255,255,255,.65);">{{ $co }}</div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.3);">Industry</div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     RECENTLY POSTED  (3-column grid)
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">

        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.375rem;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <span class="sec-accent" style="background:#f59e0b;"></span>
                <h2 style="font-size:1.125rem;font-weight:700;color:#fff;margin:0;letter-spacing:-.02em;">Recently Posted</h2>
                <span style="font-size:.75rem;color:rgba(255,255,255,.35);">New career opportunities added today</span>
            </div>
            <a href="{{ route('jobs.index') }}"
               style="font-size:.8125rem;color:#6366f1;text-decoration:none;font-weight:600;"
               onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6366f1'">
                All Jobs &rarr;
            </a>
        </div>

        <div class="recent-grid" style="display:grid;grid-template-columns:1fr;gap:.875rem;">
            @forelse($recentJobs as $job)
                <x-job-card :job="$job" :compact="true" />
            @empty
                <div style="text-align:center;padding:3rem;color:rgba(255,255,255,.35);grid-column:1/-1;">
                    No recent jobs &mdash;
                    <a href="{{ route('jobs.index') }}" style="color:#6366f1;">browse all jobs</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     PORTAL OPTIONS
══════════════════════════════════════ --}}
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">
        <div class="portal-grid" style="display:grid;grid-template-columns:1fr;gap:1.25rem;">

            {{-- Job Seeker --}}
            <div style="background:#111827;border:1px solid rgba(255,255,255,.08);border-radius:18px;
                        padding:2rem;display:flex;flex-direction:column;gap:1.25rem;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-2rem;right:-2rem;width:8rem;height:8rem;
                             background:radial-gradient(circle,rgba(99,102,241,.2),transparent 70%);border-radius:50%;"></div>
                <div style="font-size:2.5rem;">👨‍💻</div>
                <div>
                    <span style="font-size:.7rem;font-weight:700;padding:.2rem .625rem;border-radius:99px;
                                  background:rgba(99,102,241,.2);color:#a5b4fc;letter-spacing:.04em;">FOR CANDIDATES</span>
                    <h2 style="font-size:1.375rem;font-weight:800;color:#fff;margin:.625rem 0 .625rem;letter-spacing:-.03em;">
                        I am a Job Seeker
                    </h2>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.55);line-height:1.7;margin:0;">
                        Create a professional profile, upload multiple resumes, set real-time job alerts,
                        and apply to top Canadian vacancies in seconds.
                    </p>
                </div>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.5rem;">
                    @foreach(['Build a stunning profile','Upload & manage resumes','Set smart job alerts','One-click applications'] as $f)
                        <li style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:rgba(255,255,255,.6);">
                            <span style="width:1rem;height:1rem;background:#6366f1;border-radius:50%;
                                         display:flex;align-items:center;justify-content:center;
                                         font-size:.45rem;color:#fff;flex-shrink:0;">✓</span>
                            {{ $f }}
                        </li>
                    @endforeach
                </ul>
                <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                    <a href="{{ route('register') }}"
                       style="font-size:.875rem;font-weight:700;color:#fff;text-decoration:none;
                              padding:.65rem 1.5rem;border-radius:10px;background:#6366f1;
                              box-shadow:0 2px 14px rgba(99,102,241,.45);transition:background .15s;"
                       onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                        Get Started Free
                    </a>
                    <a href="{{ route('jobs.index') }}"
                       style="font-size:.875rem;font-weight:600;color:#818cf8;text-decoration:none;
                              padding:.65rem 1.25rem;border-radius:10px;border:1px solid rgba(99,102,241,.3);
                              transition:all .15s;"
                       onmouseover="this.style.background='rgba(99,102,241,.1)'" onmouseout="this.style.background='transparent'">
                        Browse Jobs &rarr;
                    </a>
                </div>
            </div>

            {{-- Employer --}}
            <div style="background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 50%,#312e81 100%);
                        border:1px solid rgba(99,102,241,.25);border-radius:18px;
                        padding:2rem;display:flex;flex-direction:column;gap:1.25rem;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-2rem;right:-2rem;width:8rem;height:8rem;
                             background:radial-gradient(circle,rgba(244,63,94,.25),transparent 70%);border-radius:50%;"></div>
                <div style="font-size:2.5rem;">🏢</div>
                <div>
                    <span style="font-size:.7rem;font-weight:700;padding:.2rem .625rem;border-radius:99px;
                                  background:rgba(244,63,94,.2);color:#fb7185;letter-spacing:.04em;">FOR EMPLOYERS</span>
                    <h2 style="font-size:1.375rem;font-weight:800;color:#fff;margin:.625rem 0 .625rem;letter-spacing:-.03em;">
                        I am a Canadian Employer
                    </h2>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.55);line-height:1.7;margin:0;">
                        Publish roles, screen applicants via our pipeline dashboard, access premium
                        candidate search, and verify your brand credentials.
                    </p>
                </div>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.5rem;">
                    @foreach(['Post unlimited job listings','Applicant pipeline kanban','Premium candidate database','Company verification badge'] as $f)
                        <li style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:rgba(255,255,255,.55);">
                            <span style="width:1rem;height:1rem;background:#f43f5e;border-radius:50%;
                                         display:flex;align-items:center;justify-content:center;
                                         font-size:.45rem;color:#fff;flex-shrink:0;">✓</span>
                            {{ $f }}
                        </li>
                    @endforeach
                </ul>
                <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                    <a href="{{ route('register') }}"
                       style="font-size:.875rem;font-weight:700;color:#fff;text-decoration:none;
                              padding:.65rem 1.5rem;border-radius:10px;background:#f43f5e;
                              box-shadow:0 2px 14px rgba(244,63,94,.4);transition:background .15s;"
                       onmouseover="this.style.background='#e11d48'" onmouseout="this.style.background='#f43f5e'">
                        Post a Job
                    </a>
                    <a href="{{ route('login') }}"
                       style="font-size:.875rem;font-weight:600;color:rgba(255,255,255,.6);text-decoration:none;
                              display:inline-flex;align-items:center;gap:.25rem;padding:.65rem 1rem;">
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
<section style="padding:2.5rem 0;position:relative;z-index:1;">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.25rem;">
        <div style="background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 50%,#f43f5e 100%);
                    border-radius:18px;padding:2.5rem 2rem;position:relative;overflow:hidden;text-align:center;">
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 80% 30%,rgba(255,255,255,.08),transparent 55%);pointer-events:none;"></div>
            <div style="position:relative;max-width:500px;margin:0 auto;">
                <div style="font-size:2rem;margin-bottom:.75rem;">📬</div>
                <h3 style="font-size:1.375rem;font-weight:800;color:#fff;letter-spacing:-.03em;margin:0 0 .5rem;">
                    Subscribe to Job Alerts
                </h3>
                <p style="font-size:.875rem;color:rgba(255,255,255,.75);margin:0 0 1.5rem;line-height:1.6;">
                    Get weekly updates on new vacancies, salary reports and hiring companies across Canada.
                </p>
                <form style="display:flex;gap:.5rem;flex-wrap:wrap;justify-content:center;">
                    <input type="email" placeholder="Enter your email address..."
                           style="flex:1;min-width:200px;background:rgba(255,255,255,.15);
                                  border:1px solid rgba(255,255,255,.2);border-radius:10px;
                                  padding:.65rem 1rem;color:#fff;font-size:.875rem;outline:none;
                                  font-family:'Poppins',sans-serif;">
                    <button type="submit"
                            style="background:#fff;color:#4f46e5;border:none;border-radius:10px;
                                   padding:.65rem 1.375rem;font-size:.875rem;font-weight:700;
                                   cursor:pointer;font-family:'Poppins',sans-serif;
                                   transition:background .15s;white-space:nowrap;"
                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                        Subscribe
                    </button>
                </form>
                <p style="font-size:.75rem;color:rgba(255,255,255,.5);margin:.75rem 0 0;">No spam. Unsubscribe anytime.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     FOOTER
══════════════════════════════════════ --}}
<footer style="border-top:1px solid rgba(255,255,255,.06);position:relative;z-index:1;background:#090c17;">
    <div style="max-width:1280px;margin:0 auto;padding:3rem 1.25rem 2.5rem;">
        <div class="footer-grid" style="display:grid;gap:2.5rem;">

            {{-- Brand --}}
            <div>
                <a href="/" style="display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;margin-bottom:1rem;">
                    <div style="width:1.75rem;height:1.75rem;border-radius:7px;
                                background:linear-gradient(135deg,#6366f1,#f43f5e);
                                display:flex;align-items:center;justify-content:center;
                                font-size:.65rem;font-weight:800;color:#fff;">J</div>
                    <span style="font-size:.813rem;font-weight:800;color:#fff;letter-spacing:-.02em;">
                        JOBZ IN <span style="color:#6366f1;">CANADA</span>
                    </span>
                </a>
                <p style="font-size:.8125rem;color:rgba(255,255,255,.4);line-height:1.7;margin:0 0 1rem;max-width:220px;">
                    Canada's premier job board connecting top talent with leading employers nationwide.
                </p>
                <div style="display:flex;flex-direction:column;gap:.375rem;">
                    <span style="font-size:.75rem;color:rgba(255,255,255,.35);">📍 250 Yonge St, Toronto, ON</span>
                    <span style="font-size:.75rem;color:rgba(255,255,255,.35);">📧 support@jobzincanada.ca</span>
                </div>
            </div>

            {{-- Links --}}
            @php
                $footerCols = [
                    'Quick Links' => [['/','Home'],[route('companies.index'),'Verified Companies'],['#','Pricing Plans']],
                    'Candidates'  => [[route('jobs.index'),'Browse Jobs'],['#','Career Advice'],['#','Salary Guide']],
                    'Employers'   => [['#','Post a Job'],['#','Pricing'],['#','Talent Search']],
                ];
            @endphp
            @foreach($footerCols as $heading => $links)
                <div>
                    <h4 style="font-size:.75rem;font-weight:700;color:rgba(255,255,255,.7);
                                letter-spacing:.06em;text-transform:uppercase;margin:0 0 1rem;">{{ $heading }}</h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.5rem;">
                        @foreach($links as [$href,$label])
                            <li>
                                <a href="{{ $href }}"
                                   style="font-size:.8125rem;color:rgba(255,255,255,.4);text-decoration:none;transition:color .15s;"
                                   onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='rgba(255,255,255,.4)'">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- Social --}}
            <div>
                <h4 style="font-size:.75rem;font-weight:700;color:rgba(255,255,255,.7);
                            letter-spacing:.06em;text-transform:uppercase;margin:0 0 1rem;">Connect</h4>
                <div style="display:flex;gap:.5rem;">
                    @foreach([['LN','LinkedIn'],['TW','Twitter'],['FB','Facebook']] as [$init,$name])
                        <a href="#" title="{{ $name }}"
                           style="width:2rem;height:2rem;background:rgba(255,255,255,.06);
                                  border:1px solid rgba(255,255,255,.1);border-radius:8px;
                                  display:flex;align-items:center;justify-content:center;
                                  font-size:.65rem;font-weight:700;color:rgba(255,255,255,.45);text-decoration:none;
                                  transition:all .15s;"
                           onmouseover="this.style.background='rgba(99,102,241,.2)';this.style.borderColor='rgba(99,102,241,.4)';this.style.color='#818cf8'"
                           onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.45)'">
                            {{ $init }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div style="border-top:1px solid rgba(255,255,255,.06);">
        <div style="max-width:1280px;margin:0 auto;padding:1.125rem 1.25rem;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <p style="font-size:.75rem;color:rgba(255,255,255,.3);margin:0;">
                &copy; {{ date('Y') }} JOBZ IN CANADA. All rights reserved.
            </p>
            <div style="display:flex;gap:1.25rem;">
                @foreach(['Privacy Policy','Terms of Service','Cookies'] as $link)
                    <a href="#" style="font-size:.75rem;color:rgba(255,255,255,.3);text-decoration:none;transition:color .15s;"
                       onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='rgba(255,255,255,.3)'">
                        {{ $link }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>

<style>
    input::placeholder { color: rgba(255,255,255,.3) !important; }
</style>

</body>
</html>
