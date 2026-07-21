<x-guest-layout>
    <div>
        
        <div>
            <!-- Mail Icon -->
            <div>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2>Verify Your Email</h2>
            <p>
                Thanks for joining us! Before you start searching or posting jobs, please click on the verification link we just emailed to you.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>A new verification link has been sent to the email address you provided. Please check your spam folder if you can't find it.</span>
            </div>
        @endif

        <div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    {{ __('Sign Out / Exit') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
