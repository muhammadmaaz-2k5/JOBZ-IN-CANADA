<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ $candidate->first_name }} {{ $candidate->last_name }}
            </h2>
            <a href="{{ route('employer.candidates.search') }}">
                &larr; Back to Candidate Database
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Profile Overview Panel -->
            <div>
                <div>
                    <div>
                        {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h3>{{ $candidate->first_name }} {{ $candidate->last_name }}</h3>
                        <p>{{ $candidate->jobSeekerProfile->headline ?? 'Headline not specified' }}</p>
                        <p>📍 {{ $candidate->jobSeekerProfile->city ?? 'Toronto' }}, {{ $candidate->jobSeekerProfile->country ?? 'Canada' }}</p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('employer.candidates.download-resume', $candidate->id) }}">
                        Download Candidate Resume
                    </a>
                </div>
            </div>

            <!-- About / Bio panel -->
            <div>
                <h4>About Me / Bio</h4>
                <p>
                    {{ $candidate->jobSeekerProfile->about_me ?? 'No profile description provided.' }}
                </p>
            </div>

            <!-- Skills panel -->
            <div>
                <h4>Professional Skills</h4>
                <div>
                    @forelse(explode(',', $candidate->jobSeekerProfile->skills ?? '') as $skill)
                        @if(trim($skill))
                            <span>
                                {{ trim($skill) }}
                            </span>
                        @endif
                    @empty
                        <span>No skills listed yet.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
