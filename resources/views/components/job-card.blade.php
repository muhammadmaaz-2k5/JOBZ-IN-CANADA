{{--
    Job Card Component
    ==================
    Usage:
        <x-job-card :job="$job" />
        <x-job-card :job="$job" :compact="true" />

    Props:
        $job      — App\Models\Job (eager-loaded with company, skills, screeningQuestions)
        $compact  — bool (default false) — renders a slimmer list-row variant

    Computed by JobCard.php:
        $initials   — 2-letter logo fallback
        $postedAgo  — "3d ago" etc.
        $empType    — "Full-time" etc.
        $isVerified — bool
--}}

@php
    $isRemote    = ($job->workplace_type ?? '') === 'remote'
                || strtolower($job->location ?? '') === 'remote';
    $easyApply   = $job->screeningQuestions->count() === 0;
    $salaryLabel = $job->salary_min
        ? '$' . number_format($job->salary_min / 1000) . 'k – $' . number_format($job->salary_max / 1000) . 'k /yr'
        : null;
    $views       = rand(8, 150);
@endphp

{{-- ═══════════════════════════════════════════════════════
     COMPACT variant  ─ used in "Recently Posted" 3-col grid
══════════════════════════════════════════════════════════ --}}
@if($compact)
<article class="jcard">

    {{-- ★ Featured pill --}}
    @if($job->featured)
        <div class="jcard-featured-pill">
            <svg class="jcard-featured-icon" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Featured
        </div>
    @endif

    {{-- Logo + Title --}}
    <div class="jcard-row-compact">

        <div class="jcard-logo jcard-logo-sm">
            @if($job->company->logo)
                <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}">
            @else
                {{ $initials }}
            @endif
            @if($isVerified)
                <span class="jcard-verified">✓</span>
            @endif
        </div>

        <div class="jcard-text-block">
            <h3 class="jcard-title-sm">
                <a href="{{ route('jobs.show', $job->slug) }}" class="jcard-title-link">
                    {{ Str::limit($job->title, 48) }}
                </a>
            </h3>
            <div class="jcard-company-row-compact">
                <span class="jcard-company-sm">{{ $job->company->company_name }}</span>
                @if($isVerified)
                    <span class="jcard-verified-inline">✓</span>
                @endif
            </div>
            {{-- Meta: location · type · time --}}
            <div class="jcard-meta">
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->city }}, {{ $job->country }}
                </span>
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $empType }}
                </span>
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $postedAgo }}
                </span>
            </div>
        </div>
    </div>

    {{-- Pills --}}
    <div class="jcard-pills">
        @if($isRemote)  <span class="pill pill-remote">Remote</span>  @endif
        @if($job->experience_level) <span class="pill pill-dark">{{ ucfirst($job->experience_level) }}</span> @endif
        @if($easyApply) <span class="pill pill-green">Easy Apply</span> @endif
        @foreach($job->skills->take(2) as $skill)
            <span class="pill pill-dark">{{ $skill->name }}</span>
        @endforeach
    </div>

    {{-- Divider --}}
    <div class="jcard-divider"></div>

    {{-- Footer --}}
    <div class="jcard-footer">
        <div>
            <div class="jcard-salary">
                @if($salaryLabel) {{ $salaryLabel }}
                @else <span class="jcard-salary-muted">Competitive</span> @endif
            </div>
            <div class="jcard-views">
                <svg class="jcard-views-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>{{ $views }} views &nbsp;&middot;&nbsp; 1 vacancy</span>
            </div>
        </div>
        <button type="button" class="jcard-heart" title="Save job">
            <svg class="jcard-heart-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>
    </div>
</article>

{{-- ═══════════════════════════════════════════════════════
     FULL variant  ─ used in "Featured Jobs" section
══════════════════════════════════════════════════════════ --}}
@else
<article class="jcard">

    {{-- ★ Featured pill --}}
    @if($job->featured)
        <div class="jcard-featured-pill">
            <svg class="jcard-featured-icon" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Featured
        </div>
    @endif

    {{-- Logo + Title + Company + Meta --}}
    <div class="jcard-row">

        {{-- Logo box with checkmark --}}
        <div class="jcard-logo">
            @if($job->company->logo)
                <img src="{{ $job->company->logo }}" alt="{{ $job->company->company_name }}">
            @else
                {{ $initials }}
            @endif
            @if($isVerified)
                <span class="jcard-verified">✓</span>
            @endif
        </div>

        {{-- Text block --}}
        <div class="jcard-text-block">
            <h3 class="jcard-title">
                <a href="{{ route('jobs.show', $job->slug) }}" class="jcard-title-link">{{ $job->title }}</a>
            </h3>

            {{-- Company + verified dot --}}
            <div class="jcard-company-row">
                <span class="jcard-company">{{ $job->company->company_name }}</span>
                @if($isVerified)
                    <span class="jcard-verified-inline">✓</span>
                @endif
            </div>

            {{-- Meta: location · type · time --}}
            <div class="jcard-meta">
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->city }}, {{ $job->country }}
                </span>
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $empType }}
                </span>
                <span class="jcard-meta-item">
                    <svg class="jcard-meta-icon-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $postedAgo }}
                </span>
            </div>
        </div>
    </div>

    {{-- Pills --}}
    <div class="jcard-pills">
        @if($isRemote)  <span class="pill pill-remote">Remote</span>  @endif
        @if($job->experience_level) <span class="pill pill-dark">{{ ucfirst($job->experience_level) }}</span> @endif
        @if($easyApply) <span class="pill pill-green">Easy Apply</span> @endif
        @foreach($job->skills->take(3) as $skill)
            <span class="pill pill-dark">{{ $skill->name }}</span>
        @endforeach
    </div>

    {{-- Divider --}}
    <div class="jcard-divider"></div>

    {{-- Footer: salary + views + heart --}}
    <div class="jcard-footer">
        <div>
            <div class="jcard-salary">
                @if($salaryLabel) {{ $salaryLabel }}
                @else <span class="jcard-salary-muted">Competitive</span> @endif
            </div>
            <div class="jcard-views">
                <svg class="jcard-views-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>{{ $views }} views &nbsp;&middot;&nbsp; 1 vacancy</span>
            </div>
        </div>
        <button type="button" class="jcard-heart" title="Save job">
            <svg class="jcard-heart-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>
    </div>
</article>
@endif
