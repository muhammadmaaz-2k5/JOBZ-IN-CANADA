<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Professional Profile') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-500/30 text-amber-800 dark:text-amber-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Completion Tracker Widget -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Profile Completeness</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Complete your profile to unlock one-click applications and personalized recommendations.</p>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="w-full md:w-48 bg-gray-200 dark:bg-gray-700 h-3 rounded-full overflow-hidden">
                            <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $seekerProfile->profile_completion }}%"></div>
                        </div>
                        <span class="font-extrabold text-indigo-600 dark:text-indigo-400 text-lg">{{ $seekerProfile->profile_completion }}%</span>
                    </div>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar: Basic Info & Photo -->
                <div class="space-y-8 lg:col-span-2">
                    <!-- Personal & Profile Form -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">&check;</span>
                            Personal Information
                        </h3>

                        <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="first_name" :value="__('First Name')" />
                                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('Last Name')" />
                                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Country')" />
                                    <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" />
                                </div>
                                <div>
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                                </div>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700/50 pt-6 space-y-6">
                                <div>
                                    <x-input-label for="headline" :value="__('Professional Headline')" />
                                    <x-text-input id="headline" name="headline" type="text" class="mt-1 block w-full" :value="old('headline', $seekerProfile->headline)" placeholder="e.g., Senior Full Stack Developer | Laravel Expert" />
                                </div>
                                <div>
                                    <x-input-label for="summary" :value="__('About Me / Summary')" />
                                    <textarea id="summary" name="summary" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">{{ old('summary', $seekerProfile->summary) }}</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 dark:border-gray-700/50 pt-6">
                                <div>
                                    <x-input-label for="current_salary" :value="__('Current Salary (CAD / Year)')" />
                                    <x-text-input id="current_salary" name="current_salary" type="number" class="mt-1 block w-full" :value="old('current_salary', $seekerProfile->current_salary)" />
                                </div>
                                <div>
                                    <x-input-label for="expected_salary" :value="__('Expected Salary (CAD / Year)')" />
                                    <x-text-input id="expected_salary" name="expected_salary" type="number" class="mt-1 block w-full" :value="old('expected_salary', $seekerProfile->expected_salary)" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="notice_period" :value="__('Notice Period')" />
                                    <x-text-input id="notice_period" name="notice_period" type="text" class="mt-1 block w-full" :value="old('notice_period', $seekerProfile->notice_period)" placeholder="e.g. 1 Month, Immediate" />
                                </div>
                                <div>
                                    <x-input-label for="employment_preference" :value="__('Job Type Preference')" />
                                    <select id="employment_preference" name="employment_preference" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                        <option value="full-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'full-time')>Full-time</option>
                                        <option value="part-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'part-time')>Part-time</option>
                                        <option value="contract" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'contract')>Contract</option>
                                        <option value="remote" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'remote')>Remote</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="career_level" :value="__('Career Level')" />
                                    <select id="career_level" name="career_level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                        <option value="entry" @selected(old('career_level', $seekerProfile->career_level) == 'entry')>Entry Level</option>
                                        <option value="mid" @selected(old('career_level', $seekerProfile->career_level) == 'mid')>Mid Level</option>
                                        <option value="senior" @selected(old('career_level', $seekerProfile->career_level) == 'senior')>Senior Level</option>
                                        <option value="lead" @selected(old('career_level', $seekerProfile->career_level) == 'lead')>Lead / Manager</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 dark:border-gray-700/50 pt-6">
                                <div>
                                    <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                                    <input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950 dark:file:text-indigo-400 hover:file:bg-indigo-100" />
                                </div>
                                <div>
                                    <x-input-label for="work_authorization" :value="__('Work Authorization')" />
                                    <x-text-input id="work_authorization" name="work_authorization" type="text" class="mt-1 block w-full" :value="old('work_authorization', $seekerProfile->work_authorization)" placeholder="e.g. Canadian Citizen, Work Permit" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 dark:border-gray-700/50 pt-6">
                                <div>
                                    <x-input-label for="linkedin" :value="__('LinkedIn URL')" />
                                    <x-text-input id="linkedin" name="linkedin" type="url" class="mt-1 block w-full" :value="old('linkedin', $seekerProfile->linkedin)" />
                                </div>
                                <div>
                                    <x-input-label for="github" :value="__('GitHub URL')" />
                                    <x-text-input id="github" name="github" type="url" class="mt-1 block w-full" :value="old('github', $seekerProfile->github)" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition duration-150 shadow-md">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Work Experience Card -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">&check;</span>
                                Work Experience
                            </span>
                        </h3>

                        <!-- Add Experience Inline Form -->
                        <form method="POST" action="{{ route('seeker.experience.add') }}" class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200/50 dark:border-gray-700/50 space-y-4">
                            @csrf
                            <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Add New Work Experience</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="company" placeholder="Company Name" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <input type="text" name="designation" placeholder="Job Title / Designation" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <input type="date" name="start_date" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <input type="date" name="end_date" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <select name="employment_type" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <textarea name="description" placeholder="Describe your achievements and tasks..." rows="3" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition">
                                    + Add Experience
                                </button>
                            </div>
                        </form>

                        <div class="space-y-4">
                            @forelse($experiences as $exp)
                                <div class="p-4 border border-gray-100 dark:border-gray-700 rounded-xl flex justify-between items-start gap-4">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $exp->designation }}</h4>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $exp->company }} &bull; {{ $exp->employment_type }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} &ndash; 
                                            {{ $exp->currently_working ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                                        </p>
                                        @if($exp->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('seeker.experience.delete', $exp->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">&times; Remove</button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No work experience added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Education Card -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">&check;</span>
                            Education
                        </h3>

                        <form method="POST" action="{{ route('seeker.education.add') }}" class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200/50 dark:border-gray-700/50 space-y-4">
                            @csrf
                            <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">Add Education</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="institution" placeholder="School / University" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <input type="text" name="degree" placeholder="Degree / Diploma" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <input type="text" name="field_of_study" placeholder="Field of Study" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <input type="date" name="start_date" required class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                                <div>
                                    <input type="date" name="end_date" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div>
                                <input type="text" name="grade" placeholder="GPA / Grade (Optional)" class="w-full text-sm rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition">
                                    + Add Education
                                </button>
                            </div>
                        </form>

                        <div class="space-y-4">
                            @forelse($education as $edu)
                                <div class="p-4 border border-gray-100 dark:border-gray-700 rounded-xl flex justify-between items-start gap-4">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $edu->degree }} &bull; {{ $edu->field_of_study }}</h4>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $edu->institution }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} &ndash; 
                                            {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Present' }}
                                            @if($edu->grade)
                                                &bull; Grade: {{ $edu->grade }}
                                            @endif
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('seeker.education.delete', $edu->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs">&times; Remove</button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No education history added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Resume Library & Skills -->
                <div class="space-y-8">
                    <!-- Resume Library Card -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">&check;</span>
                            Resume Library
                        </h3>

                        <!-- Resume Upload Form -->
                        <form method="POST" action="{{ route('seeker.resume.upload') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="resume_title" :value="__('Resume Label')" />
                                <x-text-input id="resume_title" name="title" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. Senior Laravel Resume" required />
                            </div>
                            <div>
                                <input id="resume_file" name="resume_file" type="file" required class="w-full text-xs text-gray-500 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950 dark:file:text-indigo-400 hover:file:bg-indigo-100" />
                                <p class="text-2xs text-gray-400 mt-1">PDF, DOC, DOCX up to 5MB.</p>
                            </div>
                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                                Upload Resume
                            </button>
                        </form>

                        <!-- Resumes list -->
                        <div class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4">
                            @forelse($resumes as $res)
                                <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl flex items-center justify-between border border-gray-100 dark:border-gray-800">
                                    <div class="truncate mr-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-sm text-gray-900 dark:text-gray-100 truncate">{{ $res->title }}</span>
                                            @if($res->is_default)
                                                <span class="px-2 py-0.5 bg-indigo-500 text-white text-2xs font-extrabold rounded-full">Default</span>
                                            @endif
                                        </div>
                                        <span class="text-2xs text-gray-400 truncate block">{{ $res->original_name }} &bull; {{ round($res->file_size / 1024, 1) }} KB</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('seeker.resume.download', $res->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 text-2xs font-bold">Download</a>
                                        @if(!$res->is_default)
                                            <form method="POST" action="{{ route('seeker.resume.default', $res->id) }}">
                                                @csrf
                                                <button type="submit" class="text-gray-500 hover:text-indigo-600 text-2xs font-bold">Set Default</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('seeker.resume.delete', $res->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">&times;</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-2">No resumes uploaded yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills Management -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">&check;</span>
                            Professional Skills
                        </h3>

                        <form method="POST" action="{{ route('seeker.skills.sync') }}" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <x-input-label :value="__('Select your skills')" />
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto p-2 bg-gray-50 dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800">
                                    @forelse($allSkills as $skill)
                                        <label class="flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 cursor-pointer">
                                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" @checked($skills->contains($skill->id)) class="rounded text-indigo-600 focus:ring-indigo-500" />
                                            {{ $skill->name }}
                                        </label>
                                    @empty
                                        <p class="text-2xs text-gray-400 text-center col-span-2 py-4">No skills available to select.</p>
                                    @endforelse
                                </div>
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition">
                                Update Skills
                            </button>
                        </form>
                    </div>

                    <!-- Projects & Certifications Card -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Projects</h3>
                            
                            <form method="POST" action="{{ route('seeker.project.add') }}" class="space-y-3 p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-gray-100 dark:border-gray-800 mb-4">
                                @csrf
                                <input type="text" name="project_name" placeholder="Project Name" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                <input type="text" name="technologies" placeholder="Technologies (e.g. PHP, Vue)" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                <input type="url" name="url" placeholder="Project URL (e.g. Live Link)" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                <button type="submit" class="w-full py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-xl transition">+ Add Project</button>
                            </form>

                            <div class="space-y-2">
                                @foreach($projects as $proj)
                                    <div class="p-3 border border-gray-100 dark:border-gray-800 rounded-xl flex justify-between items-center text-xs">
                                        <div>
                                            <span class="font-bold text-gray-900 dark:text-gray-100 block">{{ $proj->project_name }}</span>
                                            <span class="text-2xs text-gray-500 block">{{ $proj->technologies }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.project.delete', $proj->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">&times;</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Certifications</h3>
                            
                            <form method="POST" action="{{ route('seeker.certification.add') }}" class="space-y-3 p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-gray-100 dark:border-gray-800 mb-4">
                                @csrf
                                <input type="text" name="name" placeholder="Certification Name" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                <input type="text" name="organization" placeholder="Issuing Organization" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="date" name="issue_date" required class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                    <input type="date" name="expiry_date" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                                </div>
                                <button type="submit" class="w-full py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-xl transition">+ Add Cert</button>
                            </form>

                            <div class="space-y-2">
                                @foreach($certifications as $cert)
                                    <div class="p-3 border border-gray-100 dark:border-gray-800 rounded-xl flex justify-between items-center text-xs">
                                        <div>
                                            <span class="font-bold text-gray-900 dark:text-gray-100 block">{{ $cert->name }}</span>
                                            <span class="text-2xs text-gray-500 block">{{ $cert->organization }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.certification.delete', $cert->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">&times;</button>
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
