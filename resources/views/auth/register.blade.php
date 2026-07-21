<x-guest-layout>
    <div>
        <div>
            <h2>Join the Platform</h2>
            <p>Choose your registration pathway below to begin</p>
        </div>

        <div>
            <!-- Job Seeker Pathway Card -->
            <a href="{{ route('register.seeker') }}">
                <div>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <div>
                        <span>I'm a Job Seeker</span>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p>
                        Find and apply to verified jobs, upload resume profiles, and track applications.
                    </p>
                </div>
            </a>

            <!-- Employer Pathway Card -->
            <a href="{{ route('register.employer') }}">
                <div>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <div>
                        <span>I'm an Employer</span>
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p>
                        Publish opportunities, hire talent, access database search, and build your business.
                    </p>
                </div>
            </a>
        </div>

        <div>
            <p>
                Already registered? 
                <a href="{{ route('login') }}">Sign In</a>
            </p>
        </div>
    </div>
</x-guest-layout>
