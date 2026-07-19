<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4">
        
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-semibold text-gray-500 dark:text-gray-450 hover:text-primary-500 transition-colors">
                <svg class="h-4.5 w-4.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Sign In
            </a>
        </div>

        <div class="mb-6 text-center">
            <!-- Icon Indicator -->
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                No worries! Just enter your registered email address and we'll send you a secure password reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-xs font-semibold" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Registered Email')" />
                <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Send Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
