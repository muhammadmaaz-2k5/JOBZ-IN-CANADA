<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Application Details: ') }} {{ $application->job->title }}
            </h2>
            <a href="{{ route('seeker.applications.index') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Summary Card -->
            <div>
                <div>
                    <h3>{{ $application->job->title }}</h3>
                    <p>{{ $application->job->company->company_name }}</p>
                    <div>
                        <span>Applied on: {{ \Carbon\Carbon::parse($application->applied_at)->format('M d, Y') }}</span>
                        <span>&bull;</span>
                        <span>Resume used: <a href="{{ route('seeker.applications.download', $application->id) }}">{{ $application->resume->title }}</a></span>
                    </div>
                </div>

                <div>
                    <span>
                        {{ str_replace('_', ' ', $application->status) }}
                    </span>
                </div>
            </div>

            <div>
                <!-- Left Column: Details -->
                <div>
                    
                    <!-- Cover Letter Panel -->
                    <div>
                        <h4>Cover Letter</h4>
                        @if($application->cover_letter)
                            <p>{{ $application->cover_letter }}</p>
                        @else
                            <p>No cover letter was submitted with this application.</p>
                        @endif
                    </div>

                    <!-- Screening Answers Panel -->
                    <div>
                        <h4>Screening Answers</h4>
                        <div>
                            @forelse($application->screeningAnswers as $ans)
                                <div>
                                    <p>{{ $ans->question->question_text }}</p>
                                    <p>{{ $ans->answer }}</p>
                                </div>
                            @empty
                                <p>No screening questions were defined for this opening.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status Log Timeline -->
                <div>
                    <div>
                        <h4>Status Timeline</h4>
                        
                        <div>
                            @foreach($application->statusHistory as $hist)
                                <div>
                                    <div></div>
                                    <p>{{ $hist->changed_at->format('M d, Y - h:i A') }}</p>
                                    <h5>{{ str_replace('_', ' ', $hist->new_status) }}</h5>
                                    @if($hist->remarks)
                                        <p>"{{ $hist->remarks }}"</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
