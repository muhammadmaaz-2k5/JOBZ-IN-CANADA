<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                {{ __('Professional Profile') }}
            </h2>
            <a href="{{ route('seeker.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-400 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="p-4 bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="font-bold">{{ session('warning') }}</span>
                </div>
            @endif

            <!-- Completion Tracker Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                            <span class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </span>
                            Profile Completeness
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Complete your profile to unlock one-click applications and personalized job recommendations.</p>
                    </div>
                    <div class="w-full md:w-1/3 flex items-center gap-4">
                        <div class="flex-1 h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden shadow-inner">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full relative" style="width: {{ $seekerProfile->profile_completion ?? 0 }}%">
                                <div class="absolute inset-0 bg-white/20 w-full animate-[shimmer_2s_infinite]"></div>
                            </div>
                        </div>
                        <span class="font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ $seekerProfile->profile_completion ?? 0 }}%</span>
                    </div>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Left Sidebar: Basic Info & Experience -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- Personal & Profile Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Personal Information</h3>
                        </div>

                        <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="first_name" :value="__('First Name')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $user->first_name)" required class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('Last Name')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $user->last_name)" required class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="phone" name="phone" type="text" :value="old('phone', $user->phone)" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Country')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="country" name="country" type="text" :value="old('country', $user->country)" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                                <div>
                                    <x-input-label for="city" :value="__('City')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="city" name="city" type="text" :value="old('city', $user->city)" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="headline" :value="__('Professional Headline')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="headline" name="headline" type="text" :value="old('headline', $seekerProfile->headline)" placeholder="e.g., Senior Full Stack Developer | Laravel Expert" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                                <div>
                                    <x-input-label for="summary" :value="__('About Me / Summary')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <textarea id="summary" name="summary" rows="4" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3">{{ old('summary', $seekerProfile->summary) }}</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="current_salary" :value="__('Current Salary (CAD / Year)')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 font-bold">$</div>
                                        <x-text-input id="current_salary" name="current_salary" type="number" :value="old('current_salary', $seekerProfile->current_salary)" class="pl-8 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="expected_salary" :value="__('Expected Salary (CAD / Year)')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 font-bold">$</div>
                                        <x-text-input id="expected_salary" name="expected_salary" type="number" :value="old('expected_salary', $seekerProfile->expected_salary)" class="pl-8 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="notice_period" :value="__('Notice Period')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="notice_period" name="notice_period" type="text" :value="old('notice_period', $seekerProfile->notice_period)" placeholder="e.g. 1 Month, Immediate" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                                <div>
                                    <x-input-label for="employment_preference" :value="__('Job Type Preference')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <select id="employment_preference" name="employment_preference" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3">
                                        <option value="full-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'full-time')>Full-time</option>
                                        <option value="part-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'part-time')>Part-time</option>
                                        <option value="contract" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'contract')>Contract</option>
                                        <option value="remote" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'remote')>Remote</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="career_level" :value="__('Career Level')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <select id="career_level" name="career_level" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3">
                                        <option value="entry" @selected(old('career_level', $seekerProfile->career_level) == 'entry')>Entry Level</option>
                                        <option value="mid" @selected(old('career_level', $seekerProfile->career_level) == 'mid')>Mid Level</option>
                                        <option value="senior" @selected(old('career_level', $seekerProfile->career_level) == 'senior')>Senior Level</option>
                                        <option value="lead" @selected(old('career_level', $seekerProfile->career_level) == 'lead')>Lead / Manager</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="profile_photo" :value="__('Profile Photo')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50 transition-all cursor-pointer bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm hover:border-indigo-300 font-medium" />
                                </div>
                                <div>
                                    <x-input-label for="work_authorization" :value="__('Work Authorization')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="work_authorization" name="work_authorization" type="text" :value="old('work_authorization', $seekerProfile->work_authorization)" placeholder="e.g. Canadian Citizen, Work Permit" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="linkedin" :value="__('LinkedIn URL')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        </div>
                                        <x-text-input id="linkedin" name="linkedin" type="url" :value="old('linkedin', $seekerProfile->linkedin)" class="pl-10 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" placeholder="https://linkedin.com/in/..." />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="github" :value="__('GitHub URL')" class="font-bold text-gray-700 dark:text-gray-300" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                        </div>
                                        <x-text-input id="github" name="github" type="url" :value="old('github', $seekerProfile->github)" class="pl-10 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium" placeholder="https://github.com/..." />
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700/50">
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 focus:ring-4 focus:ring-blue-500/20">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Save Profile Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Work Experience Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white">Work Experience</h3>
                            </div>
                        </div>

                        <!-- Add Experience Inline Form -->
                        <div class="mb-10 bg-gray-50/80 dark:bg-gray-900/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <form method="POST" action="{{ route('seeker.experience.add') }}" class="space-y-4">
                                @csrf
                                <h4 class="font-black text-gray-900 dark:text-white text-lg mb-4">Add New Position</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="company" placeholder="Company Name" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    <input type="text" name="designation" placeholder="Job Title / Designation" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Start Date</label>
                                        <input type="date" name="start_date" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">End Date (Leave empty if present)</label>
                                        <input type="date" name="end_date" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Employment Type</label>
                                        <select name="employment_type" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3">
                                            <option value="Full-time">Full-time</option>
                                            <option value="Part-time">Part-time</option>
                                            <option value="Contract">Contract</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <textarea name="description" placeholder="Describe your achievements and tasks..." rows="3" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3"></textarea>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Add Experience
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-6">
                            @forelse($experiences as $exp)
                                <div class="relative group p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-900/50 shadow-sm hover:shadow-md transition-all">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h4 class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $exp->designation }}</h4>
                                            <p class="font-bold text-indigo-600 dark:text-indigo-400 mb-2">{{ $exp->company }} <span class="text-gray-400 font-normal ml-2 text-sm px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded-md">{{ $exp->employment_type }}</span></p>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} &ndash; 
                                                {{ $exp->currently_working ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                                            </p>
                                            @if($exp->description)
                                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">{{ $exp->description }}</p>
                                            @endif
                                        </div>
                                        <form method="POST" action="{{ route('seeker.experience.delete', $exp->id) }}" class="shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Remove">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <p class="text-gray-500 font-medium">No work experience added yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Education Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Education</h3>
                        </div>

                        <div class="mb-10 bg-gray-50/80 dark:bg-gray-900/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <form method="POST" action="{{ route('seeker.education.add') }}" class="space-y-4">
                                @csrf
                                <h4 class="font-black text-gray-900 dark:text-white text-lg mb-4">Add Education</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="institution" placeholder="School / University" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    <input type="text" name="degree" placeholder="Degree / Diploma" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input type="text" name="field_of_study" placeholder="Field of Study" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">Start Date</label>
                                        <input type="date" name="start_date" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 mb-1">End Date</label>
                                        <input type="date" name="end_date" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="grade" placeholder="GPA / Grade (Optional)" class="md:w-1/3 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Add Education
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-4">
                            @forelse($education as $edu)
                                <div class="group p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 flex justify-between items-start gap-4 shadow-sm hover:shadow hover:border-amber-200 dark:hover:border-amber-900/50 transition-all">
                                    <div>
                                        <h4 class="text-lg font-black text-gray-900 dark:text-white mb-1">{{ $edu->degree }} <span class="text-amber-500 dark:text-amber-400 font-bold">&bull; {{ $edu->field_of_study }}</span></h4>
                                        <p class="font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $edu->institution }}</p>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} &ndash; 
                                            {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Present' }}
                                            @if($edu->grade)
                                                <span class="mx-2 text-gray-300 dark:text-gray-600">|</span> <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-xs">Grade: {{ $edu->grade }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('seeker.education.delete', $edu->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                                    <p class="text-gray-500 font-medium">No education history added yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Resume Library, Skills, Projects -->
                <div class="space-y-8">
                    
                    <!-- Resume Library Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white">Resume Library</h3>
                        </div>

                        <form method="POST" action="{{ route('seeker.resume.upload') }}" enctype="multipart/form-data" class="mb-8 space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="resume_title" :value="__('Resume Label')" class="font-bold text-gray-700 dark:text-gray-300" />
                                <x-text-input id="resume_title" name="title" type="text" placeholder="e.g. Senior Laravel Resume" required class="mt-1 block w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 text-slate-900 focus:ring-2 block px-4 py-3 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 duration-200 placeholder-slate-400 font-medium bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                            </div>
                            <div>
                                <label class="block w-full cursor-pointer">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input id="resume_file" name="resume_file" type="file" required class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-red-50 dark:file:bg-red-900/30 file:text-red-700 dark:file:text-red-400 hover:file:bg-red-100 dark:hover:file:bg-red-900/50 transition-all cursor-pointer bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm hover:border-red-300 font-medium" />
                                </label>
                                <p class="text-xs text-gray-400 mt-2 font-medium">PDF, DOC, DOCX up to 5MB.</p>
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Upload Resume
                            </button>
                        </form>

                        <div class="space-y-3">
                            @forelse($resumes as $res)
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border {{ $res->is_default ? 'border-red-200 dark:border-red-900/50' : 'border-gray-200 dark:border-gray-700' }} hover:shadow-md transition-shadow relative overflow-hidden group">
                                    @if($res->is_default)
                                        <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                                            <div class="absolute top-[10px] right-[-24px] bg-red-500 text-white text-[10px] font-bold py-0.5 px-6 transform rotate-45">DEFAULT</div>
                                        </div>
                                    @endif
                                    <div class="flex flex-col gap-2 relative z-10">
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white truncate pr-8">{{ $res->title }}</h4>
                                            <p class="text-xs text-gray-500 truncate">{{ $res->original_name }} &bull; {{ round($res->file_size / 1024, 1) }} KB</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2 pt-2 border-t border-gray-200 dark:border-gray-700/50">
                                            <a href="{{ route('seeker.resume.download', $res->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex-1 text-center">Download</a>
                                            @if(!$res->is_default)
                                                <form method="POST" action="{{ route('seeker.resume.default', $res->id) }}" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full text-xs font-bold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-lg transition-colors text-center">Set Default</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('seeker.resume.delete', $res->id) }}" class="shrink-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-white bg-red-50 hover:bg-red-500 px-3 py-1.5 rounded-lg transition-colors">&times;</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-sm text-gray-500 font-medium">No resumes uploaded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills Management -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white">Core Skills</h3>
                        </div>

                        <form method="POST" action="{{ route('seeker.skills.sync') }}">
                            @csrf
                            <div class="mb-6">
                                <p class="text-sm text-gray-500 mb-4 font-medium">Enter your key skills and press enter or comma to add them.</p>
                                
                                <div x-data="{
                                    newSkill: '',
                                    skills: {{ json_encode($user->skills->pluck('name')->toArray()) }},
                                    addSkill() {
                                        if (this.newSkill.trim() !== '' && !this.skills.includes(this.newSkill.trim())) {
                                            this.skills.push(this.newSkill.trim());
                                        }
                                        this.newSkill = '';
                                    },
                                    removeSkill(index) {
                                        this.skills.splice(index, 1);
                                    }
                                }">
                                    <div class="p-3 border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/50 flex flex-wrap gap-2 items-center focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all shadow-sm">
                                        <template x-for="(skill, index) in skills" :key="index">
                                            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-800 text-indigo-700 dark:text-indigo-400 font-bold text-sm rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">
                                                <span x-text="skill"></span>
                                                <button type="button" @click="removeSkill(index)" class="hover:text-rose-500 focus:outline-none flex items-center justify-center font-black ml-1">
                                                    &times;
                                                </button>
                                                <input type="hidden" name="skills[]" :value="skill">
                                            </div>
                                        </template>
                                        
                                        <input type="text" x-model="newSkill" @keydown.enter.prevent="addSkill()" @keydown.comma.prevent="addSkill()" @blur="addSkill()" placeholder="Add a skill..." class="flex-1 bg-transparent border-none focus:ring-0 text-[15px] font-medium text-slate-900 dark:text-white placeholder-slate-400 outline-none min-w-[150px] p-1" />
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-colors shadow-lg shadow-green-500/30">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                Update Skills
                            </button>
                        </form>
                    </div>

                    <!-- Projects & Certifications Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="mb-10">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">Projects</h3>
                            </div>
                            
                            <form method="POST" action="{{ route('seeker.project.add') }}" class="mb-6 space-y-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                                @csrf
                                <input type="text" name="project_name" placeholder="Project Name" required class="w-full text-sm focus:ring-purple-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                <input type="text" name="technologies" placeholder="Technologies (e.g. PHP, Vue)" class="w-full text-sm focus:ring-purple-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                <input type="url" name="url" placeholder="Project URL (e.g. Live Link)" class="w-full text-sm focus:ring-purple-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                <button type="submit" class="w-full text-sm font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100">+ Add Project</button>
                            </form>

                            <div class="space-y-3">
                                @foreach($projects as $proj)
                                    <div class="flex items-start justify-between p-4 border border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                                        <div>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-sm mb-1">{{ $proj->project_name }}</h5>
                                            <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">{{ $proj->technologies }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.project.delete', $proj->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">&times;</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                                <div class="w-10 h-10 rounded-xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">Certifications</h3>
                            </div>
                            
                            <form method="POST" action="{{ route('seeker.certification.add') }}" class="mb-6 space-y-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                                @csrf
                                <input type="text" name="name" placeholder="Certification Name" required class="w-full text-sm focus:ring-pink-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                <input type="text" name="organization" placeholder="Issuing Organization" required class="w-full text-sm focus:ring-pink-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-[10px] uppercase font-bold text-gray-500 mb-1">Issue Date</label>
                                        <input type="date" name="issue_date" required class="w-full text-sm focus:ring-pink-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] uppercase font-bold text-gray-500 mb-1">Expiry (Optional)</label>
                                        <input type="date" name="expiry_date" class="w-full text-sm focus:ring-pink-500 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-200 placeholder-slate-400 font-medium px-4 py-3" />
                                    </div>
                                </div>
                                <button type="submit" class="w-full text-sm font-bold bg-gray-900 dark:bg-white text-white dark:text-gray-900 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 mt-2">+ Add Cert</button>
                            </form>

                            <div class="space-y-3">
                                @foreach($certifications as $cert)
                                    <div class="flex items-start justify-between p-4 border border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                                        <div>
                                            <h5 class="font-bold text-gray-900 dark:text-white text-sm mb-1">{{ $cert->name }}</h5>
                                            <p class="text-xs text-pink-600 dark:text-pink-400 font-medium">{{ $cert->organization }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.certification.delete', $cert->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">&times;</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
