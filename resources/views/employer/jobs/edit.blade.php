<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Edit Job Opening: ') }} {{ $job->title }}
            </h2>
            <a href="{{ route('employer.jobs.index') }}">
                &larr; Back to Listings
            </a>
        </div>
    </x-slot>

    <div>
        <div>
            <div>
                
                <form method="POST" action="{{ route('employer.jobs.update', $job->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Basic Info -->
                    <div>
                        <h4>Basic Job Information</h4>
                        <div>
                            <div>
                                <x-input-label for="title" :value="__('Job Title')" />
                                <x-text-input id="title" name="title" type="text" :value="old('title', $job->title)" required />
                                <x-input-error :messages="$errors->get('title')" />
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="category_id" :value="__('Job Category')" />
                                    <select id="category_id" name="category_id" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" @selected($job->category_id == $cat->id)>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" />
                                </div>
                                <div>
                                    <x-input-label for="vacancies" :value="__('Number of Vacancies')" />
                                    <x-text-input id="vacancies" name="vacancies" type="number" :value="old('vacancies', $job->vacancies)" min="1" required />
                                    <x-input-error :messages="$errors->get('vacancies')" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="employment_type" :value="__('Employment Type')" />
                                    <select id="employment_type" name="employment_type" required>
                                        <option value="full-time" @selected($job->employment_type == 'full-time')>Full-time</option>
                                        <option value="part-time" @selected($job->employment_type == 'part-time')>Part-time</option>
                                        <option value="contract" @selected($job->employment_type == 'contract')>Contract</option>
                                        <option value="internship" @selected($job->employment_type == 'internship')>Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="workplace_type" :value="__('Workplace Type')" />
                                    <select id="workplace_type" name="workplace_type" required>
                                        <option value="remote" @selected($job->workplace_type == 'remote')>Remote</option>
                                        <option value="hybrid" @selected($job->workplace_type == 'hybrid')>Hybrid</option>
                                        <option value="on-site" @selected($job->workplace_type == 'on-site')>On-site</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="experience_level" :value="__('Experience Level')" />
                                    <select id="experience_level" name="experience_level" required>
                                        <option value="entry" @selected($job->experience_level == 'entry')>Entry Level</option>
                                        <option value="junior" @selected($job->experience_level == 'junior')>Junior</option>
                                        <option value="mid" @selected($job->experience_level == 'mid')>Mid-Level</option>
                                        <option value="senior" @selected($job->experience_level == 'senior')>Senior</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="education_level" :value="__('Education Level')" />
                                    <select id="education_level" name="education_level" required>
                                        <option value="not-required" @selected($job->education_level == 'not-required')>Not Required</option>
                                        <option value="high-school" @selected($job->education_level == 'high-school')>High School</option>
                                        <option value="bachelors" @selected($job->education_level == 'bachelors')>Bachelor's</option>
                                        <option value="masters" @selected($job->education_level == 'masters')>Master's</option>
                                        <option value="phd" @selected($job->education_level == 'phd')>PhD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Detailed Text Specs -->
                    <div>
                        <h4>Description & Requirements</h4>
                        <div>
                            <div>
                                <x-input-label for="description" :value="__('Job Description')" />
                                <textarea id="description" name="description" rows="5" required>{{ old('description', $job->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="responsibilities" :value="__('Key Responsibilities')" />
                                <textarea id="responsibilities" name="responsibilities" rows="4">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="requirements" :value="__('Requirements / Core Prerequisites')" />
                                <textarea id="requirements" name="requirements" rows="4" required>{{ old('requirements', $job->requirements) }}</textarea>
                                <x-input-error :messages="$errors->get('requirements')" />
                            </div>

                            <div>
                                <x-input-label for="benefits" :value="__('Benefits & Perks')" />
                                <textarea id="benefits" name="benefits" rows="3">{{ old('benefits', $job->benefits) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Compensation & Location -->
                    <div>
                        <h4>Compensation & Location</h4>
                        <div>
                            <div>
                                <div>
                                    <x-input-label for="salary_visibility" :value="__('Salary Visibility')" />
                                    <select id="salary_visibility" name="salary_visibility" required>
                                        <option value="range" @selected($job->salary_visibility == 'range')>Show Range</option>
                                        <option value="exact" @selected($job->salary_visibility == 'exact')>Show Exact</option>
                                        <option value="hidden" @selected($job->salary_visibility == 'hidden')>Hide Salary</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="currency" :value="__('Currency')" />
                                    <x-text-input id="currency" name="currency" type="text" :value="old('currency', $job->currency)" required />
                                </div>
                                <div>
                                    <x-input-label for="min_salary" :value="__('Minimum Salary')" />
                                    <x-text-input id="min_salary" name="min_salary" type="number" :value="old('min_salary', $job->min_salary)" />
                                </div>
                                <div>
                                    <x-input-label for="max_salary" :value="__('Maximum Salary')" />
                                    <x-text-input id="max_salary" name="max_salary" type="number" :value="old('max_salary', $job->max_salary)" />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <x-input-label for="salary_period" :value="__('Salary Period')" />
                                    <select id="salary_period" name="salary_period" required>
                                        <option value="yearly" @selected($job->salary_period == 'yearly')>Yearly</option>
                                        <option value="monthly" @selected($job->salary_period == 'monthly')>Monthly</option>
                                        <option value="hourly" @selected($job->salary_period == 'hourly')>Hourly</option>
                                    </select>
                                </div>
                                <div>
                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" :value="old('country', $job->country)" required />
                                    </div>
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" :value="old('city', $job->city)" required />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="full_address" :value="__('Full Address (Optional)')" />
                                <x-text-input id="full_address" name="full_address" type="text" :value="old('full_address', $job->full_address)" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Skills Checkbox -->
                    <div>
                        <h4>Select Required Skills</h4>
                        <div>
                            @foreach($skills as $skill)
                                <label>
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" @checked(in_array($skill->id, $selectedSkills)) />
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Section: Screening Questions -->
                    <div x-data="{ questions: {{ json_encode($job->screeningQuestions->map(fn($q) => ['text' => $q->question_text, 'required' => $q->is_required])) }} }">
                        <h4>Screening Questions (Optional)</h4>
                        <p>Add up to 5 custom questions for candidates to answer during application.</p>
                        
                        <div>
                            <template x-for="(q, idx) in questions" :key="idx">
                                <div>
                                    <div>
                                        <x-input-label x-text="'Question #' + (idx + 1)" />
                                        <input type="text" :name="'questions[' + idx + ']'" x-model="q.text" required placeholder="e.g. How many years of experience do you have with Laravel?" />
                                    </div>
                                    <div>
                                        <span>Required</span>
                                        <input type="checkbox" :name="'questions_required[' + idx + ']'" value="1" x-model="q.required" />
                                    </div>
                                    <div>
                                        <button type="button" @click="questions.splice(idx, 1)">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="if (questions.length < 5) questions.push({ text: '', required: true })" :disabled="questions.length >= 5">
                            + Add Question
                        </button>
                    </div>

                    <!-- Section 5: Application Rules & Publishing -->
                    <div>
                        <h4>Settings & Publishing</h4>
                        <div>
                            <div>
                                <x-input-label for="application_deadline" :value="__('Application Deadline')" />
                                <input id="application_deadline" name="application_deadline" type="date" value="{{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d') : '' }}" />
                            </div>
                            <div>
                                <x-input-label for="max_applications" :value="__('Maximum Applications Cap')" />
                                <x-text-input id="max_applications" name="max_applications" type="number" :value="old('max_applications', $job->max_applications)" />
                            </div>
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="auto_close_on_deadline" value="1" @checked($job->auto_close_on_deadline)>
                                Auto Close on Deadline
                            </label>
                            <label>
                                <input type="checkbox" name="allow_cover_letter" value="1" @checked($job->allow_cover_letter)>
                                Allow Cover Letter
                            </label>
                            <label>
                                <input type="checkbox" name="resume_required" value="1" @checked($job->resume_required)>
                                Resume Required
                            </label>
                            <label>
                                <input type="checkbox" name="portfolio_required" value="1" @checked($job->portfolio_required)>
                                Portfolio Required
                            </label>
                        </div>

                        <div>
                            <div>
                                <label>
                                    Publish Status:
                                    <select name="status">
                                        <option value="published" @selected($job->status == 'published')>Published</option>
                                        <option value="draft" @selected($job->status == 'draft')>Draft</option>
                                        <option value="paused" @selected($job->status == 'paused')>Paused</option>
                                        <option value="closed" @selected($job->status == 'closed')>Closed</option>
                                        <option value="archived" @selected($job->status == 'archived')>Archived</option>
                                    </select>
                                </label>
                            </div>
                            <button type="submit">
                                Update Job Opening
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
