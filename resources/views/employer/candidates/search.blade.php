<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Premium Candidate Search') }}
            </h2>
            <span>
                ⚡ Premium Recruiter Database Access
            </span>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Candidate Search Filters -->
            <div>
                <form method="GET" action="{{ route('employer.candidates.search') }}">
                    <div>
                        <x-input-label for="keyword" :value="__('Skills or Keywords')" />
                        <x-text-input id="keyword" name="keyword" type="text" placeholder="e.g. Laravel, React, Manager" :value="request('keyword')" />
                    </div>
                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" placeholder="e.g. Toronto, Vancouver" :value="request('location')" />
                    </div>
                    <div>
                        <button type="submit">
                            Search Candidates
                        </button>
                    </div>
                </form>
            </div>

            <!-- Candidate Listings -->
            <div>
                @forelse($candidates as $candidate)
                    <div>
                        
                        @if($candidate->activeResumeBoost && $candidate->activeResumeBoost->isValid())
                            <span>⭐ BOOSTED</span>
                        @endif

                        <div>
                            <!-- Placeholder avatar -->
                            <div>
                                {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                            </div>
                            
                            <div>
                                <h4>
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </h4>
                                <p>
                                    {{ $candidate->jobSeekerProfile->headline ?? 'Candidate Seeker' }}
                                </p>
                                <p>
                                    📍 {{ $candidate->jobSeekerProfile->city ?? 'Toronto' }}, {{ $candidate->jobSeekerProfile->country ?? 'Canada' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('employer.candidates.show', $candidate->id) }}">
                                View Profile Details &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div>
                        <p>No candidates match your queries.</p>
                    </div>
                @endforelse

                <div>
                    {{ $candidates->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
