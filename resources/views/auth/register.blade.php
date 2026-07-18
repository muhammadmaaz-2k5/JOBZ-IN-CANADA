<x-guest-layout>
    <div x-data="{ role: 'job_seeker' }" class="w-full">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create your account</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join the Indeed-like recruitment platform for Canada</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Role Selection Cards -->
            <div class="mb-6">
                <x-input-label class="mb-2 text-base font-semibold" :value="__('I want to register as a:')" />
                <div class="grid grid-cols-2 gap-4">
                    <!-- Job Seeker Card -->
                    <label 
                        @click="role = 'job_seeker'"
                        :class="role === 'job_seeker' ? 'border-indigo-600 ring-2 ring-indigo-600 dark:ring-indigo-400 dark:border-indigo-400 bg-indigo-50/50 dark:bg-indigo-950/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'"
                        class="flex flex-col items-center justify-center p-4 border rounded-xl cursor-pointer transition-all duration-200 text-center"
                    >
                        <input type="radio" name="role" value="job_seeker" class="sr-only" checked>
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84a50.58 50.58 0 0 0-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        <span class="font-bold text-gray-900 dark:text-gray-100 text-sm">Job Seeker</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Search & apply for jobs</span>
                    </label>

                    <!-- Employer Card -->
                    <label 
                        @click="role = 'employer'"
                        :class="role === 'employer' ? 'border-indigo-600 ring-2 ring-indigo-600 dark:ring-indigo-400 dark:border-indigo-400 bg-indigo-50/50 dark:bg-indigo-950/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'"
                        class="flex flex-col items-center justify-center p-4 border rounded-xl cursor-pointer transition-all duration-200 text-center"
                    >
                        <input type="radio" name="role" value="employer" class="sr-only">
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18" />
                        </svg>
                        <span class="font-bold text-gray-900 dark:text-gray-100 text-sm">Employer</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Post jobs & hire talent</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Basic Auth Fields (Always Required) -->
            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Job Seeker Specific Fields -->
            <div x-show="role === 'job_seeker'" x-transition class="mt-6 space-y-4 border-t border-gray-100 dark:border-gray-800 pt-6">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Professional Details (Optional)</h3>
                
                <div>
                    <x-input-label for="headline" :value="__('Professional Headline')" />
                    <x-text-input id="headline" class="block mt-1 w-full" type="text" name="headline" :value="old('headline')" placeholder="e.g. Senior Laravel Developer" />
                    <x-input-error :messages="$errors->get('headline')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="linkedin" :value="__('LinkedIn Profile URL')" />
                    <x-text-input id="linkedin" class="block mt-1 w-full" type="url" name="linkedin" :value="old('linkedin')" placeholder="https://linkedin.com/in/username" />
                    <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                </div>
            </div>

            <!-- Employer/Company Specific Fields -->
            <div x-show="role === 'employer'" x-transition class="mt-6 space-y-4 border-t border-gray-100 dark:border-gray-800 pt-6">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Company & Contact Information</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" ::required="role === 'employer'" placeholder="e.g. Acme Corporation" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="website" :value="__('Company Website')" />
                        <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" ::required="role === 'employer'" placeholder="https://example.com" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="industry" :value="__('Industry')" />
                        <select id="industry" name="industry" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Industry</option>
                            <option value="Technology">Technology & Software</option>
                            <option value="Finance">Finance & Banking</option>
                            <option value="Healthcare">Healthcare & Medicine</option>
                            <option value="Education">Education</option>
                            <option value="Construction">Construction</option>
                            <option value="Retail">Retail & E-commerce</option>
                            <option value="Other">Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="company_size" :value="__('Company Size')" />
                        <select id="company_size" name="company_size" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Size</option>
                            <option value="1-10">1-10 employees</option>
                            <option value="11-50">11-50 employees</option>
                            <option value="51-200">51-200 employees</option>
                            <option value="201-500">201-500 employees</option>
                            <option value="500+">500+ employees</option>
                        </select>
                        <x-input-error :messages="$errors->get('company_size')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="designation" :value="__('Your Title / Designation')" />
                        <x-text-input id="designation" class="block mt-1 w-full" type="text" name="designation" :value="old('designation')" ::required="role === 'employer'" placeholder="e.g. HR Manager" />
                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="employer_phone" :value="__('Contact Phone Number')" />
                        <x-text-input id="employer_phone" class="block mt-1 w-full" type="text" name="employer_phone" :value="old('employer_phone')" ::required="role === 'employer'" placeholder="e.g. +1 555-019-2834" />
                        <x-input-error :messages="$errors->get('employer_phone')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
