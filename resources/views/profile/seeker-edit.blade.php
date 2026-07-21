<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Professional Profile') }}
            </h2>
            <a href="{{ route('dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div>
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Completion Tracker Widget -->
            <div>
                <div>
                    <div>
                        <h3>Profile Completeness</h3>
                        <p>Complete your profile to unlock one-click applications and personalized recommendations.</p>
                    </div>
                    <div>
                        <div>
                            <div></div>
                        </div>
                        <span>{{ $seekerProfile->profile_completion }}%</span>
                    </div>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div>
                <!-- Left Sidebar: Basic Info & Photo -->
                <div>
                    <!-- Personal & Profile Form -->
                    <div>
                        <h3>
                            <span>&check;</span>
                            Personal Information
                        </h3>

                        <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div>
                                <div>
                                    <x-input-label for="first_name" :value="__('First Name')" />
                                    <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $user->first_name)" required />
                                    <x-input-error :messages="$errors->get('first_name')" />
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('Last Name')" />
                                    <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $user->last_name)" required />
                                    <x-input-error :messages="$errors->get('last_name')" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" />
                                    <x-text-input id="phone" name="phone" type="text" :value="old('phone', $user->phone)" />
                                </div>
                                <div>
                                    <x-input-label for="country" :value="__('Country')" />
                                    <x-text-input id="country" name="country" type="text" :value="old('country', $user->country)" />
                                </div>
                                <div>
                                    <x-input-label for="city" :value="__('City')" />
                                    <x-text-input id="city" name="city" type="text" :value="old('city', $user->city)" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="headline" :value="__('Professional Headline')" />
                                    <x-text-input id="headline" name="headline" type="text" :value="old('headline', $seekerProfile->headline)" placeholder="e.g., Senior Full Stack Developer | Laravel Expert" />
                                </div>
                                <div>
                                    <x-input-label for="summary" :value="__('About Me / Summary')" />
                                    <textarea id="summary" name="summary" rows="4">{{ old('summary', $seekerProfile->summary) }}</textarea>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="current_salary" :value="__('Current Salary (CAD / Year)')" />
                                    <x-text-input id="current_salary" name="current_salary" type="number" :value="old('current_salary', $seekerProfile->current_salary)" />
                                </div>
                                <div>
                                    <x-input-label for="expected_salary" :value="__('Expected Salary (CAD / Year)')" />
                                    <x-text-input id="expected_salary" name="expected_salary" type="number" :value="old('expected_salary', $seekerProfile->expected_salary)" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="notice_period" :value="__('Notice Period')" />
                                    <x-text-input id="notice_period" name="notice_period" type="text" :value="old('notice_period', $seekerProfile->notice_period)" placeholder="e.g. 1 Month, Immediate" />
                                </div>
                                <div>
                                    <x-input-label for="employment_preference" :value="__('Job Type Preference')" />
                                    <select id="employment_preference" name="employment_preference">
                                        <option value="full-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'full-time')>Full-time</option>
                                        <option value="part-time" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'part-time')>Part-time</option>
                                        <option value="contract" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'contract')>Contract</option>
                                        <option value="remote" @selected(old('employment_preference', $seekerProfile->employment_preference) == 'remote')>Remote</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="career_level" :value="__('Career Level')" />
                                    <select id="career_level" name="career_level">
                                        <option value="entry" @selected(old('career_level', $seekerProfile->career_level) == 'entry')>Entry Level</option>
                                        <option value="mid" @selected(old('career_level', $seekerProfile->career_level) == 'mid')>Mid Level</option>
                                        <option value="senior" @selected(old('career_level', $seekerProfile->career_level) == 'senior')>Senior Level</option>
                                        <option value="lead" @selected(old('career_level', $seekerProfile->career_level) == 'lead')>Lead / Manager</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                                    <input id="profile_photo" name="profile_photo" type="file" />
                                </div>
                                <div>
                                    <x-input-label for="work_authorization" :value="__('Work Authorization')" />
                                    <x-text-input id="work_authorization" name="work_authorization" type="text" :value="old('work_authorization', $seekerProfile->work_authorization)" placeholder="e.g. Canadian Citizen, Work Permit" />
                                </div>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="linkedin" :value="__('LinkedIn URL')" />
                                    <x-text-input id="linkedin" name="linkedin" type="url" :value="old('linkedin', $seekerProfile->linkedin)" />
                                </div>
                                <div>
                                    <x-input-label for="github" :value="__('GitHub URL')" />
                                    <x-text-input id="github" name="github" type="url" :value="old('github', $seekerProfile->github)" />
                                </div>
                            </div>

                            <div>
                                <button type="submit">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Work Experience Card -->
                    <div>
                        <h3>
                            <span>
                                <span>&check;</span>
                                Work Experience
                            </span>
                        </h3>

                        <!-- Add Experience Inline Form -->
                        <form method="POST" action="{{ route('seeker.experience.add') }}">
                            @csrf
                            <h4>Add New Work Experience</h4>
                            <div>
                                <div>
                                    <input type="text" name="company" placeholder="Company Name" required />
                                </div>
                                <div>
                                    <input type="text" name="designation" placeholder="Job Title / Designation" required />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="date" name="start_date" required />
                                </div>
                                <div>
                                    <input type="date" name="end_date" />
                                </div>
                                <div>
                                    <select name="employment_type">
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <textarea name="description" placeholder="Describe your achievements and tasks..." rows="3"></textarea>
                            </div>
                            <div>
                                <button type="submit">
                                    + Add Experience
                                </button>
                            </div>
                        </form>

                        <div>
                            @forelse($experiences as $exp)
                                <div>
                                    <div>
                                        <h4>{{ $exp->designation }}</h4>
                                        <p>{{ $exp->company }} &bull; {{ $exp->employment_type }}</p>
                                        <p>
                                            {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} &ndash; 
                                            {{ $exp->currently_working ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                                        </p>
                                        @if($exp->description)
                                            <p>{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('seeker.experience.delete', $exp->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">&times; Remove</button>
                                    </form>
                                </div>
                            @empty
                                <p>No work experience added yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Education Card -->
                    <div>
                        <h3>
                            <span>&check;</span>
                            Education
                        </h3>

                        <form method="POST" action="{{ route('seeker.education.add') }}">
                            @csrf
                            <h4>Add Education</h4>
                            <div>
                                <div>
                                    <input type="text" name="institution" placeholder="School / University" required />
                                </div>
                                <div>
                                    <input type="text" name="degree" placeholder="Degree / Diploma" required />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="text" name="field_of_study" placeholder="Field of Study" />
                                </div>
                                <div>
                                    <input type="date" name="start_date" required />
                                </div>
                                <div>
                                    <input type="date" name="end_date" />
                                </div>
                            </div>
                            <div>
                                <input type="text" name="grade" placeholder="GPA / Grade (Optional)" />
                            </div>
                            <div>
                                <button type="submit">
                                    + Add Education
                                </button>
                            </div>
                        </form>

                        <div>
                            @forelse($education as $edu)
                                <div>
                                    <div>
                                        <h4>{{ $edu->degree }} &bull; {{ $edu->field_of_study }}</h4>
                                        <p>{{ $edu->institution }}</p>
                                        <p>
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
                                        <button type="submit">&times; Remove</button>
                                    </form>
                                </div>
                            @empty
                                <p>No education history added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Resume Library & Skills -->
                <div>
                    <!-- Resume Library Card -->
                    <div>
                        <h3>
                            <span>&check;</span>
                            Resume Library
                        </h3>

                        <!-- Resume Upload Form -->
                        <form method="POST" action="{{ route('seeker.resume.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <x-input-label for="resume_title" :value="__('Resume Label')" />
                                <x-text-input id="resume_title" name="title" type="text" placeholder="e.g. Senior Laravel Resume" required />
                            </div>
                            <div>
                                <input id="resume_file" name="resume_file" type="file" required />
                                <p>PDF, DOC, DOCX up to 5MB.</p>
                            </div>
                            <button type="submit">
                                Upload Resume
                            </button>
                        </form>

                        <!-- Resumes list -->
                        <div>
                            @forelse($resumes as $res)
                                <div>
                                    <div>
                                        <div>
                                            <span>{{ $res->title }}</span>
                                            @if($res->is_default)
                                                <span>Default</span>
                                            @endif
                                        </div>
                                        <span>{{ $res->original_name }} &bull; {{ round($res->file_size / 1024, 1) }} KB</span>
                                    </div>
                                    <div>
                                        <a href="{{ route('seeker.resume.download', $res->id) }}">Download</a>
                                        @if(!$res->is_default)
                                            <form method="POST" action="{{ route('seeker.resume.default', $res->id) }}">
                                                @csrf
                                                <button type="submit">Set Default</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('seeker.resume.delete', $res->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">&times;</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p>No resumes uploaded yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills Management -->
                    <div>
                        <h3>
                            <span>&check;</span>
                            Professional Skills
                        </h3>

                        <form method="POST" action="{{ route('seeker.skills.sync') }}">
                            @csrf
                            <div>
                                <x-input-label :value="__('Select your skills')" />
                                <div>
                                    @forelse($allSkills as $skill)
                                        <label>
                                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" @checked($skills->contains($skill->id)) />
                                            {{ $skill->name }}
                                        </label>
                                    @empty
                                        <p>No skills available to select.</p>
                                    @endforelse
                                </div>
                            </div>

                            <button type="submit">
                                Update Skills
                            </button>
                        </form>
                    </div>

                    <!-- Projects & Certifications Card -->
                    <div>
                        <div>
                            <h3>Projects</h3>
                            
                            <form method="POST" action="{{ route('seeker.project.add') }}">
                                @csrf
                                <input type="text" name="project_name" placeholder="Project Name" required />
                                <input type="text" name="technologies" placeholder="Technologies (e.g. PHP, Vue)" />
                                <input type="url" name="url" placeholder="Project URL (e.g. Live Link)" />
                                <button type="submit">+ Add Project</button>
                            </form>

                            <div>
                                @foreach($projects as $proj)
                                    <div>
                                        <div>
                                            <span>{{ $proj->project_name }}</span>
                                            <span>{{ $proj->technologies }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.project.delete', $proj->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">&times;</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3>Certifications</h3>
                            
                            <form method="POST" action="{{ route('seeker.certification.add') }}">
                                @csrf
                                <input type="text" name="name" placeholder="Certification Name" required />
                                <input type="text" name="organization" placeholder="Issuing Organization" required />
                                <div>
                                    <input type="date" name="issue_date" required />
                                    <input type="date" name="expiry_date" />
                                </div>
                                <button type="submit">+ Add Cert</button>
                            </form>

                            <div>
                                @foreach($certifications as $cert)
                                    <div>
                                        <div>
                                            <span>{{ $cert->name }}</span>
                                            <span>{{ $cert->organization }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('seeker.certification.delete', $cert->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">&times;</button>
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
