<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Resume Builder') }}
            </h2>
            <p class="text-sm text-gray-500">Create, customize, and print your professional resume</p>
        </div>
    </x-slot>

    <!-- Styles for print & screen separation -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #resume-print-area, #resume-print-area * {
                visibility: visible;
            }
            #resume-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 210mm; /* A4 width */
                min-height: 297mm; /* A4 height */
                padding: 15mm !important;
                background: white !important;
                color: black !important;
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
            }
            /* Hide non-print elements */
            header, aside, .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen no-print"
         x-data="{
            activeTab: 'personal',
            template: 'modern',
            
            // Resume data models prefilled with DB values
            personal: {
                firstName: '{{ addslashes($user->first_name) }}',
                lastName: '{{ addslashes($user->last_name) }}',
                email: '{{ addslashes($user->email) }}',
                phone: '{{ addslashes($user->phone ?? '') }}',
                location: '{{ addslashes(($user->city ? $user->city . ', ' : '') . ($user->country ?? '')) }}',
                headline: '{{ addslashes($seekerProfile->headline ?? '') }}',
                summary: '{{ addslashes($seekerProfile->summary ?? '') }}',
                website: '{{ addslashes($seekerProfile->website ?? '') }}'
            },
            
            experiences: @json($experiences->map(fn($e) => [
                'company' => $e->company,
                'designation' => $e->designation,
                'start_date' => $e->start_date->format('Y-m'),
                'end_date' => $e->end_date ? $e->end_date->format('Y-m') : '',
                'currently_working' => (bool)$e->currently_working,
                'description' => $e->description
            ])),
            
            education: @json($education->map(fn($ed) => [
                'institution' => $ed->institution,
                'degree' => $ed->degree,
                'field_of_study' => $ed->field_of_study,
                'start_date' => $ed->start_date->format('Y-m'),
                'end_date' => $ed->end_date ? $ed->end_date->format('Y-m') : '',
                'grade' => $ed->grade
            ])),
            
            skills: @json($skills->pluck('name')),
            newSkill: '',
            
            projects: @json($projects->map(fn($p) => [
                'project_name' => $p->project_name,
                'technologies' => $p->technologies,
                'url' => $p->url,
                'description' => $p->description
            ])),
            
            languages: ['English (Fluent)', 'French (Conversational)'],
            newLanguage: '',
            
            certifications: @json($certifications->map(fn($c) => [
                'name' => $c->name,
                'organization' => $c->organization,
                'issue_date' => $c->issue_date->format('Y-m'),
                'credential_url' => $c->credential_url
            ])),
            
            references: [
                { name: 'Dr. Sarah Jenkins', title: 'Senior Director, TechCorp', contact: 'sarah.j@example.com' }
            ],

            addExperience() {
                this.experiences.push({ company: '', designation: '', start_date: '', end_date: '', currently_working: false, description: '' });
            },
            removeExperience(index) {
                this.experiences.splice(index, 1);
            },
            
            addEducation() {
                this.education.push({ institution: '', degree: '', field_of_study: '', start_date: '', end_date: '', grade: '' });
            },
            removeEducation(index) {
                this.education.splice(index, 1);
            },

            addSkill() {
                if (this.newSkill.trim()) {
                    this.skills.push(this.newSkill.trim());
                    this.newSkill = '';
                }
            },
            removeSkill(index) {
                this.skills.splice(index, 1);
            },

            addProject() {
                this.projects.push({ project_name: '', technologies: '', url: '', description: '' });
            },
            removeProject(index) {
                this.projects.splice(index, 1);
            },

            addLanguage() {
                if (this.newLanguage.trim()) {
                    this.languages.push(this.newLanguage.trim());
                    this.newLanguage = '';
                }
            },
            removeLanguage(index) {
                this.languages.splice(index, 1);
            },

            addCertification() {
                this.certifications.push({ name: '', organization: '', issue_date: '', credential_url: '' });
            },
            removeCertification(index) {
                this.certifications.splice(index, 1);
            },

            addReference() {
                this.references.push({ name: '', title: '', contact: '' });
            },
            removeReference(index) {
                this.references.splice(index, 1);
            },

            printResume() {
                window.print();
            }
         }"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Pane: Editor Control Form -->
                <div class="w-full lg:w-1/2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 flex flex-col justify-between">
                    <div>
                        <!-- Section Navigation Tabs -->
                        <div class="flex flex-wrap gap-2 pb-4 border-b border-gray-100 dark:border-gray-700 mb-6">
                            <template x-for="tab in ['personal', 'experience', 'education', 'skills', 'projects', 'languages', 'certifications', 'references']">
                                <button 
                                    @click="activeTab = tab"
                                    :class="activeTab === tab ? 'bg-primary-500 text-white shadow' : 'bg-gray-150 dark:bg-dark-850 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-dark-800'"
                                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-wider transition cursor-pointer"
                                    x-text="tab"
                                >
                                </button>
                            </template>
                        </div>

                        <!-- 1. Personal Info Editor -->
                        <div x-show="activeTab === 'personal'" class="space-y-4" x-transition>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Personal Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">First Name</label>
                                    <input type="text" x-model="personal.firstName" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Last Name</label>
                                    <input type="text" x-model="personal.lastName" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500">Professional Headline</label>
                                <input type="text" x-model="personal.headline" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm" placeholder="e.g. Senior Software Engineer">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Email</label>
                                    <input type="email" x-model="personal.email" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Phone</label>
                                    <input type="text" x-model="personal.phone" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Location</label>
                                    <input type="text" x-model="personal.location" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm" placeholder="City, Province">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500">Website / Portfolio</label>
                                    <input type="text" x-model="personal.website" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500">Professional Summary</label>
                                <textarea rows="4" x-model="personal.summary" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm" placeholder="Brief statement about your career goals, accomplishments..."></textarea>
                            </div>
                        </div>

                        <!-- 2. Professional Experience Editor -->
                        <div x-show="activeTab === 'experience'" class="space-y-4" x-transition>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Work Experience</h3>
                                <button @click="addExperience()" class="px-2.5 py-1 bg-primary-500 text-white rounded text-xs cursor-pointer hover:bg-primary-600 font-semibold">+ Add</button>
                            </div>
                            <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(exp, index) in experiences" :key="index">
                                    <div class="p-4 rounded-xl border border-gray-150 dark:border-gray-700 space-y-3 relative bg-gray-50/50 dark:bg-dark-850">
                                        <button @click="removeExperience(index)" class="absolute right-3 top-3 text-red-500 hover:text-red-600 text-xs font-bold">Remove</button>
                                        
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Company Name</label>
                                                <input type="text" x-model="exp.company" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Role / Title</label>
                                                <input type="text" x-model="exp.designation" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-3 items-center">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Start Date</label>
                                                <input type="month" x-model="exp.start_date" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div x-show="!exp.currently_working">
                                                <label class="block text-[10px] font-semibold text-gray-500">End Date</label>
                                                <input type="month" x-model="exp.end_date" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div class="pt-4 flex items-center">
                                                <label class="inline-flex items-center text-[10px] font-bold text-gray-650 cursor-pointer">
                                                    <input type="checkbox" x-model="exp.currently_working" class="rounded border-gray-300 mr-1.5">
                                                    Current
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-500">Description</label>
                                            <textarea rows="3" x-model="exp.description" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 3. Education Editor -->
                        <div x-show="activeTab === 'education'" class="space-y-4" x-transition>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Education History</h3>
                                <button @click="addEducation()" class="px-2.5 py-1 bg-primary-500 text-white rounded text-xs cursor-pointer hover:bg-primary-600 font-semibold">+ Add</button>
                            </div>
                            <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(edu, index) in education" :key="index">
                                    <div class="p-4 rounded-xl border border-gray-150 dark:border-gray-700 space-y-3 relative bg-gray-50/50 dark:bg-dark-850">
                                        <button @click="removeEducation(index)" class="absolute right-3 top-3 text-red-500 hover:text-red-600 text-xs font-bold">Remove</button>
                                        
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Institution</label>
                                                <input type="text" x-model="edu.institution" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Degree & Field</label>
                                                <input type="text" x-model="edu.degree" placeholder="e.g. B.Sc. Computer Science" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Start Date</label>
                                                <input type="month" x-model="edu.start_date" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">End Date</label>
                                                <input type="month" x-model="edu.end_date" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Grade / GPA (Optional)</label>
                                                <input type="text" x-model="edu.grade" class="w-full mt-0.5 px-2 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 4. Skills Editor -->
                        <div x-show="activeTab === 'skills'" class="space-y-4" x-transition>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Core Skills</h3>
                            
                            <div class="flex gap-2">
                                <input type="text" x-model="newSkill" @keydown.enter.prevent="addSkill()" placeholder="e.g. TailwindCSS" class="flex-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                <button type="button" @click="addSkill()" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-semibold cursor-pointer">Add</button>
                            </div>

                            <div class="flex flex-wrap gap-2 pt-2">
                                <template x-for="(skill, index) in skills" :key="index">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 dark:bg-primary-950/20 text-primary-600 border border-primary-200/50">
                                        <span x-text="skill"></span>
                                        <button type="button" @click="removeSkill(index)" class="ml-1.5 text-gray-400 hover:text-red-500 text-xs">×</button>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- 5. Projects Editor -->
                        <div x-show="activeTab === 'projects'" class="space-y-4" x-transition>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Key Projects</h3>
                                <button @click="addProject()" class="px-2.5 py-1 bg-primary-500 text-white rounded text-xs cursor-pointer hover:bg-primary-600 font-semibold">+ Add</button>
                            </div>
                            <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(proj, index) in projects" :key="index">
                                    <div class="p-4 rounded-xl border border-gray-150 dark:border-gray-700 space-y-3 relative bg-gray-50/50 dark:bg-dark-850">
                                        <button @click="removeProject(index)" class="absolute right-3 top-3 text-red-500 hover:text-red-600 text-xs font-bold">Remove</button>
                                        
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Project Title</label>
                                                <input type="text" x-model="proj.project_name" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">URL / Link</label>
                                                <input type="url" x-model="proj.url" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-500">Technologies Used</label>
                                            <input type="text" x-model="proj.technologies" placeholder="e.g. React, Node, SQL" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-semibold text-gray-500">Description</label>
                                            <textarea rows="2.5" x-model="proj.description" class="w-full mt-0.5 px-2 py-1 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 6. Languages Editor -->
                        <div x-show="activeTab === 'languages'" class="space-y-4" x-transition>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Languages</h3>
                            
                            <div class="flex gap-2">
                                <input type="text" x-model="newLanguage" @keydown.enter.prevent="addLanguage()" placeholder="e.g. English (Native)" class="flex-1 px-3 py-2 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-sm">
                                <button type="button" @click="addLanguage()" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-semibold cursor-pointer">Add</button>
                            </div>

                            <div class="space-y-2 pt-2">
                                <template x-for="(lang, index) in languages" :key="index">
                                    <div class="flex justify-between items-center bg-gray-50 dark:bg-dark-850 px-4 py-2 rounded-xl border border-gray-150 dark:border-gray-800 text-sm">
                                        <span x-text="lang"></span>
                                        <button type="button" @click="removeLanguage(index)" class="text-red-500 hover:text-red-600 font-bold text-xs">Remove</button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 7. Certifications Editor -->
                        <div x-show="activeTab === 'certifications'" class="space-y-4" x-transition>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Certifications</h3>
                                <button @click="addCertification()" class="px-2.5 py-1 bg-primary-500 text-white rounded text-xs cursor-pointer hover:bg-primary-600 font-semibold">+ Add</button>
                            </div>
                            <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(cert, index) in certifications" :key="index">
                                    <div class="p-4 rounded-xl border border-gray-150 dark:border-gray-700 space-y-3 relative bg-gray-50/50 dark:bg-dark-850">
                                        <button @click="removeCertification(index)" class="absolute right-3 top-3 text-red-500 hover:text-red-600 text-xs font-bold">Remove</button>
                                        
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Certification Name</label>
                                                <input type="text" x-model="cert.name" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Issuing Organization</label>
                                                <input type="text" x-model="cert.organization" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Issue Date</label>
                                                <input type="month" x-model="cert.issue_date" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Credential URL</label>
                                                <input type="url" x-model="cert.credential_url" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 8. References Editor -->
                        <div x-show="activeTab === 'references'" class="space-y-4" x-transition>
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">References</h3>
                                <button @click="addReference()" class="px-2.5 py-1 bg-primary-500 text-white rounded text-xs cursor-pointer hover:bg-primary-600 font-semibold">+ Add</button>
                            </div>
                            <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                                <template x-for="(ref, index) in references" :key="index">
                                    <div class="p-4 rounded-xl border border-gray-150 dark:border-gray-700 space-y-3 relative bg-gray-50/50 dark:bg-dark-850">
                                        <button @click="removeReference(index)" class="absolute right-3 top-3 text-red-500 hover:text-red-600 text-xs font-bold">Remove</button>
                                        
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Name</label>
                                                <input type="text" x-model="ref.name" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Designation / Org</label>
                                                <input type="text" x-model="ref.title" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-500">Contact Email / Phone</label>
                                                <input type="text" x-model="ref.contact" class="w-full mt-0.5 px-2.5 py-1.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom panel controls -->
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-500">Style:</span>
                            <select x-model="template" class="px-2 py-1.5 rounded-lg border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs font-semibold focus:outline-none">
                                <option value="classic">Classic Serif</option>
                                <option value="modern">Modern Professional</option>
                                <option value="creative">Creative Minimalist</option>
                            </select>
                        </div>
                        
                        <button type="button" @click="printResume()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer">
                            Print / Download PDF
                        </button>
                    </div>
                </div>

                <!-- Right Pane: Real-time preview canvas -->
                <div class="w-full lg:w-1/2">
                    <div class="sticky top-20 bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden text-black font-sans leading-relaxed select-text" 
                         id="resume-print-area"
                         :class="{
                            'font-serif': template === 'classic',
                            'font-sans': template !== 'classic'
                         }"
                    >
                        <!-- 1. MODERN PROFESSIONAL TEMPLATE -->
                        <div x-show="template === 'modern'" class="p-8 space-y-6">
                            <!-- Name & Headline -->
                            <div class="border-b-2 border-primary-500 pb-4 flex justify-between items-end">
                                <div>
                                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900" x-text="(personal.firstName + ' ' + personal.lastName).trim() || 'Your Name'"></h1>
                                    <p class="text-sm font-bold text-primary-600 uppercase tracking-wider mt-1" x-text="personal.headline || 'Professional Headline'"></p>
                                </div>
                                <div class="text-right text-xs text-gray-500 space-y-0.5">
                                    <p x-text="personal.email"></p>
                                    <p x-text="personal.phone"></p>
                                    <p x-text="personal.location"></p>
                                    <p x-text="personal.website" class="text-primary-600 font-semibold"></p>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div x-show="personal.summary" class="space-y-2">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-1">Professional Summary</h4>
                                <p class="text-xs text-gray-600 leading-relaxed" x-text="personal.summary"></p>
                            </div>

                            <!-- Experience -->
                            <div x-show="experiences.length > 0" class="space-y-3">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-1">Work History</h4>
                                <div class="space-y-4">
                                    <template x-for="exp in experiences">
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-baseline">
                                                <h5 class="text-xs font-bold text-gray-800" x-text="exp.designation + ' - ' + exp.company"></h5>
                                                <span class="text-[10px] text-gray-500 font-semibold" x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></span>
                                            </div>
                                            <p class="text-xs text-gray-600 whitespace-pre-line" x-text="exp.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Education -->
                            <div x-show="education.length > 0" class="space-y-3">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-1">Education</h4>
                                <div class="space-y-3">
                                    <template x-for="edu in education">
                                        <div class="flex justify-between items-baseline">
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-800" x-text="edu.degree + ' (' + edu.field_of_study + ')'"></h5>
                                                <p class="text-[10px] text-gray-500" x-text="edu.institution"></p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-[10px] text-gray-500 font-semibold" x-text="edu.start_date + ' — ' + edu.end_date"></span>
                                                <p class="text-[10px] text-gray-600 font-bold" x-show="edu.grade" x-text="'Grade: ' + edu.grade"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Skills Grid -->
                            <div x-show="skills.length > 0" class="space-y-2">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-1">Key Skills</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="skill in skills">
                                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-800 border border-gray-200" x-text="skill"></span>
                                    </template>
                                </div>
                            </div>

                            <!-- Projects -->
                            <div x-show="projects.length > 0" class="space-y-3">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-100 pb-1">Projects</h4>
                                <div class="space-y-3">
                                    <template x-for="proj in projects">
                                        <div>
                                            <div class="flex justify-between items-baseline">
                                                <h5 class="text-xs font-bold text-gray-800" x-text="proj.project_name"></h5>
                                                <span class="text-[10px] text-primary-600 font-bold" x-text="proj.url"></span>
                                            </div>
                                            <p class="text-[10px] text-gray-500 font-semibold italic" x-show="proj.technologies" x-text="'Technologies: ' + proj.technologies"></p>
                                            <p class="text-xs text-gray-600 mt-0.5" x-text="proj.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>

                        <!-- 2. CLASSIC SERIF TEMPLATE -->
                        <div x-show="template === 'classic'" class="p-8 space-y-5 text-center">
                            <div>
                                <h1 class="text-3xl font-extrabold tracking-wide uppercase text-gray-900" x-text="(personal.firstName + ' ' + personal.lastName).trim() || 'Your Name'"></h1>
                                <p class="text-xs font-semibold text-gray-500 italic mt-1" x-text="personal.headline || 'Professional Headline'"></p>
                                <div class="mt-2 flex justify-center flex-wrap gap-x-4 gap-y-1 text-xs text-gray-600 font-medium">
                                    <span x-text="personal.email"></span>
                                    <span>&bull;</span>
                                    <span x-text="personal.phone"></span>
                                    <span>&bull;</span>
                                    <span x-text="personal.location"></span>
                                </div>
                            </div>

                            <hr class="border-t border-gray-800 double h-0.5 my-2">

                            <!-- Summary -->
                            <div x-show="personal.summary" class="text-left space-y-1">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider text-center">Professional Summary</h4>
                                <p class="text-xs text-gray-650 leading-relaxed text-justify" x-text="personal.summary"></p>
                            </div>

                            <!-- Experience -->
                            <div x-show="experiences.length > 0" class="text-left space-y-2">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider text-center">Experience</h4>
                                <div class="space-y-3">
                                    <template x-for="exp in experiences">
                                        <div>
                                            <div class="flex justify-between items-baseline text-xs font-bold">
                                                <span x-text="exp.designation + ', ' + exp.company"></span>
                                                <span class="font-normal italic" x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></span>
                                            </div>
                                            <p class="text-xs text-gray-650 mt-1" x-text="exp.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Education -->
                            <div x-show="education.length > 0" class="text-left space-y-2">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider text-center">Education</h4>
                                <div class="space-y-3">
                                    <template x-for="edu in education">
                                        <div class="flex justify-between items-baseline text-xs font-bold">
                                            <div>
                                                <span x-text="edu.degree + ' ' + edu.field_of_study"></span>
                                                <p class="text-[10px] text-gray-500 font-semibold" x-text="edu.institution"></p>
                                            </div>
                                            <span class="font-normal italic" x-text="edu.start_date + ' — ' + edu.end_date"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- 3. CREATIVE MINIMALIST TEMPLATE -->
                        <div x-show="template === 'creative'" class="flex min-h-[500px]">
                            <!-- Left Sidebar block -->
                            <div class="w-1/3 bg-gray-50 border-r border-gray-150 p-6 space-y-6 text-xs text-gray-700">
                                <div>
                                    <h1 class="text-xl font-black text-gray-900 leading-none" x-text="personal.firstName || 'First'"></h1>
                                    <h1 class="text-xl font-black text-primary-500 leading-none" x-text="personal.lastName || 'Last'"></h1>
                                    <p class="text-[9px] font-bold text-gray-400 mt-2" x-text="personal.headline"></p>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="font-black text-gray-950 uppercase text-[10px] tracking-wider">Contact</h4>
                                    <p class="break-all" x-text="personal.email"></p>
                                    <p x-text="personal.phone"></p>
                                    <p x-text="personal.location"></p>
                                </div>

                                <div x-show="skills.length > 0" class="space-y-3">
                                    <h4 class="font-black text-gray-950 uppercase text-[10px] tracking-wider">Skills</h4>
                                    <div class="flex flex-wrap gap-1">
                                        <template x-for="skill in skills">
                                            <span class="bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full text-[9px] font-bold" x-text="skill"></span>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="languages.length > 0" class="space-y-3">
                                    <h4 class="font-black text-gray-950 uppercase text-[10px] tracking-wider">Languages</h4>
                                    <div class="space-y-1">
                                        <template x-for="lang in languages">
                                            <p x-text="lang"></p>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content block -->
                            <div class="w-2/3 p-6 space-y-5">
                                <div x-show="personal.summary" class="space-y-2">
                                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-1">Profile</h4>
                                    <p class="text-xs text-gray-600" x-text="personal.summary"></p>
                                </div>

                                <div x-show="experiences.length > 0" class="space-y-3">
                                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-1">Experience</h4>
                                    <div class="space-y-3">
                                        <template x-for="exp in experiences">
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-950" x-text="exp.designation + ' at ' + exp.company"></h5>
                                                <p class="text-[9px] text-gray-400 font-semibold mb-1" x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></p>
                                                <p class="text-[11px] text-gray-600" x-text="exp.description"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="education.length > 0" class="space-y-3">
                                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-1">Education</h4>
                                    <div class="space-y-3">
                                        <template x-for="edu in education">
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-950" x-text="edu.degree"></h5>
                                                <p class="text-[9px] text-gray-400 font-semibold" x-text="edu.institution + ' &bull; ' + edu.start_date + ' — ' + edu.end_date"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
