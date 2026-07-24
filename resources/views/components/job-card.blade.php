@php
    $isRemote    = ($job->workplace_type ?? '') === 'remote' || strtolower($job->location ?? '') === 'remote';
    $easyApply   = $job->screeningQuestions->count() === 0;
    
    // Formatting salary
    $salaryLabel = null;
    $period = $job->salary_period === 'monthly' ? 'mo' : 
             ($job->salary_period === 'yearly' ? 'yr' : 
             ($job->salary_period === 'hourly' ? 'hr' : 'mo'));

    if ($job->salary_min && $job->salary_max) {
        // If it's a large number, we can use 'k' format, but let's just use number_format for accuracy since some salaries might be hourly/monthly
        $salaryLabel = '$' . number_format($job->salary_min) . ' – $' . number_format($job->salary_max) . ' /' . $period;
    } elseif ($job->salary_min) {
        $salaryLabel = 'From $' . number_format($job->salary_min) . ' /' . $period;
    }
@endphp

<article class="jcard-new relative hover:ring-2 hover:ring-indigo-500 hover:ring-offset-2 transition-all {{ $job->featured ? 'bg-indigo-50/50 dark:bg-indigo-900/10 border-indigo-200 dark:border-indigo-800' : '' }}">
    <div class="jcard-top flex items-center justify-between w-full">
        <div class="flex items-center gap-2">
            @if($job->featured)
                <span class="jcard-pill-blue bg-gradient-to-r from-indigo-500 to-purple-500 text-white border-transparent">✨ Promoted</span>
            @endif
            @if($easyApply)
                <span class="jcard-pill-blue">Easily apply</span>
            @endif
        </div>
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

    <div class="jcard-bottom mt-4 flex flex-wrap gap-2">
        @if($salaryLabel)
            <span class="jcard-pill-gray">{{ $salaryLabel }}</span>
        @endif
        <span class="jcard-pill-gray">{{ ucfirst(str_replace('-', ' ', $job->employment_type ?? 'Full time')) }}</span>
        @if($isRemote)
            <span class="jcard-pill-gray">Remote</span>
        @endif
    </div>
</article>
