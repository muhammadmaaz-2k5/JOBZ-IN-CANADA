@php
    $isRemote    = ($job->workplace_type ?? '') === 'remote' || strtolower($job->location ?? '') === 'remote';
    $easyApply   = $job->screeningQuestions->count() === 0;
    
    // Formatting salary
    $salaryLabel = null;
    if ($job->salary_min) {
        $salaryLabel = '$' . number_format($job->salary_min / 1000) . 'k – $' . number_format($job->salary_max / 1000) . 'k /yr';
    }
@endphp

<article class="jcard-new relative hover:ring-2 hover:ring-indigo-500 hover:ring-offset-2 transition-all">
    <div class="jcard-top">
        @if($easyApply)
            <span class="jcard-pill-blue">Easily apply</span>
        @else
            <div></div>
        @endif
        <button type="button" class="jcard-bookmark-btn relative z-10" title="Save job">
            <svg class="jcard-bookmark-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
        </button>
    </div>

    <div class="jcard-content">
        <h3 class="jcard-title">
            <a href="{{ route('jobs.show', $job->slug) }}" class="before:absolute before:inset-0">{{ $job->title }}</a>
        </h3>
        <div class="jcard-company">{{ $job->company->company_name ?? 'Company Name' }}</div>
        <div class="jcard-location">{{ $job->city ?? 'Location' }}</div>
    </div>

    <div class="jcard-bottom">
        @if($salaryLabel)
            <span class="jcard-pill-gray">{{ $salaryLabel }}</span>
        @endif
        <span class="jcard-pill-gray">{{ $empType ?? 'Full-time' }}</span>
        @if($isRemote)
            <span class="jcard-pill-gray">Remote</span>
        @endif
    </div>
</article>
