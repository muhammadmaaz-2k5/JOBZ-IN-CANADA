<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Review Candidate: ') }} {{ $application->applicant->first_name }} {{ $application->applicant->last_name }}
            </h2>
            <a href="{{ route('employer.applicants.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Applicant List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Candidate Summary Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center font-extrabold text-lg text-gray-400">
                        @if($application->applicant->jobSeekerProfile && $application->applicant->jobSeekerProfile->profile_photo)
                            <img src="{{ asset('storage/' . $application->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" class="w-full h-full rounded-full object-cover" />
                        @else
                            {{ substr($application->applicant->first_name, 0, 1) }}{{ substr($application->applicant->last_name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $application->applicant->first_name }} {{ $application->applicant->last_name }}</h3>
                        <p class="text-sm text-indigo-500 font-bold">{{ $application->applicant->jobSeekerProfile->headline ?? 'Job Seeker' }}</p>
                        <p class="text-xs text-gray-550 dark:text-gray-400 mt-1">Applied for **{{ $application->job->title }}** on {{ $application->applied_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('employer.applicants.download', $application->id) }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-755 text-white font-bold rounded-xl text-sm transition shadow">
                        Download Submitted Resume
                    </a>
                </div>
            </div>

            <!-- Main Work Panels -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left column: Candidate Profile & Experience -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Cover Letter -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Cover Letter</h4>
                        @if($application->cover_letter)
                            <p class="text-sm text-gray-650 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $application->cover_letter }}</p>
                        @else
                            <p class="text-xs text-gray-400 italic">No cover letter was submitted.</p>
                        @endif
                    </div>

                    <!-- Screening Responses -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Screening Questions Responses</h4>
                        <div class="space-y-4">
                            @forelse($application->screeningAnswers as $ans)
                                <div class="space-y-1">
                                    <p class="text-xs font-extrabold text-gray-550">{{ $ans->question->question_text }}</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-950 p-3 rounded-xl border border-gray-150 dark:border-gray-850">{{ $ans->answer }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No screening questions were asked.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Work History & Education Resume Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Professional Background</h4>

                        <!-- Experience -->
                        <div class="space-y-4">
                            <h5 class="font-bold text-sm text-gray-500 uppercase">Work Experience</h5>
                            @forelse($application->applicant->experiences as $exp)
                                <div class="border-l-2 border-gray-100 dark:border-gray-700 ps-4 space-y-1">
                                    <h6 class="font-bold text-gray-900 dark:text-white text-sm">{{ $exp->job_title }} at {{ $exp->company_name }}</h6>
                                    <p class="text-2xs text-gray-400">{{ $exp->start_date }} - {{ $exp->currently_work_here ? 'Present' : $exp->end_date }} &bull; {{ $exp->city }}, {{ $exp->country }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $exp->description }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No experience entries listed.</p>
                            @endforelse
                        </div>

                        <!-- Education -->
                        <div class="space-y-4 border-t border-gray-100 dark:border-gray-705 pt-6">
                            <h5 class="font-bold text-sm text-gray-500 uppercase">Education</h5>
                            @forelse($application->applicant->education as $edu)
                                <div class="border-l-2 border-gray-100 dark:border-gray-700 ps-4 space-y-0.5">
                                    <h6 class="font-bold text-gray-900 dark:text-white text-sm">{{ $edu->degree }} in {{ $edu->field_of_study }}</h6>
                                    <p class="text-xs text-gray-700 dark:text-gray-300 font-semibold">{{ $edu->school_name }}</p>
                                    <p class="text-2xs text-gray-400">{{ $edu->start_date }} - {{ $edu->currently_studying ? 'Present' : $edu->end_date }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No education entries listed.</p>
                            @endforelse
                        </div>

                        <!-- Skills -->
                        <div class="space-y-3 border-t border-gray-100 dark:border-gray-705 pt-6">
                            <h5 class="font-bold text-sm text-gray-500 uppercase">Skills</h5>
                            <div class="flex flex-wrap gap-2">
                                @forelse($application->applicant->skills as $sk)
                                    <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950 text-indigo-750 dark:text-indigo-400 text-xs font-bold rounded-xl">{{ $sk->name }}</span>
                                @empty
                                    <span class="text-xs text-gray-400">No skills listed.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Notes & Status Updates -->
                <div class="space-y-6">
                    
                    <!-- Status Actions Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Hiring Stage Status</h4>
                        
                        <form method="POST" action="{{ route('employer.applicants.status', $application->id) }}" class="space-y-4">
                            @csrf
                            
                            <!-- Quick Action Buttons -->
                            <div class="grid grid-cols-2 gap-2 mb-2 no-print">
                                <button type="button" onclick="document.getElementById('status_select').value = 'shortlisted'" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/20 text-indigo-650 dark:text-indigo-400 font-bold rounded-lg text-[10px] uppercase transition">Shortlist</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'rejected'" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 text-red-655 dark:text-red-400 font-bold rounded-lg text-[10px] uppercase transition">Reject</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'hired'" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/20 text-emerald-650 dark:text-emerald-400 font-bold rounded-lg text-[10px] uppercase transition">Hire</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'interview_scheduled'" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/20 text-amber-650 dark:text-amber-400 font-bold rounded-lg text-[10px] uppercase transition">Interview</button>
                            </div>

                            <div>
                                <x-input-label for="status_select" :value="__('Change Status')" />
                                <select id="status_select" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl">
                                    @foreach([
                                        'applied' => 'Applied',
                                        'pending_review' => 'Pending Review',
                                        'shortlisted' => 'Shortlisted',
                                        'interview_scheduled' => 'Interview Scheduled',
                                        'interview_completed' => 'Interview Completed',
                                        'offered' => 'Offered',
                                        'hired' => 'Hired',
                                        'rejected' => 'Rejected'
                                    ] as $key => $lbl)
                                        <option value="{{ $key }}" @selected($application->status == $key)>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="remarks" :value="__('Remarks / Reason (Optional)')" />
                                <textarea id="remarks" name="remarks" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" placeholder="e.g. Schedule for technical screening on Tuesday..."></textarea>
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition shadow-sm">
                                Update Hiring Stage
                            </button>
                        </form>
                    </div>

                    <!-- Internal Notes -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Internal Notes (Private)</h4>
                        
                        <!-- Notes list -->
                        <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                            @forelse($application->notes as $note)
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 space-y-1">
                                    <p class="text-xs text-gray-650 dark:text-gray-300 leading-relaxed">{{ $note->note }}</p>
                                    <span class="text-3xs text-gray-400 block font-semibold">Posted by {{ $note->employer->first_name }} on {{ $note->created_at->format('M d, h:i A') }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No notes added yet.</p>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('employer.applicants.note', $application->id) }}" class="space-y-3 pt-2">
                            @csrf
                            <textarea name="note" rows="2" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" placeholder="Add private note..." required></textarea>
                            <button type="submit" class="px-4 py-1.5 bg-gray-150 hover:bg-gray-200 dark:bg-gray-900 dark:hover:bg-gray-950 text-gray-750 dark:text-gray-200 font-bold rounded-xl text-2xs transition">
                                Add Note
                            </button>
                        </form>
                    </div>

                    <!-- History Timeline -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Activity Timeline</h4>
                        <div class="relative border-s border-gray-200 dark:border-gray-700 ms-3 space-y-6 pt-2 pb-2">
                            @foreach($application->statusHistory as $hist)
                                <div class="mb-4 ms-4 relative">
                                    <div class="absolute -left-6 top-1.5 w-3 h-3 bg-indigo-600 rounded-full border border-white dark:border-gray-850"></div>
                                    <p class="text-3xs text-gray-400">{{ $hist->changed_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-xs font-bold text-gray-900 dark:text-white uppercase mt-0.5">{{ str_replace('_', ' ', $hist->new_status) }}</h5>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
