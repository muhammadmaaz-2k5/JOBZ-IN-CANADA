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
═══════════════════════════════════════════════════════ --}}
@if($compact)
<article class="jcard">

    {{-- ★ Featured pill --}}
    @if($job->featured)
        <div class="jcard-featured-pill">
            <svg style="width:.6rem;height:.6rem;fill:#fff;" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Featured
        </div>
    @endif

    {{-- Logo + Title --}}
    <div style="display:flex;gap:.875rem;align-items:flex-start;margin-top:{{ $job->featured ? '.75rem' : '0' }};">

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

        <div style="flex:1;min-width:0;">
            <h3 style="font-size:1rem;font-weight:700;color:#fff;margin:0 0 .25rem;line-height:1.3;">
                <a href="{{ route('jobs.show', $job->slug) }}" class="jcard-title-link">
                    {{ Str::limit($job->title, 48) }}
                </a>
            </h3>
            <div style="display:flex;align-items:center;gap:.375rem;margin-bottom:.375rem;">
                <span style="font-size:.8125rem;font-weight:500;color:rgba(255,255,255,.6);">{{ $job->company->company_name }}</span>
                @if($isVerified)
                    <span class="jcard-verified-inline">✓</span>
                @endif
            </div>
            {{-- Meta: location · type · time --}}
            <div class="jcard-meta">
                <span class="jcard-meta-item">
                    <svg style="width:.8rem;height:.8rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->city }}, {{ $job->country }}
                </span>
                <span class="jcard-meta-item">
                    <svg style="width:.8rem;height:.8rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $empType }}
                </span>
                <span class="jcard-meta-item">
                    <svg style="width:.8rem;height:.8rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <svg style="width:.75rem;height:.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>{{ $views }} views &nbsp;&middot;&nbsp; 1 vacancy</span>
            </div>
        </div>
        <button type="button" class="jcard-heart" title="Save job">
            <svg style="width:.875rem;height:.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>
    </div>
</article>

{{-- ═══════════════════════════════════════════════════════
     FULL variant  ─ used in "Featured Jobs" section
═══════════════════════════════════════════════════════ --}}
@else
<article class="jcard">

    {{-- ★ Featured pill --}}
    @if($job->featured)
        <div class="jcard-featured-pill">
            <svg style="width:.6rem;height:.6rem;fill:#fff;" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Featured
        </div>
    @endif

    {{-- Logo + Title + Company + Meta --}}
    <div style="display:flex;gap:1rem;align-items:flex-start;margin-top:{{ $job->featured ? '.75rem' : '0' }};">

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
        <div style="flex:1;min-width:0;">
            <h3 style="font-size:1.0625rem;font-weight:700;color:#fff;margin:0 0 .25rem;line-height:1.3;">
                <a href="{{ route('jobs.show', $job->slug) }}" class="jcard-title-link">{{ $job->title }}</a>
            </h3>

            {{-- Company + verified dot --}}
            <div style="display:flex;align-items:center;gap:.375rem;margin-bottom:.5rem;">
                <span style="font-size:.875rem;font-weight:500;color:rgba(255,255,255,.65);">{{ $job->company->company_name }}</span>
                @if($isVerified)
                    <span class="jcard-verified-inline">✓</span>
                @endif
            </div>

            {{-- Meta: location · type · time --}}
            <div class="jcard-meta">
                <span class="jcard-meta-item">
                    <svg style="width:.875rem;height:.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->city }}, {{ $job->country }}
                </span>
                <span class="jcard-meta-item">
                    <svg style="width:.875rem;height:.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $empType }}
                </span>
                <span class="jcard-meta-item">
                    <svg style="width:.875rem;height:.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <svg style="width:.8rem;height:.8rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span>{{ $views }} views &nbsp;&middot;&nbsp; 1 vacancy</span>
            </div>
        </div>
        <button type="button" class="jcard-heart" title="Save job">
            <svg style="width:.9375rem;height:.9375rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>
    </div>
</article>
@endif

{{-- ═══════════════════════════════════════════════════════
     COMPONENT SCOPED STYLES (injected once per page via @once)
═══════════════════════════════════════════════════════ --}}
@once
<style>
/* ── Job Card ─────────────────────────────────────── */
.jcard {
    background: #0d1221;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px;
    padding: 1.375rem 1.375rem 1.125rem;
    display: flex; flex-direction: column; gap: 1rem;
    transition: border-color .2s, box-shadow .2s, transform .2s;
    position: relative; overflow: visible;
}
.jcard:hover {
    border-color: rgba(99,102,241,.5);
    box-shadow: 0 12px 40px rgba(0,0,0,.45), 0 0 0 1px rgba(99,102,241,.12);
    transform: translateY(-3px);
}

