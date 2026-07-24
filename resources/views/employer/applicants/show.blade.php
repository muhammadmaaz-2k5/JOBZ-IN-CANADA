<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('employer.applicants.index') }}" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:shadow-md transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                        {{ __('Candidate Profile') }}
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm mt-1">Reviewing application for <span class="font-bold text-gray-700 dark:text-gray-300">{{ $application->job->title }}</span></p>
                </div>
            </div>
            
            <a href="{{ route('employer.applicants.pipeline.all') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                View Pipeline
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 dark:bg-[#0f172a] min-h-screen relative overflow-hidden">
        
        <!-- Ambient Background -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-500/10 to-transparent dark:from-blue-900/20 z-0 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 relative z-10">

            @if(session('success'))
                <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-400 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Candidate Summary Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-10 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                
                <div class="relative flex flex-col lg:flex-row items-center lg:items-start justify-between gap-8">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left w-full">
                        <div class="w-28 h-28 shrink-0 rounded-2xl shadow-lg border-4 border-white dark:border-gray-700 overflow-hidden bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center relative group-hover:scale-105 transition-transform duration-300">
                            @if($application->applicant->jobSeekerProfile && $application->applicant->jobSeekerProfile->profile_photo)
                                <img src="{{ Str::startsWith($application->applicant->jobSeekerProfile->profile_photo, ['http://', 'https://']) ? $application->applicant->jobSeekerProfile->profile_photo : asset('storage/' . $application->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" class="w-full h-full object-cover" />
                            @else
                                <span class="text-4xl font-black text-blue-600 dark:text-blue-500 tracking-tighter">
                                    {{ substr($application->applicant->first_name, 0, 1) }}{{ substr($application->applicant->last_name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $application->applicant->first_name }} {{ $application->applicant->last_name }}</h3>
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $application->applicant->jobSeekerProfile->headline ?? 'Professional Job Seeker' }}</p>
                            </div>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Applied on {{ $application->applied_at->format('M d, Y') }}
                                </span>
                                @if($application->applicant->city || $application->applicant->country)
                                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $application->applicant->city }}{{ $application->applicant->city && $application->applicant->country ? ', ' : '' }}{{ $application->applicant->country }}
                                    </span>
                                @endif
                                @if($application->applicant->phone)
                                    <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                        {{ $application->applicant->phone }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    {{ $application->applicant->email }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0 w-full lg:w-auto flex flex-col items-center lg:items-end gap-3">
                        @php
                            $statusColors = [
                                'applied' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                                'pending_review' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
                                'shortlisted' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
                                'offered' => 'bg-pink-100 text-pink-800 border-pink-200 dark:bg-pink-900/30 dark:text-pink-400 dark:border-pink-800',
                                'hired' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                                'rejected' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800'
                            ];
                            $currentColor = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-400';
                        @endphp
                        <span class="px-4 py-2 text-sm font-black uppercase tracking-wider rounded-xl border {{ $currentColor }} shadow-sm">
                            {{ str_replace('_', ' ', $application->status) }}
                        </span>
                        
                        <a href="{{ route('employer.applicants.download', $application->id) }}" class="inline-flex items-center justify-center w-full lg:w-auto gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Download Resume
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Work Panels -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                
                <!-- Left column: Candidate Profile & Experience -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- Cover Letter -->
                    @if($application->cover_letter)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5 text-gray-900 dark:text-white pointer-events-none">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        </div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Cover Letter
                        </h4>
                        <div class="relative z-10 text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line font-medium bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                    @endif

                    <!-- Screening Responses -->
                    @if($application->screeningAnswers->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Screening Responses
                        </h4>
                        <div class="space-y-4">
                            @foreach($application->screeningAnswers as $ans)
                                <div class="p-5 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                                    <p class="font-bold text-gray-900 dark:text-white mb-2 pb-2 border-b border-gray-200 dark:border-gray-700">Q: {{ $ans->question->question_text }}</p>
                                    <p class="text-gray-600 dark:text-gray-300 font-medium">A: {{ $ans->answer }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Professional Background -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 space-y-10">
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white pb-4 border-b border-gray-100 dark:border-gray-700/50">Professional Background</h4>

                        <!-- Experience -->
                        <div>
                            <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <span class="p-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                                Work Experience
                            </h5>
                            <div class="space-y-6">
                                @forelse($application->applicant->experiences as $exp)
                                    <div class="relative pl-6 pb-6 border-l-2 border-indigo-100 dark:border-indigo-900/50 last:border-transparent last:pb-0">
                                        <div class="absolute -left-[9px] top-1 w-4 h-4 bg-white dark:bg-gray-800 border-4 border-indigo-500 rounded-full"></div>
                                        <h6 class="text-xl font-bold text-gray-900 dark:text-white">{{ $exp->job_title }}</h6>
                                        <p class="font-bold text-indigo-600 dark:text-indigo-400 my-1">{{ $exp->company_name }}</p>
                                        <p class="text-sm font-medium text-gray-500 mb-3">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->currently_work_here ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }} &bull; {{ $exp->city }}, {{ $exp->country }}</p>
                                        @if($exp->description)
                                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl text-sm">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                        <p class="text-gray-500 font-medium">No experience entries listed.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Education -->
                        <div>
                            <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <span class="p-1.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg></span>
                                Education
                            </h5>
                            <div class="space-y-6">
                                @forelse($application->applicant->education as $edu)
                                    <div class="relative pl-6 pb-6 border-l-2 border-green-100 dark:border-green-900/50 last:border-transparent last:pb-0">
                                        <div class="absolute -left-[9px] top-1 w-4 h-4 bg-white dark:bg-gray-800 border-4 border-green-500 rounded-full"></div>
                                        <h6 class="text-xl font-bold text-gray-900 dark:text-white">{{ $edu->degree }} <span class="text-green-600 dark:text-green-400">in {{ $edu->field_of_study }}</span></h6>
                                        <p class="font-bold text-gray-700 dark:text-gray-300 my-1">{{ $edu->school_name }}</p>
                                        <p class="text-sm font-medium text-gray-500">{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - {{ $edu->currently_studying ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}</p>
                                    </div>
                                @empty
                                    <div class="text-center py-6 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                        <p class="text-gray-500 font-medium">No education entries listed.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Skills -->
                        <div>
                            <h5 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="p-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></span>
                                Core Skills
                            </h5>
                            <div class="flex flex-wrap gap-2">
                                @forelse($application->applicant->skills as $sk)
                                    <span class="inline-flex px-3 py-1.5 bg-gray-100 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold text-sm shadow-sm">{{ $sk->name }}</span>
                                @empty
                                    <span class="text-gray-500 font-medium italic">No skills listed.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Notes & Status Updates -->
                <div class="space-y-8">
                    
                    <!-- Status Actions Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 sticky top-6">
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Hiring Stage
                        </h4>
                        
                        <form method="POST" action="{{ route('employer.applicants.status', $application->id) }}" class="space-y-5">
                            @csrf
                            
                            <!-- Quick Action Buttons -->
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button" onclick="document.getElementById('status_select').value = 'shortlisted'" class="px-2 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl transition-colors">Shortlist</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'hired'" class="px-2 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition-colors">Hire</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'rejected'" class="px-2 py-2 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-colors">Reject</button>
                            </div>

                            <div>
                                <label for="status_select" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Change Status</label>
                                <select id="status_select" name="status" class="w-full dark:bg-gray-900/50 font-medium form-input-premium">
                                    @foreach([
                                        'applied' => 'Applied',
                                        'pending_review' => 'Pending Review',
                                        'shortlisted' => 'Shortlisted',
                                        'offered' => 'Offered',
                                        'hired' => 'Hired',
                                        'rejected' => 'Rejected'
                                    ] as $key => $lbl)
                                        <option value="{{ $key }}" @selected($application->status == $key)>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="remarks" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Remarks / Reason (Optional)</label>
                                <textarea id="remarks" name="remarks" rows="3" placeholder="e.g. Needs technical screening..." class="w-full dark:bg-gray-900/50 text-sm form-input-premium"></textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                Update Stage
                            </button>
                        </form>
                    </div>

                    <!-- Internal Notes -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Internal Notes (Private)
                        </h4>
                        
                        <!-- Notes list -->
                        <div class="space-y-4 max-h-64 overflow-y-auto pr-2 mb-6 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                            @forelse($application->notes as $note)
                                <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/30 p-4 rounded-2xl relative">
                                    <p class="text-gray-800 dark:text-gray-200 text-sm font-medium leading-relaxed">{{ $note->note }}</p>
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center justify-between">
                                        <span class="font-bold text-yellow-700 dark:text-yellow-500">{{ $note->employer->first_name }}</span>
                                        <span>{{ $note->created_at->format('M d, h:i A') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-500 text-sm font-medium">No internal notes added yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('employer.applicants.note', $application->id) }}" class="space-y-3">
                            @csrf
                            <textarea name="note" rows="2" placeholder="Add private note..." required class="w-full dark:bg-gray-900/50 focus:ring-yellow-500 focus:border-yellow-500 text-sm form-input-premium"></textarea>
                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                                Add Note
                            </button>
                        </form>
                    </div>

                    <!-- History Timeline -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <h4 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Activity Timeline
                        </h4>
                        <div class="space-y-4 pl-2">
                            @foreach($application->statusHistory as $hist)
                                <div class="relative pl-6 border-l-2 border-gray-200 dark:border-gray-700 pb-4 last:border-transparent last:pb-0">
                                    <div class="absolute -left-[9px] top-1 w-4 h-4 bg-white dark:bg-gray-800 border-4 border-gray-400 rounded-full"></div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ $hist->changed_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-sm font-black text-gray-900 dark:text-white">{{ str_replace('_', ' ', $hist->new_status) }}</h5>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
