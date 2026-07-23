@php
    use App\Models\Application;
    use App\Models\JobSeekerProfile;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $job->title }} at {{ $job->company->company_name }}. Apply now on JOBZ IN CANADA.">
    <title>{{ $job->title }} - JOBZ IN CANADA</title>
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

<div class="job-show">

    <div class="job-show-inner">

        <div class="mb-3">
            <a href="{{ route('jobs.index') }}" class="back-link">&larr; Back to Jobs</a>
        </div>

        {{-- Job Header Banner --}}
        <section class="section">
            <div class="job-header-card">
                <div class="job-header-glow job-header-glow-1"></div>
                <div class="job-header-glow job-header-glow-2"></div>
                <div class="job-card-row">
                    <div class="job-card-col">
                        <div class="company-row">
                            <div class="company-logo-sm">
                                @if($job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}">
                                @else
                                    {{ strtoupper(substr($job->company->company_name, 0, 2)) }}
                                @endif
                            </div>
                            <div class="company-info">
                                <div class="company-name">{{ $job->company->company_name }}</div>
                                <div class="company-industry">{{ $job->company->industry ?: 'Industry' }}</div>
                            </div>
                        </div>
                        <h1 class="job-title-lg">{{ $job->title }}</h1>
                        <div class="job-meta">
                            <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                            <span class="job-meta-dot"></span>
                            <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                            <span class="job-meta-dot"></span>
                            <span>⏰ {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                        </div>
                    </div>
                    <div class="job-actions">
                        @guest
                            <a href="{{ route('login') }}" class="job-btn job-btn-primary">Apply</a>
                        @else
                            @php
                                $user = Auth::user();
                                $isSeeker = $user && $user->hasRole('job_seeker');
                                $isEmployer = $user && $user->hasRole('employer') && $job->employer_id === $user->id;
                                $hasApplied = false;
                                $isClosed = false;
                                if ($isSeeker) {
                                    $hasApplied = Application::where('job_id', $job->id)->where('applicant_id', $user->id)->where('status', '!=', 'withdrawn')->exists();
                                    $isClosed = $job->status === 'closed' || ($job->application_deadline && \Carbon\Carbon::parse($job->application_deadline)->isPast());
                                }
                            @endphp
                            @if($isSeeker)
                                @if($hasApplied)
                                    <button disabled class="job-btn job-btn-disabled">Already Applied</button>
                                @elseif($isClosed)
                                    <button disabled class="job-btn job-btn-disabled">Closed</button>
                                @else
                                    <a href="{{ route('jobs.apply', $job->slug) }}" class="job-btn job-btn-primary">Apply Now</a>
                                @endif
                            @elseif($isEmployer)
                                <a href="{{ route('employer.applicants.job', $job->id) }}" class="job-btn job-btn-secondary">View Applicants ({{ $job->applications_count }})</a>
                            @endif
                        @endguest
                        <button type="button" title="Save Job" class="job-save-btn">
                            <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="meta-grid">
                    <div class="meta-card">
                        <div class="meta-label">Salary Range</div>
                        <div class="meta-value">
                            @if($job->salary_min && $job->salary_max)
                                ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                            @else
                                Competitive
                            @endif
                        </div>
                    </div>
                    <div class="meta-card">
                        <div class="meta-label">Workplace</div>
                        <div class="meta-value-white">{{ ucfirst($job->workplace_type) }}</div>
                    </div>
                    <div class="meta-card">
                        <div class="meta-label">Experience</div>
                        <div class="meta-value-white">{{ ucfirst($job->experience_level) }}</div>
                    </div>
                    <div class="meta-card">
                        <div class="meta-label">Category</div>
                        <div class="meta-value-white">{{ $job->category ? $job->category->name : 'Technology' }}</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Job Content --}}
        <section class="section">
            <div class="section-inner">
                <div class="content-grid">
                    @if(session('success'))
                        <div class="success-banner">{{ session('success') }}</div>
                    @endif
                    <div class="content-card">
                        <h2 class="content-title">Job Description</h2>
                        <div class="content-body">{!! nl2br(e($job->description)) !!}</div>
                    </div>
                    @if($job->responsibilities)
                        <div class="content-card">
                            <h2 class="content-title">Key Responsibilities</h2>
                            <div class="content-list">
                                @php $i = 1; @endphp
                                @foreach(explode("\n", $job->responsibilities) as $line)
                                    @if(trim($line))
                                        <div class="content-list-item">
                                            <span class="content-list-num">{{ $i++ }}</span>
                                            <span>{{ trim($line) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($job->benefits)
                        <div class="content-card">
                            <h2 class="content-title">Benefits & Perks</h2>
                            <div class="content-list">
                                @php $i = 1; @endphp
                                @foreach(explode("\n", $job->benefits) as $line)
                                    @if(trim($line))
                                        <div class="check-list-item">
                                            <span class="check-icon">✔</span>
                                            <span>{{ trim($line) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($job->skills->count() > 0)
                        <div class="content-card">
                            <h2 class="content-title">Required Skills</h2>
                            <div class="skills-grid">
                                @foreach($job->skills as $skill)
                                    <span class="skill-pill">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($job->company)
                        <div class="content-card">
                            <h2 class="content-title">About {{ $job->company->company_name }}</h2>
                            <div class="company-header">
                                <div class="company-logo">
                                    @if($job->company->logo)
                                        <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}">
                                    @else
                                        {{ strtoupper(substr($job->company->company_name, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="company-name">{{ $job->company->company_name }}</div>
                                    <div class="company-industry">{{ $job->company->industry ?: 'Industry' }}</div>
                                </div>
                            </div>
                            @if($job->company->description)
                                <p class="content-body mb-3">{{ $job->company->description }}</p>
                            @endif
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="back-link">View Company Profile &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Related Jobs --}}
        @if($relatedJobs->count() > 0)
        <section class="section">
            <div class="section-inner">
                <div class="section-header">
                    <div class="section-title">
                        <span class="section-accent accent-rose"></span>
                        <h2 class="section-heading">Similar Jobs</h2>
                    </div>
                </div>
                <div class="recent-grid">
                    @foreach($relatedJobs as $related)
                        <x-job-card :job="$related" :compact="true" />
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </div>

    <x-footer />

</body>
</html>
