<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $job->title }}
            </h2>
            <a href="{{ route('jobs.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Listings
            </a>
        </div>
    </x-slot>

    <!-- Structured Data (JSON-LD JobPosting Schema) -->
    @push('head')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "JobPosting",
        "title": "{{ $job->title }}",
        "description": "{!! e(strip_tags($job->description)) !!}",
        "datePosted": "{{ $job->created_at->toIso8601String() }}",
        @if($job->application_deadline)
        "validThrough": "{{ \Carbon\Carbon::parse($job->application_deadline)->toIso8601String() }}",
        @endif
        "employmentType": "{{ strtoupper($job->employment_type) }}",
        "hiringOrganization": {
            "@type": "Organization",
            "name": "{{ $job->company->company_name }}",
            "sameAs": "{{ $job->company->website }}"
        },
        "jobLocation": {
            "@type": "Place",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "{{ $job->city }}",
                "addressCountry": "{{ $job->country }}"
            }
        }
    }
    </script>
    @endpush

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Job Header Widget -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 flex items-center justify-center p-3 flex-shrink-0">
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="max-h-full max-w-full object-contain" />
                        @else
                            <span class="text-sm text-gray-400 font-extrabold">JOBZ</span>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">{{ $job->title }}</h1>
                            @if($job->urgent)
                                <span class="px-2.5 py-0.5 bg-red-100 dark:bg-red-950 text-red-650 dark:text-red-400 text-xs font-bold rounded-full">Urgent</span>
                            @endif
                        </div>
                        <p class="text-base font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            {{ $job->company->company_name }}
                            @if($job->company->verification_status === 'verified')
                                <span class="text-indigo-500 text-sm font-bold" title="Verified Employer">&check;</span>
                            @endif
                        </p>
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 flex-wrap pt-1">
                            <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                            <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                            <span>⏰ {{ ucfirst($job->employment_type) }}</span>
                            <span>📊 Views: {{ $job->views_count }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Apply/Saved buttons (we can add functionality in later phases) -->
                    <button class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition text-sm">
                        Apply Now
                    </button>
                </div>
            </div>

            <!-- Description & Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details (Job specs) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Main Body -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-6">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 mb-3">Job Description</h3>
                            <p class="text-gray-650 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $job->description }}</p>
                        </div>

                        @if($job->responsibilities)
                            <div class="border-t border-gray-100 dark:border-gray-700/50 pt-6">
                                <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 mb-3">Responsibilities</h3>
                                <p class="text-gray-650 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $job->responsibilities }}</p>
                            </div>
                        @endif

                        <div class="border-t border-gray-100 dark:border-gray-700/50 pt-6">
                            <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 mb-3">Requirements</h3>
                            <p class="text-gray-650 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $job->requirements }}</p>
                        </div>

                        @if($job->benefits)
                            <div class="border-t border-gray-100 dark:border-gray-700/50 pt-6">
                                <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 mb-3">Benefits</h3>
                                <p class="text-gray-650 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $job->benefits }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Related Jobs Recommendation -->
                    <div class="space-y-4">
                        <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100">Related Job Openings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @forelse($relatedJobs as $rel)
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-750 flex flex-col justify-between gap-3">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 truncate">
                                            <a href="{{ route('jobs.show', $rel->slug) }}">{{ $rel->title }}</a>
                                        </h4>
                                        <p class="text-2xs text-gray-500 mt-0.5 truncate">{{ $rel->company->company_name }}</p>
                                    </div>
                                    <span class="text-3xs px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full w-fit">{{ ucfirst($rel->workplace_type) }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 col-span-3">No matching related jobs found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Details (Branding, Quick Stats, Map) -->
                <div class="space-y-8">
                    <!-- Quick Stats Widget -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100">Job Summary</h3>
                        
                        <div class="space-y-3 text-xs text-gray-700 dark:text-gray-300">
                            <div class="flex justify-between border-b border-gray-50 dark:border-gray-900 pb-2">
                                <span class="font-semibold">Experience Level:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ ucfirst($job->experience_level) }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 dark:border-gray-900 pb-2">
                                <span class="font-semibold">Education Level:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ ucfirst($job->education_level) }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 dark:border-gray-900 pb-2">
                                <span class="font-semibold">Salary Visibility:</span>
                                <span class="font-bold text-gray-900 dark:text-white">
                                    @if($job->salary_visibility === 'hidden')
                                        Hidden
                                    @else
                                        {{ $job->currency }} {{ number_format($job->min_salary) }}
                                        @if($job->salary_visibility === 'range')
                                            - {{ number_format($job->max_salary) }}
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between border-b border-gray-50 dark:border-gray-900 pb-2">
                                <span class="font-semibold">Vacancies:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $job->vacancies }}</span>
                            </div>
                            @if($job->application_deadline)
                                <div class="flex justify-between">
                                    <span class="font-semibold text-red-500">Deadline:</span>
                                    <span class="font-bold text-red-600 dark:text-red-400">{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Required Skills -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100">Required Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($job->skills as $skill)
                                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-650 dark:text-indigo-400 text-xs font-bold rounded-xl">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400">No specific skills listed.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Company Summary Branding -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 text-center space-y-4">
                        <h3 class="font-extrabold text-lg text-gray-900 dark:text-gray-100 text-left">About The Company</h3>
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo" class="w-16 h-16 rounded-xl mx-auto object-contain" />
                        @endif
                        <div>
                            <h4 class="font-extrabold text-base text-gray-900 dark:text-white">{{ $job->company->company_name }}</h4>
                            <span class="text-xs text-indigo-500 font-bold block">{{ $job->company->industry }} &bull; {{ $job->company->company_size }}</span>
                        </div>
                        @if($job->company->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3 text-left leading-relaxed">{{ $job->company->description }}</p>
                        @endif
                        <div class="pt-2">
                            <a href="{{ $job->company->website }}" target="_blank" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Visit Website &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
