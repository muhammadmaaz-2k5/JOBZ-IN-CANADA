<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $job->title }} - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Structured Data (JSON-LD JobPosting & Breadcrumbs Schema) -->
    @push('head')
    <script type="application/ld+json">
    [
        {
            "@@context": "https://schema.org",
            "@@type": "JobPosting",
            "title": "{{ $job->title }}",
            "description": "{!! e(strip_tags($job->description)) !!}",
            "datePosted": "{{ $job->created_at->toIso8601String() }}",
            @if($job->application_deadline)
            "validThrough": "{{ \Carbon\Carbon::parse($job->application_deadline)->toIso8601String() }}",
            @endif
            "employmentType": "{{ strtoupper($job->employment_type) }}",
            "hiringOrganization": {
                "@@type": "Organization",
                "name": "{{ $job->company->company_name }}",
                "sameAs": "{{ $job->company->website }}"
            },
            "jobLocation": {
                "@@type": "Place",
                "address": {
                    "@@type": "PostalAddress",
                    "addressLocality": "{{ $job->city }}",
                    "addressCountry": "{{ $job->country }}"
                }
            },
            @if($job->salary_min)
            "baseSalary": {
                "@@type": "MonetaryAmount",
                "currency": "{{ $job->currency ?: 'CAD' }}",
                "value": {
                    "@@type": "QuantitativeValue",
                    "value": {{ $job->salary_min }},
                    "unitText": "{{ strtoupper($job->salary_type ?: 'YEAR') }}"
                }
            }
            @endif
        },
        {
            "@@context": "https://schema.org",
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Jobs",
                    "item": "{{ route('jobs.index') }}"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "{{ $job->title }}",
                    "item": "{{ route('jobs.show', $job->slug) }}"
                }
            ]
        }
    ]
    </script>
    @endpush
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-dark-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">

    <!-- Header Navbar (Homepage Style) -->
    <header class="glass sticky top-0 z-50 h-16 flex items-center justify-between px-6 border-b border-gray-150 dark:border-gray-800/80 shadow-glass no-print">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-2 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-primary-500 text-white font-bold">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600 dark:text-gray-300">
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 dark:hover:text-white transition-colors">Find Jobs</a>
                <a href="/#seekers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Job Seekers</a>
                <a href="/#employers" class="hover:text-primary-500 dark:hover:text-white transition-colors">For Employers</a>
            </nav>

            <!-- Actions Panel -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" class="p-2 rounded-xl bg-white dark:bg-dark-800 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" style="display: none;">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 shadow-sm transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-500 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 shadow-premium transition-colors">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs Navigation -->
            <div class="flex items-center text-[11px] font-bold text-gray-500 gap-1.5 no-print px-4 sm:px-0">
                <a href="/" class="hover:text-primary-500 transition">Home</a>
                <span>/</span>
                <a href="{{ route('jobs.index') }}" class="hover:text-primary-500 transition">Jobs</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-300">{{ $job->title }}</span>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm mx-4 sm:mx-0">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Job Header Widget -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mx-4 sm:mx-0">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-150 dark:border-gray-750 flex items-center justify-center p-2 flex-shrink-0">
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain" />
                        @else
                            <span class="text-xs text-gray-400 font-extrabold">JOBZ</span>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 leading-snug">{{ $job->title }}</h1>
                            @if($job->urgent)
                                <span class="px-2 py-0.5 bg-red-55/10 text-red-500 text-[9px] font-black rounded-full uppercase tracking-wider">Urgent</span>
                            @endif
                        </div>
                        <p class="text-xs font-extrabold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            {{ $job->company->company_name }}
                            @if($job->company->verification_status === 'verified')
                                <span class="text-primary-500 text-sm font-bold" title="Verified Employer">&check;</span>
                            @endif
                        </p>
                        <div class="flex items-center gap-3 text-[11px] text-gray-450 dark:text-gray-400 flex-wrap pt-0.5 font-semibold">
                            <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                            <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                            <span>⏰ {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                            <span>📊 Views: {{ $job->views_count }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
                    @guest
                        <a href="{{ route('login') }}" class="w-full md:w-auto px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold rounded-xl text-center shadow-premium transition text-xs uppercase tracking-wider">
                            Login to Apply
                        </a>
                    @else
                        @if(Auth::user()->hasRole('job_seeker'))
                            @php
                                $hasApplied = \App\Models\Application::where('job_id', $job->id)
                                    ->where('applicant_id', Auth::id())
                                    ->where('status', '!=', 'withdrawn')
                                    ->exists();
                                $isClosed = $job->status === 'closed' || ($job->application_deadline && \Carbon\Carbon::parse($job->application_deadline)->isPast());
                                $completeness = Auth::user()->jobSeekerProfile ? Auth::user()->jobSeekerProfile->calculateCompletionPercentage() : 0;
                            @endphp

                            @if($hasApplied)
                                <button disabled class="w-full md:w-auto px-5 py-2.5 bg-gray-250 text-gray-500 font-extrabold rounded-xl cursor-not-allowed text-xs uppercase tracking-wider">
                                    Already Applied
                                </button>
                            @elseif($isClosed)
                                <button disabled class="w-full md:w-auto px-5 py-2.5 bg-red-100 text-red-500 font-extrabold rounded-xl cursor-not-allowed text-xs uppercase tracking-wider">
                                    Application Closed
                                </button>
                            @elseif($completeness < 20)
                                <a href="{{ route('seeker.profile.edit') }}" class="w-full md:w-auto px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-extrabold rounded-xl text-center shadow-premium transition text-xs uppercase tracking-wider" title="Min 20% profile completeness required to apply">
                                    Profile Incomplete (Min 20%)
                                </a>
                            @else
                                <a href="{{ route('jobs.apply', $job->slug) }}" class="w-full md:w-auto px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold rounded-xl text-center shadow-premium transition text-xs uppercase tracking-wider">
                                    Apply Now
                                </a>
                            @endif
                        @elseif(Auth::user()->hasRole('employer') && $job->employer_id === Auth::id())
                            <a href="{{ route('employer.applicants.job', $job->id) }}" class="w-full md:w-auto px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold rounded-xl text-center shadow-premium transition text-xs uppercase tracking-wider">
                                View Applicants ({{ $job->applications_count }})
                            </a>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Detailed Grid Column Structure -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start mx-4 sm:mx-0">
                
                <!-- Left Main Content Column -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-6">
                        <div>
                            <h3 class="font-extrabold text-sm text-gray-900 dark:text-gray-100 mb-2.5 border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Job Description</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-xs leading-relaxed whitespace-pre-line">{{ $job->description }}</p>
                        </div>

                        @if($job->responsibilities)
                            <div>
                                <h3 class="font-extrabold text-sm text-gray-900 dark:text-gray-100 mb-2.5 border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Responsibilities</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-xs leading-relaxed whitespace-pre-line">{{ $job->responsibilities }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="font-extrabold text-sm text-gray-900 dark:text-gray-100 mb-2.5 border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Requirements</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-xs leading-relaxed whitespace-pre-line">{{ $job->requirements }}</p>
                        </div>

                        @if($job->benefits)
                            <div>
                                <h3 class="font-extrabold text-sm text-gray-900 dark:text-gray-100 mb-2.5 border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Benefits</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-xs leading-relaxed whitespace-pre-line">{{ $job->benefits }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Related Jobs Recommendation -->
                    <div class="space-y-4">
                        <h3 class="font-extrabold text-xs text-gray-950 dark:text-white uppercase tracking-widest pl-1">Related Opportunities</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @forelse($relatedJobs as $rel)
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-150 dark:border-gray-750 flex flex-col justify-between gap-3">
                                    <div>
                                        <h4 class="font-bold text-xs text-gray-900 dark:text-gray-100 truncate">
                                            <a href="{{ route('jobs.show', $rel->slug) }}">{{ $rel->title }}</a>
                                        </h4>
                                        <p class="text-4xs text-gray-400 mt-0.5 uppercase font-bold">{{ $rel->company->company_name }}</p>
                                    </div>
                                    <span class="text-4xs px-2.5 py-0.5 bg-gray-50 dark:bg-dark-850 text-gray-600 dark:text-gray-300 rounded-full font-bold w-fit border border-gray-100 dark:border-gray-750 uppercase">{{ ucfirst($rel->workplace_type) }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 col-span-3">No matching related jobs found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Details Panel -->
                <div class="space-y-6">
                    
                    <!-- Job Summary Statistics -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Job Summary</h3>
                        
                        <div class="space-y-3 text-xs text-gray-750 dark:text-gray-300 font-semibold">
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-750 pb-2">
                                <span>Experience Level:</span>
                                <span class="font-bold text-gray-900 dark:text-white capitalize">{{ $job->experience_level }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-750 pb-2">
                                <span>Employment:</span>
                                <span class="font-bold text-gray-900 dark:text-white capitalize">{{ str_replace('_', '-', $job->employment_type) }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-750 pb-2">
                                <span>Workplace Type:</span>
                                <span class="font-bold text-gray-900 dark:text-white capitalize">{{ $job->workplace_type }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 dark:border-gray-750 pb-2">
                                <span>Vacancies:</span>
                                <span class="font-bold text-gray-900 dark:text-white font-mono">{{ $job->vacancies }} open</span>
                            </div>
                            @if($job->application_deadline)
                                <div class="flex justify-between text-red-500 font-bold">
                                    <span>Deadline:</span>
                                    <span>{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Required Skills checklist -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">Required Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($job->skills as $skill)
                                <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-650 dark:text-indigo-400 text-xs font-bold rounded-lg border border-indigo-100/10">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400">No specific skills listed.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Employer Branding Card -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 text-center space-y-4">
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white text-left border-b border-gray-100 dark:border-gray-750 pb-2 uppercase tracking-wider">About Company</h3>
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="w-16 h-16 rounded-2xl mx-auto object-contain bg-gray-50 border border-gray-150" />
                        @endif
                        <div>
                            <h4 class="font-extrabold text-sm text-gray-950 dark:text-white">
                                <a href="{{ route('companies.show', $job->company->slug) }}" class="hover:text-primary-500 transition">{{ $job->company->company_name }}</a>
                            </h4>
                            <span class="text-4xs text-gray-400 font-bold uppercase tracking-wider block mt-0.5">{{ $job->company->industry }} &bull; {{ $job->company->company_size }}</span>
                        </div>
                        @if($job->company->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3 text-left leading-relaxed font-semibold">{{ $job->company->description }}</p>
                        @endif
                        <div class="pt-2 text-left border-t border-gray-100 dark:border-gray-750">
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="text-xs font-extrabold text-primary-500 hover:underline">View Company Profile &rarr;</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-150 dark:border-gray-850 mt-12 bg-white dark:bg-dark-900/50 no-print">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
            <p>© {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