/* ── Featured pill (hangs off top) ──────────────── */
.jcard-featured-pill {
    position: absolute; top: -1px; left: 1.125rem;
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .275rem .75rem; border-radius: 0 0 10px 10px;
    background: linear-gradient(135deg,#6366f1,#4f46e5);
    font-size: .675rem; font-weight: 700; color: #fff;
    letter-spacing: .05em; text-transform: uppercase;
    box-shadow: 0 4px 14px rgba(99,102,241,.45);
    z-index: 1;
}

/* ── Logo box ────────────────────────────────────── */
.jcard-logo {
    width: 3.25rem; height: 3.25rem;
    border-radius: 12px; flex-shrink: 0; position: relative;
    background: #1a2035;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 800; color: #a5b4fc;
    border: 1px solid rgba(99,102,241,.2);
    overflow: visible;
}
.jcard-logo img {
    width: 100%; height: 100%; object-fit: cover; border-radius: 11px;
}
.jcard-logo-sm {
    width: 2.75rem; height: 2.75rem;
    font-size: .8rem;
}
.jcard-logo-sm img { border-radius: 10px; }

/* ── Verified badge on logo ──────────────────────── */
.jcard-verified {
    position: absolute; bottom: -5px; right: -5px;
    width: 1.125rem; height: 1.125rem;
    background: #2563eb; border: 2px solid #0d1221;
    border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: .45rem; color: #fff;
    font-weight: 700;
}

/* ── Inline verified dot next to company name ────── */
.jcard-verified-inline {
    display: inline-flex; align-items: center; justify-content: center;
    width: 1rem; height: 1rem; background: #2563eb; border-radius: 50%;
    font-size: .45rem; color: #fff; font-weight: 700; flex-shrink: 0;
}

/* ── Title link ──────────────────────────────────── */
.jcard-title-link {
    color: #fff; text-decoration: none; transition: color .18s;
}
.jcard-title-link:hover { color: #818cf8; }

/* ── Meta row ────────────────────────────────────── */
.jcard-meta {
    display: flex; flex-wrap: wrap; align-items: center;
    gap: .65rem; font-size: .8rem; color: rgba(255,255,255,.4);
}
.jcard-meta-item {
    display: flex; align-items: center; gap: .3rem;
}

/* ── Pill tags ───────────────────────────────────── */
.jcard-pills { display: flex; flex-wrap: wrap; gap: .5rem; }

.pill {
    display: inline-flex; align-items: center;
    padding: .3rem .8rem; border-radius: 99px;
    font-size: .8rem; font-weight: 600; cursor: default;
    transition: all .15s;
}
.pill-outline  { border: 1px solid rgba(99,102,241,.4);  color: #818cf8; background: transparent; }
.pill-dark     { border: 1px solid rgba(255,255,255,.12); color: rgba(255,255,255,.75); background: rgba(255,255,255,.06); }
.pill-green    { border: 1px solid rgba(52,211,153,.35);  color: #34d399; background: rgba(52,211,153,.1); }
.pill-remote   { border: 1px solid rgba(99,102,241,.35);  color: #93c5fd; background: transparent; }

/* ── Divider ─────────────────────────────────────── */
.jcard-divider {
    height: 1px; background: rgba(255,255,255,.07); margin: 0 -.125rem;
}

/* ── Footer ──────────────────────────────────────── */
.jcard-footer {
    display: flex; align-items: center;
    justify-content: space-between; gap: .75rem;
}
.jcard-salary {
    font-size: 1.0625rem; font-weight: 700;
    color: #34d399; line-height: 1.2;
}
.jcard-salary-muted {
    color: rgba(255,255,255,.45); font-size: .875rem; font-weight: 500;
}
.jcard-views {
    display: flex; align-items: center; gap: .3rem;
    font-size: .75rem; color: rgba(255,255,255,.35); margin-top: .2rem;
}

/* ── Heart/bookmark button ───────────────────────── */
.jcard-heart {
    width: 2.25rem; height: 2.25rem;
    border: 1px solid rgba(255,255,255,.12); border-radius: 99px;
    background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.3); flex-shrink: 0; transition: all .18s;
}
.jcard-heart:hover {
    border-color: rgba(244,63,94,.5); color: #f43f5e;
}
</style>
@endonce