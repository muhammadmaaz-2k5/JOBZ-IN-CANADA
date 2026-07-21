<x-guest-layout>
    <div 
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
        <div>
            <a href="{{ route('login') }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Sign In
            </a>
        </div>

        <div>
            <!-- Icon Indicator -->
            <div>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2>Reset Your Password</h2>
            <p>
                Choose a strong, secure new password for your account.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required readonly />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('New Password')" />
                <input id="password" type="password" name="password" x-model="password" required autofocus />
                
                <!-- Password Strength Meter Component -->
                <div x-show="password.length > 0">
                    <div>
                        <span>Password strength:</span>
                        <span : x-text="strengthLabel"></span>
                    </div>
                    <div>
                        <div :></div>
                    </div>
                    <div>
                        <div>
                            <span :></span>
                            <span>Min 8 characters</span>
                        </div>
                        <div>
                            <span :></span>
                            <span>At least 1 uppercase</span>
                        </div>
                        <div>
                            <span :></span>
                            <span>At least 1 number</span>
                        </div>
                        <div>
                            <span :></span>
                            <span>At least 1 symbol</span>
                        </div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required />
                <div x-show="password_confirmation.length > 0">
                    <span :>
                        <span x-show="password === password_confirmation">✓ Passwords match</span>
                        <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div>
                <x-primary-button>
                    {{ __('Save New Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
