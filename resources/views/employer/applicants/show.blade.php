<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Review Candidate: ') }} {{ $application->applicant->first_name }} {{ $application->applicant->last_name }}
            </h2>
            <a href="{{ route('employer.applicants.index') }}">
                &larr; Back to Applicant List
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Candidate Summary Header Card -->
            <div>
                <div>
                    <div>
                        @if($application->applicant->jobSeekerProfile && $application->applicant->jobSeekerProfile->profile_photo)
                            <img src="{{ asset('storage/' . $application->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" />
                        @else
                            {{ substr($application->applicant->first_name, 0, 1) }}{{ substr($application->applicant->last_name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h3>{{ $application->applicant->first_name }} {{ $application->applicant->last_name }}</h3>
                        <p>{{ $application->applicant->jobSeekerProfile->headline ?? 'Job Seeker' }}</p>
                        <p>Applied for **{{ $application->job->title }}** on {{ $application->applied_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('employer.applicants.download', $application->id) }}">
                        Download Submitted Resume
                    </a>
                </div>
            </div>

            <!-- Main Work Panels -->
            <div>
                <!-- Left column: Candidate Profile & Experience -->
                <div>
                    
                    <!-- Cover Letter -->
                    <div>
                        <h4>Cover Letter</h4>
                        @if($application->cover_letter)
                            <p>{{ $application->cover_letter }}</p>
                        @else
                            <p>No cover letter was submitted.</p>
                        @endif
                    </div>

                    <!-- Screening Responses -->
                    <div>
                        <h4>Screening Questions Responses</h4>
                        <div>
                            @forelse($application->screeningAnswers as $ans)
                                <div>
                                    <p>{{ $ans->question->question_text }}</p>
                                    <p>{{ $ans->answer }}</p>
                                </div>
                            @empty
                                <p>No screening questions were asked.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Work History & Education Resume Details -->
                    <div>
                        <h4>Professional Background</h4>

                        <!-- Experience -->
                        <div>
                            <h5>Work Experience</h5>
                            @forelse($application->applicant->experiences as $exp)
                                <div>
                                    <h6>{{ $exp->job_title }} at {{ $exp->company_name }}</h6>
                                    <p>{{ $exp->start_date }} - {{ $exp->currently_work_here ? 'Present' : $exp->end_date }} &bull; {{ $exp->city }}, {{ $exp->country }}</p>
                                    <p>{{ $exp->description }}</p>
                                </div>
                            @empty
                                <p>No experience entries listed.</p>
                            @endforelse
                        </div>

                        <!-- Education -->
                        <div>
                            <h5>Education</h5>
                            @forelse($application->applicant->education as $edu)
                                <div>
                                    <h6>{{ $edu->degree }} in {{ $edu->field_of_study }}</h6>
                                    <p>{{ $edu->school_name }}</p>
                                    <p>{{ $edu->start_date }} - {{ $edu->currently_studying ? 'Present' : $edu->end_date }}</p>
                                </div>
                            @empty
                                <p>No education entries listed.</p>
                            @endforelse
                        </div>

                        <!-- Skills -->
                        <div>
                            <h5>Skills</h5>
                            <div>
                                @forelse($application->applicant->skills as $sk)
                                    <span>{{ $sk->name }}</span>
                                @empty
                                    <span>No skills listed.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Notes & Status Updates -->
                <div>
                    
                    <!-- Status Actions Form -->
                    <div>
                        <h4>Hiring Stage Status</h4>
                        
                        <form method="POST" action="{{ route('employer.applicants.status', $application->id) }}">
                            @csrf
                            
                            <!-- Quick Action Buttons -->
                            <div>
                                <button type="button" onclick="document.getElementById('status_select').value = 'shortlisted'">Shortlist</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'rejected'">Reject</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'hired'">Hire</button>
                                <button type="button" onclick="document.getElementById('status_select').value = 'interview_scheduled'">Interview</button>
                            </div>

                            <div>
                                <x-input-label for="status_select" :value="__('Change Status')" />
                                <select id="status_select" name="status">
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
                                <textarea id="remarks" name="remarks" rows="3" placeholder="e.g. Schedule for technical screening on Tuesday..."></textarea>
                            </div>

                            <button type="submit">
                                Update Hiring Stage
                            </button>
                        </form>
                    </div>

                    <!-- Internal Notes -->
                    <div>
                        <h4>Internal Notes (Private)</h4>
                        
                        <!-- Notes list -->
                        <div>
                            @forelse($application->notes as $note)
                                <div>
                                    <p>{{ $note->note }}</p>
                                    <span>Posted by {{ $note->employer->first_name }} on {{ $note->created_at->format('M d, h:i A') }}</span>
                                </div>
                            @empty
                                <p>No notes added yet.</p>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('employer.applicants.note', $application->id) }}">
                            @csrf
                            <textarea name="note" rows="2" placeholder="Add private note..." required></textarea>
                            <button type="submit">
                                Add Note
                            </button>
                        </form>
                    </div>

                    <!-- History Timeline -->
                    <div>
                        <h4>Activity Timeline</h4>
                        <div>
                            @foreach($application->statusHistory as $hist)
                                <div>
                                    <div></div>
                                    <p>{{ $hist->changed_at->format('M d, Y - h:i A') }}</p>
                                    <h5>{{ str_replace('_', ' ', $hist->new_status) }}</h5>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
