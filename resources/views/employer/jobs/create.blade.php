<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Post a New Job Opening') }}
            </h2>
            <a href="{{ route('employer.jobs.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Listings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-6">
                
                <form method="POST" action="{{ route('employer.jobs.store') }}" class="space-y-8">
                    @csrf

                    <!-- Section 1: Basic Info -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-6">Basic Job Information</h4>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" :value="__('Job Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required placeholder="e.g. Senior Backend Engineer (Laravel)" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="category_id" :value="__('Job Category')" />
                                    <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl shadow-sm">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="vacancies" :value="__('Number of Vacancies')" />
                                    <x-text-input id="vacancies" name="vacancies" type="number" class="mt-1 block w-full" value="1" min="1" required />
                                    <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-2">
                                <div>
                                    <x-input-label for="employment_type" :value="__('Employment Type')" />
                                    <select id="employment_type" name="employment_type" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
                                        <option value="full-time">Full-time</option>
                                        <option value="part-time">Part-time</option>
                                        <option value="contract">Contract</option>
                                        <option value="internship">Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="workplace_type" :value="__('Workplace Type')" />
                                    <select id="workplace_type" name="workplace_type" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="on-site">On-site</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="experience_level" :value="__('Experience Level')" />
                                    <select id="experience_level" name="experience_level" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
                                        <option value="entry">Entry Level</option>
                                        <option value="junior">Junior</option>
                                        <option value="mid">Mid-Level</option>
                                        <option value="senior">Senior</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="education_level" :value="__('Education Level')" />
                                    <select id="education_level" name="education_level" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
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

                    <!-- Section 2: Detailed Text Specs -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-6">Description & Requirements</h4>
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="description" :value="__('Job Description')" />
                                <textarea id="description" name="description" rows="5" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm" placeholder="Summarize the overall role mission, challenges, and team dynamics..."></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="responsibilities" :value="__('Key Responsibilities')" />
                                <textarea id="responsibilities" name="responsibilities" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm" placeholder="List the daily and long-term tasks..."></textarea>
                            </div>

                            <div>
                                <x-input-label for="requirements" :value="__('Requirements / Core Prerequisites')" />
                                <textarea id="requirements" name="requirements" rows="4" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm" placeholder="List required tech stack experiences, tools, and background..."></textarea>
                                <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="benefits" :value="__('Benefits & Perks')" />
                                <textarea id="benefits" name="benefits" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm" placeholder="List office perks, insurance coverage, remote allowances..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Compensation & Location -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-6">Compensation & Location</h4>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-input-label for="salary_visibility" :value="__('Salary Visibility')" />
                                    <select id="salary_visibility" name="salary_visibility" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
                                        <option value="range">Show Range</option>
                                        <option value="exact">Show Exact</option>
                                        <option value="hidden">Hide Salary</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="currency" :value="__('Currency')" />
                                    <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-full text-xs" value="CAD" required />
                                </div>
                                <div>
                                    <x-input-label for="min_salary" :value="__('Minimum Salary')" />
                                    <x-text-input id="min_salary" name="min_salary" type="number" class="mt-1 block w-full text-xs" placeholder="0.00" />
                                </div>
                                <div>
                                    <x-input-label for="max_salary" :value="__('Maximum Salary')" />
                                    <x-text-input id="max_salary" name="max_salary" type="number" class="mt-1 block w-full text-xs" placeholder="0.00" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="salary_period" :value="__('Salary Period')" />
                                    <select id="salary_period" name="salary_period" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs">
                                        <option value="yearly">Yearly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="hourly">Hourly</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full text-xs" value="Canada" required />
                                    </div>
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full text-xs" placeholder="e.g. Toronto" required />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="full_address" :value="__('Full Address (Optional)')" />
                                <x-text-input id="full_address" name="full_address" type="text" class="mt-1 block w-full text-xs" placeholder="e.g. Suite 400, 100 King St W" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Skills Checkbox -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-6">Select Required Skills</h4>
                        <div class="grid grid-cols-3 md:grid-cols-5 gap-3 p-3 bg-gray-50 dark:bg-gray-950 rounded-xl border border-gray-100 dark:border-gray-900">
                            @foreach($skills as $skill)
                                <label class="flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="rounded text-indigo-650 focus:ring-indigo-500" />
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Section: Screening Questions -->
                    <div x-data="{ questions: [] }" class="border-t border-gray-100 dark:border-gray-700/50 pt-6">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Screening Questions (Optional)</h4>
                        <p class="text-xs text-gray-500 mb-4">Add up to 5 custom questions for candidates to answer during application.</p>
                        
                        <div class="space-y-3 mb-4">
                            <template x-for="(q, idx) in questions" :key="idx">
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-150 dark:border-gray-800">
                                    <div class="flex-grow">
                                        <x-input-label x-text="'Question #' + (idx + 1)" />
                                        <input type="text" :name="'questions[' + idx + ']'" x-model="q.text" required class="mt-1 block w-full border-gray-300 dark:border-gray-750 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-sm" placeholder="e.g. How many years of experience do you have with Laravel?" />
                                    </div>
                                    <div class="flex flex-col items-center pt-5">
                                        <span class="text-3xs font-semibold text-gray-400 mb-1">Required</span>
                                        <input type="checkbox" :name="'questions_required[' + idx + ']'" value="1" x-model="q.required" class="rounded text-indigo-650 focus:ring-indigo-500" />
                                    </div>
                                    <div class="pt-5">
                                        <button type="button" @click="questions.splice(idx, 1)" class="p-2 text-red-650 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-xl transition text-sm">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="if (questions.length < 5) questions.push({ text: '', required: true })" :disabled="questions.length >= 5" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-950 text-indigo-650 dark:text-indigo-400 font-bold rounded-xl text-xs hover:bg-indigo-100 transition disabled:opacity-50">
                            + Add Question
                        </button>
                    </div>

                    <!-- Section 5: Application Rules & Publishing -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-6">Settings & Publishing</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6">
                            <div>
                                <x-input-label for="application_deadline" :value="__('Application Deadline')" />
                                <input id="application_deadline" name="application_deadline" type="date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm shadow-sm" />
                            </div>
                            <div>
                                <x-input-label for="max_applications" :value="__('Maximum Applications Cap')" />
                                <x-text-input id="max_applications" name="max_applications" type="number" class="mt-1 block w-full" placeholder="e.g. 100 (Optional)" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="auto_close_on_deadline" value="1" checked>
                                Auto Close on Deadline
                            </label>
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="allow_cover_letter" value="1" checked>
                                Allow Cover Letter
                            </label>
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="resume_required" value="1" checked>
                                Resume Required
                            </label>
                            <label class="flex items-center gap-2 text-xs text-gray-650 dark:text-gray-300">
                                <input type="checkbox" name="portfolio_required" value="1">
                                Portfolio Required
                            </label>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50 flex justify-between items-center">
                            <div>
                                <label class="inline-flex items-center gap-2 text-xs font-semibold text-gray-750 dark:text-gray-300">
                                    Publish Status:
                                    <select name="status" class="rounded-xl border-gray-300 text-xs py-1 px-3">
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </label>
                            </div>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-md">
                                Save Job Opening
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
