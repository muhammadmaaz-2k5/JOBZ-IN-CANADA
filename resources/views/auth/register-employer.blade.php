<x-guest-layout>
    <div 
         x-data="{ 
            role: 'employer',
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
            <h2 class="text-2xl font-black text-gray-900 mb-2">Create Employer Account</h2>
            <p class="text-gray-500 text-sm font-medium">Post jobs and hire top talent in Canada</p>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-1 gap-4 mb-6">
            <button type="button" id="google-login-btn" onclick="handleGoogleLogin('employer')" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 font-semibold text-gray-700 transition-colors shadow-sm w-full">
                <svg viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                        <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                        <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                    </g>
                </svg>
                Google
            </button>
        </div>

        <div class="relative flex items-center py-2 mb-6">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-xs font-medium text-gray-400 uppercase tracking-widest">Or corporate signup</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="role" value="employer">

            <!-- Company Profile Section -->
            <div class="space-y-4">
                <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-2">Company Information</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-1">Company Name</label>
                        <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required placeholder="e.g. Acme Corp" class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-1" />
                    </div>

                    <div class="col-span-2">
                        <label for="website" class="block text-sm font-semibold text-gray-700 mb-1">Company Website</label>
                        <input id="website" type="url" name="website" value="{{ old('website') }}" required placeholder="https://example.com" class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('website')" class="mt-1" />
                    </div>

                    <div>
                        <label for="industry" class="block text-sm font-semibold text-gray-700 mb-1">Industry</label>
                        <div class="relative">
                            <select id="industry" name="industry" class="w-full border pl-4 pr-10 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none appearance-none form-input-premium">
                                <option value="Technology">Technology & Software</option>
                                <option value="Finance">Finance & Banking</option>
                                <option value="Healthcare">Healthcare & Medicine</option>
                                <option value="Education">Education</option>
                                <option value="Construction">Construction</option>
                                <option value="Retail">Retail & E-commerce</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('industry')" class="mt-1" />
                    </div>

                    <div>
                        <label for="company_size" class="block text-sm font-semibold text-gray-700 mb-1">Company Size</label>
                        <div class="relative">
                            <select id="company_size" name="company_size" class="w-full border pl-4 pr-10 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none appearance-none form-input-premium">
                                <option value="1-10">1-10 employees</option>
                                <option value="11-50">11-50 employees</option>
                                <option value="51-200">51-200 employees</option>
                                <option value="201-500">201-500 employees</option>
                                <option value="500+">500+ employees</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('company_size')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Contact/User Profile Section -->
            <div class="space-y-4">
                <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-2">Contact Person</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
                    </div>

                    <div class="col-span-2">
                        <label for="designation" class="block text-sm font-semibold text-gray-700 mb-1">Designation / Title</label>
                        <input id="designation" type="text" name="designation" value="{{ old('designation') }}" required placeholder="e.g. Recruiting Manager" class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('designation')" class="mt-1" />
                    </div>

                    <div class="col-span-2">
                        <label for="employer_phone" class="block text-sm font-semibold text-gray-700 mb-1">Contact Phone</label>
                        <div class="flex gap-2">
                            <div class="relative w-1/3">
                                <select x-model="phone_code" class="w-full border pl-3 pr-8 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none appearance-none form-input-premium">
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
                            <input type="tel" id="employer_phone" name="employer_phone" placeholder="(555) 000-0000" class="w-2/3 border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium">
                        </div>
                        <x-input-error :messages="$errors->get('employer_phone')" class="mt-1" />
                    </div>

                    <div class="col-span-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Work Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="col-span-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" x-model="password" required class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        
                        <!-- Password Strength Meter -->
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

                    <div class="col-span-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required class="w-full border px-4 py-2.5 text-sm focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none form-input-premium" />
                        <div x-show="password_confirmation.length > 0" x-transition class="mt-1 text-xs font-medium">
                            <span :class="password === password_confirmation ? 'text-emerald-500' : 'text-rose-500'">
                                <span x-show="password === password_confirmation">✓ Passwords match</span>
                                <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions Checkbox Component -->
            <div class="pt-2">
                <label for="terms" class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center mt-0.5">
                        <input id="terms" type="checkbox" name="terms" required class="peer appearance-none w-5 h-5 rounded border-2 border-gray-300 checked:bg-amber-500 checked:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all cursor-pointer">
                        <div class="absolute text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 leading-snug">
                        We represent an authorized Canadian business. I agree to the 
                        <a href="#" class="font-semibold text-amber-500 hover:underline">Terms of Service</a> 
                        and 
                        <a href="#" class="font-semibold text-amber-500 hover:underline">Employer Guidelines</a>.
                    </span>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-1" />
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('register') }}" class="text-sm font-semibold text-gray-500 hover:text-amber-500 transition-colors">
                    ← Change role
                </a>

                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-amber-500/30 transition-all active:scale-95">
                    Create Corporate Profile
                </button>
            </div>
        </form>
    </div>
    
    <script>
        async function handleGoogleLogin(role = null) {
            try {
                if (!window.firebaseAuth) {
                    console.error("Firebase auth not initialized");
                    return;
                }
                
                const { auth, signInWithPopup, googleProvider } = window.firebaseAuth;
                
                document.getElementById('google-login-btn').innerHTML = 'Logging in...';

                const result = await signInWithPopup(auth, googleProvider);
                const idToken = await result.user.getIdToken();

                const response = await fetch('{{ route('firebase.callback') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ idToken, role })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    console.error("Backend auth failed:", data.error);
                    alert("Authentication failed: " + (data.error || "Unknown error"));
                    document.getElementById('google-login-btn').innerHTML = 'Google';
                }

            } catch (error) {
                console.error("Firebase Login Error:", error);
                alert("Login was cancelled or failed.");
                document.getElementById('google-login-btn').innerHTML = 'Google';
            }
        }
    </script>
</x-guest-layout>
