<x-guest-layout>
    <div 
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
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Create Seeker Account</h2>
            <p class="text-gray-500 text-sm font-medium">Join top candidates hiring in Canada</p>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <a href="#" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 font-semibold text-gray-700 transition-colors shadow-sm">
                <svg viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                        <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                        <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                    </g>
                </svg>
                Google
            </a>
            <a href="#" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 font-semibold text-gray-700 transition-colors shadow-sm">
                <svg class="text-[#0a66c2]" width="20" height="20" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
                LinkedIn
            </a>
        </div>

        <div class="relative flex items-center py-2 mb-6">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-xs font-medium text-gray-400 uppercase tracking-widest">Or signup with email</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="job_seeker">

            <!-- Name Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
                </div>
            </div>

            <!-- Email address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Country Selector -->
            <div>
                <label for="country" class="block text-sm font-semibold text-gray-700 mb-1">Country of Residence</label>
                <div class="relative">
                    <select id="country" name="country" x-model="country" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all appearance-none">
                        <option value="Canada">🇨🇦 Canada</option>
                        <option value="United States">🇺🇸 United States</option>
                        <option value="United Kingdom">🇬🇧 United Kingdom</option>
                        <option value="India">🇮🇳 India</option>
                        <option value="Pakistan">🇵🇰 Pakistan</option>
                        <option value="Australia">🇦🇺 Australia</option>
                        <option value="France">🇫🇷 France</option>
                        <option value="Germany">🇩🇪 Germany</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('country')" class="mt-1" />
            </div>

            <!-- Phone Input Component -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                <div class="flex gap-2">
                    <div class="relative w-1/3">
                        <select x-model="phone_code" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-3 pr-8 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all appearance-none">
                            <option value="+1">🇨🇦 +1</option>
                            <option value="+1-us">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+91">🇮🇳 +91</option>
                            <option value="+92">🇵🇰 +92</option>
                            <option value="+61">🇦🇺 +61</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <input type="tel" id="phone" name="phone" placeholder="(555) 000-0000" class="w-2/3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <!-- Professional details -->
            <div>
                <label for="headline" class="block text-sm font-semibold text-gray-700 mb-1">Professional Headline</label>
                <input id="headline" type="text" name="headline" value="{{ old('headline') }}" placeholder="e.g. Senior Software Architect" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                <x-input-error :messages="$errors->get('headline')" class="mt-1" />
            </div>

            <div>
                <label for="linkedin" class="block text-sm font-semibold text-gray-700 mb-1">LinkedIn Profile URL</label>
                <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/username" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                <x-input-error :messages="$errors->get('linkedin')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" x-model="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                
                <!-- Password Strength Meter Component -->
                <div x-show="password.length > 0" x-transition class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="text-gray-500 font-medium">Password strength:</span>
                        <span :class="labelClass" x-text="strengthLabel" class="font-bold"></span>
                    </div>
                    <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden mb-2">
                        <div class="h-full transition-all duration-300 rounded-full" :class="strengthClass"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-y-1 text-xs">
                        <div class="flex items-center gap-1.5" :class="password.length >= 8 ? 'text-emerald-500' : 'text-gray-400'">
                            <span x-show="password.length >= 8">✓</span><span x-show="password.length < 8">○</span>
                            <span>Min 8 characters</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="/[A-Z]/.test(password) ? 'text-emerald-500' : 'text-gray-400'">
                            <span x-show="/[A-Z]/.test(password)">✓</span><span x-show="!/[A-Z]/.test(password)">○</span>
                            <span>At least 1 uppercase</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="/[0-9]/.test(password) ? 'text-emerald-500' : 'text-gray-400'">
                            <span x-show="/[0-9]/.test(password)">✓</span><span x-show="!/[0-9]/.test(password)">○</span>
                            <span>At least 1 number</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="/[^A-Za-z0-9]/.test(password) ? 'text-emerald-500' : 'text-gray-400'">
                            <span x-show="/[^A-Za-z0-9]/.test(password)">✓</span><span x-show="!/[^A-Za-z0-9]/.test(password)">○</span>
                            <span>At least 1 symbol</span>
                        </div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1650e1] focus:ring-1 focus:ring-[#1650e1] outline-none transition-all" />
                <div x-show="password_confirmation.length > 0" x-transition class="mt-1 text-xs font-medium">
                    <span :class="password === password_confirmation ? 'text-emerald-500' : 'text-rose-500'">
                        <span x-show="password === password_confirmation">✓ Passwords match</span>
                        <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Terms & Conditions Checkbox Component -->
            <div class="pt-2">
                <label for="terms" class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center mt-0.5">
                        <input id="terms" type="checkbox" name="terms" required class="peer appearance-none w-5 h-5 rounded border-2 border-gray-300 checked:bg-[#1650e1] checked:border-[#1650e1] focus:ring-2 focus:ring-[#1650e1]/20 transition-all cursor-pointer">
                        <div class="absolute text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 leading-snug">
                        I agree to the 
                        <a href="#" class="font-semibold text-[#1650e1] hover:underline">Terms of Service</a> 
                        and 
                        <a href="#" class="font-semibold text-[#1650e1] hover:underline">Privacy Policy</a>.
                    </span>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-1" />
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('register') }}" class="text-sm font-semibold text-gray-500 hover:text-[#1650e1] transition-colors">
                    ← Change role
                </a>

                <button type="submit" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-[#1650e1]/30 transition-all active:scale-95">
                    {{ __('Create Profile') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
