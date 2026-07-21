<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Job;

class JobCard extends Component
{
    /** The job to display. */
    public Job $job;

    /** Two-letter uppercase initials for the company logo fallback. */
    public string $initials;

    /** Human-readable posted-ago string, e.g. "3d ago". */
    public string $postedAgo;

    /** Nicely formatted employment type, e.g. "Full-time". */
    public string $empType;

    /** Whether the company is verified. */
    public bool $isVerified;

    /** Whether this is a compact (list-row) variant. */
    public bool $compact;

    public function __construct(Job $job, bool $compact = false)
    {
        $this->job        = $job;
        $this->compact    = $compact;
        $this->initials   = strtoupper(substr($job->company->company_name ?? 'JO', 0, 2));
        $this->postedAgo  = $job->created_at
            ? $job->created_at->diffForHumans(['short' => true, 'parts' => 1])
            : '3d ago';
        $this->empType    = ucfirst(str_replace('_', '-', $job->employment_type ?? 'Full-time'));
        $this->isVerified = ($job->company->verification_status ?? '') === 'verified';
    }

    public function render()
    {
        return view('components.job-card');
    }
}
