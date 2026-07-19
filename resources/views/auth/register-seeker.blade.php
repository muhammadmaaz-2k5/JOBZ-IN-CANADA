<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4" 
         x-data="{ 
            role: 'job_seeker',
            password: '',
            password_confirmation: '',
            country: 'Canada',
            phone_code: '+1',
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
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center space-x-2 font-extrabold text-xl tracking-tight text-primary-600 dark:text-white mb-4">
                <span class="grid place-items-center w-7 h-7 rounded-lg bg-primary-500 text-white font-bold text-sm">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Seeker Account</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Join top candidates hiring in Canada</p>
        </div>

        <!-- Social Login Buttons Component -->
        <div class="mb-6 grid grid-cols-2 gap-3">
            <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 text-sm font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm cursor-pointer">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                        <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                        <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                    </g>
                </svg>
                Google
            </a>
            <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 text-sm font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm cursor-pointer">
                <svg class="h-5 w-5 mr-2 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
                LinkedIn
            </a>
        </div>

        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-150 dark:border-gray-800"></div>
            </div>
            <span class="relative bg-white dark:bg-dark-800 px-3 text-xs text-gray-400 font-semibold uppercase">Or signup with email</span>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="job_seeker">

            <!-- Name Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
            </div>

            <!-- Email address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Country Selector -->
            <div>
                <x-input-label for="country" :value="__('Country of Residence')" />
                <div class="relative mt-1">
                    <select id="country" name="country" x-model="country" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors appearance-none">
                        <option value="Canada">🇨🇦 Canada</option>
                        <option value="United States">🇺🇸 United States</option>
                        <option value="United Kingdom">🇬🇧 United Kingdom</option>
                        <option value="India">🇮🇳 India</option>
                        <option value="Pakistan">🇵🇰 Pakistan</option>
                        <option value="Australia">🇦🇺 Australia</option>
                        <option value="France">🇫🇷 France</option>
                        <option value="Germany">🇩🇪 Germany</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>

            <!-- Phone Input Component -->
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <div class="flex mt-1 rounded-xl shadow-sm">
                    <div class="relative">
                        <select x-model="phone_code" class="h-full px-3 py-2.5 rounded-l-xl border border-r-0 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-dark-850 text-gray-800 dark:text-gray-200 focus:border-primary-500 focus:outline-none text-sm appearance-none pr-6">
                            <option value="+1">🇨🇦 +1</option>
                            <option value="+1-us">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+91">🇮🇳 +91</option>
                            <option value="+92">🇵🇰 +92</option>
                            <option value="+61">🇦🇺 +61</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-gray-450">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <input type="tel" id="phone" name="phone" placeholder="(555) 000-0000" class="flex-1 w-full px-4 py-2.5 rounded-r-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Professional details -->
            <div>
                <x-input-label for="headline" :value="__('Professional Headline')" />
                <x-text-input id="headline" class="block mt-1 w-full" type="text" name="headline" :value="old('headline')" placeholder="e.g. Senior Software Architect" />
                <x-input-error :messages="$errors->get('headline')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="linkedin" :value="__('LinkedIn Profile URL')" />
                <x-text-input id="linkedin" class="block mt-1 w-full" type="url" name="linkedin" :value="old('linkedin')" placeholder="https://linkedin.com/in/username" />
                <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <input id="password" type="password" name="password" x-model="password" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm" required />
                
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
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm" required />
                <div class="mt-1 flex items-center justify-end" x-show="password_confirmation.length > 0" style="display: none;">
                    <span class="text-[10px] font-semibold" :class="password === password_confirmation ? 'text-emerald-500' : 'text-rose-500'">
                        <span x-show="password === password_confirmation">✓ Passwords match</span>
                        <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Terms & Conditions Checkbox Component -->
            <div class="mt-4">
                <label for="terms" class="flex items-start cursor-pointer select-none">
                    <div class="relative flex items-center mt-0.5">
                        <input id="terms" type="checkbox" name="terms" required class="peer sr-only">
                        <div class="w-5 h-5 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-805 flex items-center justify-center peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-all duration-200 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-white scale-0 peer-checked:scale-100 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <span class="ml-3 text-xs text-gray-500 dark:text-gray-400 leading-normal">
                        I agree to the 
                        <a href="#" class="font-semibold text-primary-500 hover:underline">Terms of Service</a> 
                        and 
                        <a href="#" class="font-semibold text-primary-500 hover:underline">Privacy Policy</a>.
                    </span>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-2" />
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-150 dark:border-gray-800">
                <a class="text-sm text-gray-500 dark:text-gray-450 hover:text-gray-900 dark:hover:text-white hover:underline transition-colors" href="{{ route('register') }}">
                    ← Change role
                </a>

                <x-primary-button>
                    {{ __('Create Profile') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
