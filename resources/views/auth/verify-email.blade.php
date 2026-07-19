<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4">
        
        <div class="mb-6 text-center">
            <!-- Mail Icon -->
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 mb-4 animate-float">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Verify Your Email</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                Thanks for joining us! Before you start searching or posting jobs, please click on the verification link we just emailed to you.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200/50 dark:border-emerald-800/30 text-emerald-800 dark:text-emerald-400 text-xs font-semibold leading-relaxed flex items-start">
                <svg class="h-4.5 w-4.5 mr-2 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>A new verification link has been sent to the email address you provided. Please check your spam folder if you can't find it.</span>
            </div>
        @endif

        <div class="space-y-4 pt-4 border-t border-gray-150 dark:border-gray-800">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 dark:text-gray-450 hover:text-rose-500 hover:underline transition-colors cursor-pointer">
                    {{ __('Sign Out / Exit') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
