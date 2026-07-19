<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4" 
         x-data="{ 
            password: '',
            password_confirmation: '',
            get strengthScore() {
                let score = 0;
                if (this.password.length >= 8) score++;
                if (/[A-Z]/.test(this.password)) score++;
                if (/[0-9]/.test(this.password)) score++;
                if (/[^A-Za-z0-9]/.test(this.password)) score++;
                return score;
            },
            get strengthLabel() {
                if (!this.password) return 'Not Entered';
                let s = this.strengthScore;
                if (s <= 1) return 'Weak';
                if (s <= 3) return 'Medium';
                return 'Strong';
            },
            get strengthClass() {
                let s = this.strengthScore;
                if (s <= 1) return 'bg-rose-500 w-1/3';
                if (s <= 3) return 'bg-amber-500 w-2/3';
                return 'bg-emerald-500 w-full';
            },
            get labelClass() {
                let s = this.strengthScore;
                if (s <= 1) return 'text-rose-500';
                if (s <= 3) return 'text-amber-500';
                return 'text-emerald-500';
            }
         }"
    >
        
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Reset Your Password</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                Choose a strong, secure new password for your account.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email', $request->email)" required readonly />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('New Password')" />
                <input id="password" type="password" name="password" x-model="password" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm" required autofocus />
                
                <!-- Password Strength Meter Component -->
                <div class="mt-2 space-y-1.5" x-show="password.length > 0" style="display: none;">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 dark:text-gray-400">Password strength:</span>
                        <span class="font-bold" :class="labelClass" x-text="strengthLabel"></span>
                    </div>
                    <div class="h-1.5 w-full bg-gray-100 dark:bg-dark-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300" :class="strengthClass"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[10px] text-gray-500">
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="password.length >= 8 ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-dark-600'"></span>
                            <span>Min 8 characters</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="/[A-Z]/.test(password) ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-dark-600'"></span>
                            <span>At least 1 uppercase</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="/[0-9]/.test(password) ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-dark-600'"></span>
                            <span>At least 1 number</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="/[^A-Za-z0-9]/.test(password) ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-dark-600'"></span>
                            <span>At least 1 symbol</span>
                        </div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm" required />
                <div class="mt-1 flex items-center justify-end" x-show="password_confirmation.length > 0" style="display: none;">
                    <span class="text-[10px] font-semibold" :class="password === password_confirmation ? 'text-emerald-500' : 'text-rose-500'">
                        <span x-show="password === password_confirmation">✓ Passwords match</span>
                        <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Save New Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
