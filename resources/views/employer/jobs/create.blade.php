<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-900 dark:text-white tracking-tight">
                    {{ __('Post a New Job') }}
                </h2>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">
                    Find the perfect candidate across multiple locations.
                </p>
            </div>
            <a href="{{ route('employer.jobs.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/80 transition-colors group">
                <svg class="w-5 h-5 text-slate-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Exit
            </a>
        </div>
    </x-slot>

    <!-- Include Quill for Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        .custom-quill-wrapper .ql-toolbar.ql-snow {
            border: 1px solid #e2e8f0;
            border-bottom: none;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            background-color: #f8fafc;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dark .custom-quill-wrapper .ql-toolbar.ql-snow {
            border-color: #334155;
            background-color: #1e293b;
        }
        .custom-quill-wrapper .ql-container.ql-snow {
            border: 1px solid #e2e8f0;
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            background-color: #ffffff;
            font-family: inherit;
        }
        .dark .custom-quill-wrapper .ql-container.ql-snow {
            border-color: #334155;
            background-color: #0f172a;
        }
        .custom-quill-wrapper .ql-editor {
            padding: 16px;
            font-size: 1.125rem;
        }
        .custom-quill-wrapper .ql-toolbar.ql-snow .ql-formats {
            margin-right: 0;
        }
        .custom-quill-wrapper .ql-snow .ql-stroke {
            stroke: #475569;
            stroke-width: 2.5;
        }
        .custom-quill-wrapper .ql-snow .ql-fill {
            fill: #475569;
        }
        .dark .custom-quill-wrapper .ql-snow .ql-stroke {
            stroke: #cbd5e1;
        }
        .dark .custom-quill-wrapper .ql-snow .ql-fill {
            fill: #cbd5e1;
        }
    </style>

    <div class="py-8 relative z-10" x-data="jobWizard()">
        <!-- Decorative blurred backgrounds -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[120px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-emerald-500/10 blur-[120px]"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Progress Bar -->
            <div class="mb-10">
                <div class="flex items-center justify-between relative z-10">
                    <template x-for="i in 6">
                        <div class="flex-1 flex flex-col items-center relative group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                                :class="{'bg-blue-600 text-white shadow-lg shadow-blue-500/30': step === i, 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': step > i, 'bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 text-slate-400': step < i}">
                                <span x-show="step <= i" x-text="i"></span>
                                <svg x-show="step > i" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="absolute top-1/2 left-1/2 w-full h-1 bg-slate-200 dark:bg-slate-700 -z-10 transform -translate-y-1/2" x-show="i < 6">
                                <div class="h-full bg-blue-500 transition-all duration-500 ease-out" :style="'width: ' + (step > i ? '100%' : '0%')"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <form method="POST" action="{{ route('employer.jobs.store') }}" id="job-form" class="space-y-8 relative">
                @csrf
                <input type="hidden" name="status" id="form-status" value="published">
                <input type="hidden" name="description" id="hidden-description">

                <!-- Step 1: Job Basics -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6">Add job basics</h3>
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="language" value="Job post will be in" class="mb-2 font-bold" />
                            <select id="language" name="language" x-model="formData.language" class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium text-slate-700 dark:text-slate-300">
                                <option value="English">English</option>
                                <option value="French">French</option>
                            </select>
                        </div>
                        
                        <div>
                            <x-input-label for="country" value="Country" class="mb-2 font-bold" />
                            <select id="country" name="country" x-model="formData.country" class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium text-slate-700 dark:text-slate-300">
                                <option value="Pakistan">Pakistan</option>
                                <option value="Canada">Canada</option>
                                <option value="United States">United States</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="title" value="Job title *" class="mb-2 font-bold" />
                            <x-text-input id="title" name="title" x-model="formData.title" type="text" required placeholder="e.g. Senior Software Engineer" class="w-full px-5 py-3 rounded-xl bg-white dark:bg-slate-800/50 font-medium" />
                        </div>
                        
                        <div>
                            <x-input-label for="category_id" value="Job Category *" class="mb-2 font-bold" />
                            <select id="category_id" name="category_id" x-model="formData.category_id" required class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium text-slate-700 dark:text-slate-300">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                                <option value="other">Other (Custom Category)</option>
                            </select>
                        </div>
                        
                        <div x-show="formData.category_id === 'other'" x-transition class="mt-4">
                            <x-input-label for="custom_category" value="Enter Custom Category *" class="mb-2 font-bold text-blue-600 dark:text-blue-400" />
                            <x-text-input id="custom_category" name="custom_category" x-model="formData.custom_category" type="text" placeholder="e.g. Artificial Intelligence" class="w-full px-5 py-3 rounded-xl border-blue-200 dark:border-blue-800 bg-blue-50/50 dark:bg-blue-900/10 focus:ring-blue-500/20 font-medium" />
                        </div>

                        <div>
                            <x-input-label value="Job location type *" class="mb-3 font-bold" />
                            <div class="flex gap-4">
                                <label class="flex-1 relative cursor-pointer group">
                                    <input type="radio" name="workplace_type" value="on-site" x-model="formData.workplace_type" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all text-center">
                                        <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Onsite</span>
                                    </div>
                                </label>
                                <label class="flex-1 relative cursor-pointer group">
                                    <input type="radio" name="workplace_type" value="remote" x-model="formData.workplace_type" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all text-center">
                                        <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Remote</span>
                                    </div>
                                </label>
                                <label class="flex-1 relative cursor-pointer group">
                                    <input type="radio" name="workplace_type" value="hybrid" x-model="formData.workplace_type" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all text-center">
                                        <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-blue-700 dark:peer-checked:text-blue-400">Hybrid</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="relative">
                            <x-input-label for="location" value="What is the job location? *" class="mb-2 font-bold" />
                            <div class="relative">
                                <x-text-input id="location" type="text" x-model="locationQuery" @input.debounce.500ms="searchLocation()" placeholder="Start typing to search locations..." class="w-full px-5 py-3 rounded-xl bg-white dark:bg-slate-800/50 font-medium" />
                                <div class="absolute right-4 top-1/2 -translate-y-1/2" x-show="isSearchingLocation">
                                    <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>
                            
                            <!-- Location Dropdown -->
                            <div x-show="locationResults.length > 0" @click.away="locationResults = []" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                                <template x-for="result in locationResults" :key="result.place_id">
                                    <div @click="selectLocation(result)" class="px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer border-b border-slate-100 dark:border-slate-700/50 last:border-0 transition-colors">
                                        <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="result.display_name.split(',')[0]"></div>
                                        <div class="text-xs text-slate-500" x-text="result.display_name"></div>
                                    </div>
                                </template>
                            </div>

                            <!-- Selected Locations Badges -->
                            <div class="flex flex-wrap gap-2 mt-3" x-show="selectedLocations.length > 0">
                                <template x-for="(loc, idx) in selectedLocations" :key="idx">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-lg text-sm font-semibold">
                                        <span x-text="loc.split(',')[0]"></span>
                                        <button type="button" @click="removeLocation(idx)" class="hover:text-blue-900 dark:hover:text-blue-100">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </span>
                                </template>
                            </div>

                            <input type="hidden" name="location" :value="selectedLocations.join(', ')">
                            <input type="hidden" name="city" :value="selectedLocations[0] || ''"> <!-- Fallback -->

                            <div class="mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                                <h5 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-1">Target candidates in specific locations with multi-location reach</h5>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Post one job across multiple locations for greater visibility. Start typing to search via OpenStreetMap.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Hiring Goals -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6">Hiring goals</h3>
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="hiring_timeline" value="Hiring timeline for this job *" class="mb-2 font-bold" />
                            <select id="hiring_timeline" name="hiring_timeline" x-model="formData.hiring_timeline" class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium text-slate-700 dark:text-slate-300">
                                <option value="">Select an option</option>
                                <option value="1-3 days">1 to 3 days</option>
                                <option value="1-2 weeks">1 to 2 weeks</option>
                                <option value="2-4 weeks">2 to 4 weeks</option>
                                <option value="more than 4 weeks">More than 4 weeks</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="vacancies" value="Number of people to hire in the next 30 days *" class="mb-2 font-bold" />
                            <x-text-input id="vacancies" name="vacancies" x-model="formData.vacancies" type="number" min="1" required class="w-full px-5 py-3 rounded-xl bg-white dark:bg-slate-800/50 font-medium" />
                        </div>
                    </div>
                </div>

                <!-- Step 3: Job Details -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6">Add job details</h3>
                    <div class="space-y-6">
                        <div>
                            <x-input-label value="Job type *" class="mb-3 font-bold" />
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <template x-for="type in ['Contract', 'Half-time', 'Full-time', 'Fresher', 'Temporary', 'Internship']">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="employment_type" :value="type" x-model="formData.employment_type" class="peer sr-only">
                                        <div class="px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all text-center">
                                            <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400" x-text="type"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <x-input-label for="experience_level" value="Experience Level *" class="mb-2 font-bold" />
                                <select id="experience_level" name="experience_level" x-model="formData.experience_level" required class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 transition-all font-medium text-slate-700 dark:text-slate-300">
                                    <option value="entry">Entry Level</option>
                                    <option value="junior">Junior</option>
                                    <option value="mid">Mid-Level</option>
                                    <option value="senior">Senior</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="education_level" value="Education Level *" class="mb-2 font-bold" />
                                <select id="education_level" name="education_level" x-model="formData.education_level" required class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 transition-all font-medium text-slate-700 dark:text-slate-300">
                                    <option value="not-required">Not Required</option>
                                    <option value="high-school">High School</option>
                                    <option value="bachelors">Bachelor's</option>
                                    <option value="masters">Master's</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Add Pay and Benefits -->
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Add pay and benefits</h3>
                    <p class="text-sm font-medium text-slate-500 mb-6">Review the pay we estimated for your job and adjust as needed. Check your local minimum wage.</p>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="salary_visibility" value="Show pay by" class="mb-2 font-bold" />
                                <select id="salary_visibility" name="salary_visibility" x-model="formData.salary_visibility" class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 font-medium text-slate-700 dark:text-slate-300">
                                    <option value="range">Range</option>
                                    <option value="exact">Exact Amount</option>
                                    <option value="hidden">Hide Pay</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="salary_period" value="Rate" class="mb-2 font-bold" />
                                <select id="salary_period" name="salary_period" x-model="formData.salary_period" class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 font-medium text-slate-700 dark:text-slate-300">
                                    <option value="hourly">per hour</option>
                                    <option value="monthly">per month</option>
                                    <option value="yearly">per year</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4" x-show="formData.salary_visibility !== 'hidden'">
                            <div>
                                <x-input-label value="Minimum (Rs/CAD)" class="mb-2 font-bold text-xs uppercase" />
                                <x-text-input name="min_salary" x-model="formData.min_salary" type="number" placeholder="0.00" class="w-full px-5 py-3 rounded-xl" />
                            </div>
                            <div x-show="formData.salary_visibility === 'range'">
                                <x-input-label value="Maximum (Rs/CAD)" class="mb-2 font-bold text-xs uppercase" />
                                <x-text-input name="max_salary" x-model="formData.max_salary" type="number" placeholder="0.00" class="w-full px-5 py-3 rounded-xl" />
                            </div>
                        </div>
                        <input type="hidden" name="currency" value="Rs"> <!-- Fixed Rs as requested or derived -->

                        <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                            <h4 class="font-bold text-slate-800 dark:text-white mb-4">Expected hours</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label value="Show by" class="mb-2 font-bold" />
                                    <select class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 font-medium text-slate-700 dark:text-slate-300">
                                        <option>Fixed hours</option>
                                        <option>Flexible</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="expected_hours" value="Fixed at (Hours per week)" class="mb-2 font-bold" />
                                    <x-text-input id="expected_hours" name="expected_hours" x-model="formData.expected_hours" type="number" placeholder="e.g. 40" class="w-full px-5 py-3 rounded-xl" />
                                </div>
                            </div>
                        </div>

                        <!-- Fallback required fields for DB -->
                        <div class="hidden">
                            <input type="hidden" name="requirements" value="To be discussed">
                        </div>
                    </div>
                </div>

                <!-- Step 5: Describe the Job -->
                <div x-show="step === 5" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6">Describe the job</h3>
                    
                    <div class="custom-quill-wrapper">
                        <x-input-label value="Job description *" class="mb-3 font-bold" />
                        <div id="toolbar-container">
                            <span class="ql-formats flex gap-2">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-list" value="bullet"></button>
                            </span>
                            <span class="ql-formats flex items-center gap-4 text-slate-500 dark:text-slate-400">
                                <button type="button" @click="quill.root.innerHTML = ''" class="hover:text-red-500 transition-colors w-6 h-6 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                                <button type="button" class="hover:text-blue-500 transition-colors w-6 h-6 flex items-center justify-center" title="Keyboard Shortcuts: Ctrl+B (Bold), Ctrl+I (Italic), Ctrl+Shift+8 (List)">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </button>
                            </span>
                        </div>
                        <div id="editor-container" class="h-64 text-slate-800 dark:text-slate-200"></div>
                    </div>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Step 6: Review & Settings -->
                <div x-show="step === 6" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl rounded-3xl overflow-hidden p-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6">Review & Settings</h3>
                    
                    <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 mb-8">
                        <h4 class="font-bold text-lg mb-4 text-slate-800 dark:text-white">Job Details Summary</h4>
                        <div class="grid grid-cols-2 gap-y-3 text-sm">
                            <div class="text-slate-500">Job Title</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.title"></div>
                            
                            <div class="text-slate-500">Country & Language</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.country + ' (' + formData.language + ')'"></div>
                            
                            <div class="text-slate-500">Location</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.location"></div>
                            
                            <div class="text-slate-500">Job Type</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.employment_type"></div>
                            
                            <div class="text-slate-500">Number of openings</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.vacancies"></div>
                            
                            <div class="text-slate-500">Expected hours per week</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200" x-text="formData.expected_hours"></div>
                            
                            <div class="text-slate-500">Pay</div>
                            <div class="font-semibold text-slate-800 dark:text-slate-200">
                                <span x-text="formData.min_salary"></span> 
                                <span x-show="formData.salary_visibility === 'range'" x-text="' - ' + formData.max_salary"></span>
                                <span x-text="' / ' + formData.salary_period"></span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h4 class="font-bold text-lg text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-2">Settings</h4>
                        
                        <div>
                            <x-input-label for="application_method" value="Application method" class="mb-2 font-bold" />
                            <select id="application_method" name="application_method" class="w-full md:w-1/2 px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 transition-all font-medium text-slate-700 dark:text-slate-300">
                                <option value="Email">Candidates contact you (email)</option>
                                <option value="In-app">In-app ATS</option>
                                <option value="External">External Website</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 hover:bg-slate-50 transition-colors cursor-pointer w-full md:w-1/2">
                                <input type="checkbox" name="resume_required" value="1" checked class="w-5 h-5 rounded text-blue-500 focus:ring-blue-500">
                                <span class="font-bold text-slate-700 dark:text-slate-300">Require resume</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700 mt-10">
                    <button type="button" x-show="step > 1" @click="step--" class="px-6 py-3 rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        &larr; Back
                    </button>
                    <div x-show="step === 1"></div> <!-- Spacer for flex layout -->
                    
                    <button type="button" x-show="step < 6" @click="nextStep()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                        Continue
                    </button>
                    
                    <button type="button" x-show="step === 6" @click="submitForm()" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                        Confirm to post job
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('jobWizard', () => ({
                step: 1,
                quill: null,
                formData: {
                    language: 'English',
                    country: 'Pakistan',
                    title: '',
                    category_id: '',
                    custom_category: '',
                    workplace_type: 'on-site',
                    location: '',
                    hiring_timeline: '1-2 weeks',
                    vacancies: 1,
                    employment_type: 'Full-time',
                    experience_level: 'entry',
                    education_level: 'not-required',
                    salary_visibility: 'range',
                    salary_period: 'monthly',
                    min_salary: '',
                    max_salary: '',
                    expected_hours: '40'
                },
                locationQuery: '',
                locationResults: [],
                isSearchingLocation: false,
                selectedLocations: [],
                async searchLocation() {
                    if (this.locationQuery.length < 3) {
                        this.locationResults = [];
                        return;
                    }
                    this.isSearchingLocation = true;
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.locationQuery)}`);
                        this.locationResults = await response.json();
                    } catch (error) {
                        console.error('Error fetching locations:', error);
                    }
                    this.isSearchingLocation = false;
                },
                selectLocation(result) {
                    if (!this.selectedLocations.includes(result.display_name)) {
                        this.selectedLocations.push(result.display_name);
                    }
                    this.locationQuery = '';
                    this.locationResults = [];
                    // Keep formData.location synced for summary step
                    this.formData.location = this.selectedLocations.join(' | ');
                },
                removeLocation(index) {
                    this.selectedLocations.splice(index, 1);
                    this.formData.location = this.selectedLocations.join(' | ');
                },
                init() {
                    // Initialize Quill Editor for Step 5
                    setTimeout(() => {
                        this.quill = new Quill('#editor-container', {
                            theme: 'snow',
                            placeholder: 'Type your job description here...',
                            modules: {
                                toolbar: '#toolbar-container'
                            }
                        });
                    }, 100);
                },
                nextStep() {
                    // Basic validation
                    if (this.step === 1 && (!this.formData.title || !this.formData.category_id || this.selectedLocations.length === 0)) {
                        alert('Please fill out all required fields marked with *');
                        return;
                    }
                    if (this.step === 2 && !this.formData.vacancies) {
                        alert('Please enter number of vacancies.');
                        return;
                    }
                    if (this.step === 3 && !this.formData.employment_type) {
                        alert('Please select job type.');
                        return;
                    }
                    if (this.step === 5) {
                        const content = this.quill.root.innerHTML;
                        if (content === '<p><br></p>') {
                            alert('Please write a job description.');
                            return;
                        }
                    }
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },
                submitForm() {
                    document.getElementById('hidden-description').value = this.quill.root.innerHTML;
                    document.getElementById('job-form').submit();
                }
            }));
        });
    </script>
</x-app-layout>
