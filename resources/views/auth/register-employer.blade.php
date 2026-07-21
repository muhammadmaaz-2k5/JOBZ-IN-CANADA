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
                if (s <= 3) return 'text-amber-505';
                return 'text-emerald-505';
            }
         }"
    >
        <div>
            <h2>Create Employer Account</h2>
            <p>Post jobs and hire top talent in Canada</p>
        </div>

        <!-- Social Login Buttons Component -->
        <div>
            <a href="#">
                <svg viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                        <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                        <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                    </g>
                </svg>
                Google
            </a>
            <a href="#">
                <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
                LinkedIn
            </a>
        </div>

        <div>
            <div>
                <div></div>
            </div>
            <span>Or corporate signup</span>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="role" value="employer">

            <!-- Company Profile Section -->
            <div>
                <h3>Company Information</h3>
                
                <div>
                    <div>
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name" type="text" name="company_name" :value="old('company_name')" required placeholder="e.g. Acme Corp" />
                        <x-input-error :messages="$errors->get('company_name')" />
                    </div>

                    <div>
                        <x-input-label for="website" :value="__('Company Website')" />
                        <x-text-input id="website" type="url" name="website" :value="old('website')" required placeholder="https://example.com" />
                        <x-input-error :messages="$errors->get('website')" />
                    </div>
                </div>

                <div>
                    <div>
                        <x-input-label for="industry" :value="__('Industry')" />
                        <div>
                            <select id="industry" name="industry">
                                <option value="Technology">Technology & Software</option>
                                <option value="Finance">Finance & Banking</option>
                                <option value="Healthcare">Healthcare & Medicine</option>
                                <option value="Education">Education</option>
                                <option value="Construction">Construction</option>
                                <option value="Retail">Retail & E-commerce</option>
                                <option value="Other">Other</option>
                            </select>
                            <div>
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('industry')" />
                    </div>

                    <div>
                        <x-input-label for="company_size" :value="__('Company Size')" />
                        <div>
                            <select id="company_size" name="company_size">
                                <option value="1-10">1-10 employees</option>
                                <option value="11-50">11-50 employees</option>
                                <option value="51-200">51-200 employees</option>
                                <option value="201-500">201-500 employees</option>
                                <option value="500+">500+ employees</option>
                            </select>
                            <div>
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('company_size')" />
                    </div>
                </div>
            </div>

            <!-- Contact/User Profile Section -->
            <div>
                <h3>Contact Person</h3>
                
                <div>
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required />
                        <x-input-error :messages="$errors->get('first_name')" />
                    </div>
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required />
                        <x-input-error :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <div>
                    <div>
                        <x-input-label for="designation" :value="__('Designation / Title')" />
                        <x-text-input id="designation" type="text" name="designation" :value="old('designation')" required placeholder="e.g. Recruiting Manager" />
                        <x-input-error :messages="$errors->get('designation')" />
                    </div>

                    <!-- Phone Input Component -->
                    <div>
                        <x-input-label for="employer_phone" :value="__('Contact Phone')" />
                        <div>
                            <div>
                                <select x-model="phone_code">
                                    <option value="+1">🇨🇦 +1</option>
                                    <option value="+1-us">🇺🇸 +1</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+91">🇮🇳 +91</option>
                                    <option value="+92">🇵🇰 +92</option>
                                    <option value="+61">🇦🇺 +61</option>
                                </select>
                                <div>
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <input type="tel" id="employer_phone" name="employer_phone" placeholder="(555) 000-0000">
                        </div>
                        <x-input-error :messages="$errors->get('employer_phone')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="email" :value="__('Work Email Address')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <input id="password" type="password" name="password" x-model="password" required />
                    
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
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required />
                    <div x-show="password_confirmation.length > 0">
                        <span :>
                            <span x-show="password === password_confirmation">✓ Passwords match</span>
                            <span x-show="password !== password_confirmation">✗ Passwords do not match</span>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>
            </div>

            <!-- Terms & Conditions Checkbox Component -->
            <div>
                <label for="terms">
                    <div>
                        <input id="terms" type="checkbox" name="terms" required>
                        <div>
                            <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <span>
                        We represent an authorized Canadian business. I agree to the 
                        <a href="#">Terms of Service</a> 
                        and 
                        <a href="#">Employer Guidelines</a>.
                    </span>
                </label>
                <x-input-error :messages="$errors->get('terms')" />
            </div>

            <!-- Action buttons -->
            <div>
                <a href="{{ route('register') }}">
                    ← Change role
                </a>

                <button type="submit">
                    Create Corporate Profile
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
