<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Resume Builder') }}
            </h2>
            <p>Create, customize, and print your professional resume</p>
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

    <div
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
        <div>
            <div>
                
                <!-- Left Pane: Editor Control Form -->
                <div>
                    <div>
                        <!-- Section Navigation Tabs -->
                        <div>
                            <template x-for="tab in ['personal', 'experience', 'education', 'skills', 'projects', 'languages', 'certifications', 'references']">
                                <button 
                                    @click="activeTab = tab"
                                    :
                                    x-text="tab"
                                >
                                </button>
                            </template>
                        </div>

                        <!-- 1. Personal Info Editor -->
                        <div x-show="activeTab === 'personal'" x-transition>
                            <h3>Personal Information</h3>
                            <div>
                                <div>
                                    <label>First Name</label>
                                    <input type="text" x-model="personal.firstName">
                                </div>
                                <div>
                                    <label>Last Name</label>
                                    <input type="text" x-model="personal.lastName">
                                </div>
                            </div>
                            <div>
                                <label>Professional Headline</label>
                                <input type="text" x-model="personal.headline" placeholder="e.g. Senior Software Engineer">
                            </div>
                            <div>
                                <div>
                                    <label>Email</label>
                                    <input type="email" x-model="personal.email">
                                </div>
                                <div>
                                    <label>Phone</label>
                                    <input type="text" x-model="personal.phone">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label>Location</label>
                                    <input type="text" x-model="personal.location" placeholder="City, Province">
                                </div>
                                <div>
                                    <label>Website / Portfolio</label>
                                    <input type="text" x-model="personal.website">
                                </div>
                            </div>
                            <div>
                                <label>Professional Summary</label>
                                <textarea rows="4" x-model="personal.summary" placeholder="Brief statement about your career goals, accomplishments..."></textarea>
                            </div>
                        </div>

                        <!-- 2. Professional Experience Editor -->
                        <div x-show="activeTab === 'experience'" x-transition>
                            <div>
                                <h3>Work Experience</h3>
                                <button @click="addExperience()">+ Add</button>
                            </div>
                            <div>
                                <template x-for="(exp, index) in experiences" :key="index">
                                    <div>
                                        <button @click="removeExperience(index)">Remove</button>
                                        
                                        <div>
                                            <div>
                                                <label>Company Name</label>
                                                <input type="text" x-model="exp.company">
                                            </div>
                                            <div>
                                                <label>Role / Title</label>
                                                <input type="text" x-model="exp.designation">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div>
                                                <label>Start Date</label>
                                                <input type="month" x-model="exp.start_date">
                                            </div>
                                            <div x-show="!exp.currently_working">
                                                <label>End Date</label>
                                                <input type="month" x-model="exp.end_date">
                                            </div>
                                            <div>
                                                <label>
                                                    <input type="checkbox" x-model="exp.currently_working">
                                                    Current
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <label>Description</label>
                                            <textarea rows="3" x-model="exp.description"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 3. Education Editor -->
                        <div x-show="activeTab === 'education'" x-transition>
                            <div>
                                <h3>Education History</h3>
                                <button @click="addEducation()">+ Add</button>
                            </div>
                            <div>
                                <template x-for="(edu, index) in education" :key="index">
                                    <div>
                                        <button @click="removeEducation(index)">Remove</button>
                                        
                                        <div>
                                            <div>
                                                <label>Institution</label>
                                                <input type="text" x-model="edu.institution">
                                            </div>
                                            <div>
                                                <label>Degree & Field</label>
                                                <input type="text" x-model="edu.degree" placeholder="e.g. B.Sc. Computer Science">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div>
                                                <label>Start Date</label>
                                                <input type="month" x-model="edu.start_date">
                                            </div>
                                            <div>
                                                <label>End Date</label>
                                                <input type="month" x-model="edu.end_date">
                                            </div>
                                            <div>
                                                <label>Grade / GPA (Optional)</label>
                                                <input type="text" x-model="edu.grade">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 4. Skills Editor -->
                        <div x-show="activeTab === 'skills'" x-transition>
                            <h3>Core Skills</h3>
                            
                            <div>
                                <input type="text" x-model="newSkill" @keydown.enter.prevent="addSkill()" placeholder="e.g. TailwindCSS">
                                <button type="button" @click="addSkill()">Add</button>
                            </div>

                            <div>
                                <template x-for="(skill, index) in skills" :key="index">
                                    <span>
                                        <span x-text="skill"></span>
                                        <button type="button" @click="removeSkill(index)">×</button>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- 5. Projects Editor -->
                        <div x-show="activeTab === 'projects'" x-transition>
                            <div>
                                <h3>Key Projects</h3>
                                <button @click="addProject()">+ Add</button>
                            </div>
                            <div>
                                <template x-for="(proj, index) in projects" :key="index">
                                    <div>
                                        <button @click="removeProject(index)">Remove</button>
                                        
                                        <div>
                                            <div>
                                                <label>Project Title</label>
                                                <input type="text" x-model="proj.project_name">
                                            </div>
                                            <div>
                                                <label>URL / Link</label>
                                                <input type="url" x-model="proj.url">
                                            </div>
                                        </div>

                                        <div>
                                            <label>Technologies Used</label>
                                            <input type="text" x-model="proj.technologies" placeholder="e.g. React, Node, SQL">
                                        </div>

                                        <div>
                                            <label>Description</label>
                                            <textarea rows="2.5" x-model="proj.description"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 6. Languages Editor -->
                        <div x-show="activeTab === 'languages'" x-transition>
                            <h3>Languages</h3>
                            
                            <div>
                                <input type="text" x-model="newLanguage" @keydown.enter.prevent="addLanguage()" placeholder="e.g. English (Native)">
                                <button type="button" @click="addLanguage()">Add</button>
                            </div>

                            <div>
                                <template x-for="(lang, index) in languages" :key="index">
                                    <div>
                                        <span x-text="lang"></span>
                                        <button type="button" @click="removeLanguage(index)">Remove</button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 7. Certifications Editor -->
                        <div x-show="activeTab === 'certifications'" x-transition>
                            <div>
                                <h3>Certifications</h3>
                                <button @click="addCertification()">+ Add</button>
                            </div>
                            <div>
                                <template x-for="(cert, index) in certifications" :key="index">
                                    <div>
                                        <button @click="removeCertification(index)">Remove</button>
                                        
                                        <div>
                                            <div>
                                                <label>Certification Name</label>
                                                <input type="text" x-model="cert.name">
                                            </div>
                                            <div>
                                                <label>Issuing Organization</label>
                                                <input type="text" x-model="cert.organization">
                                            </div>
                                        </div>

                                        <div>
                                            <div>
                                                <label>Issue Date</label>
                                                <input type="month" x-model="cert.issue_date">
                                            </div>
                                            <div>
                                                <label>Credential URL</label>
                                                <input type="url" x-model="cert.credential_url">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 8. References Editor -->
                        <div x-show="activeTab === 'references'" x-transition>
                            <div>
                                <h3>References</h3>
                                <button @click="addReference()">+ Add</button>
                            </div>
                            <div>
                                <template x-for="(ref, index) in references" :key="index">
                                    <div>
                                        <button @click="removeReference(index)">Remove</button>
                                        
                                        <div>
                                            <div>
                                                <label>Name</label>
                                                <input type="text" x-model="ref.name">
                                            </div>
                                            <div>
                                                <label>Designation / Org</label>
                                                <input type="text" x-model="ref.title">
                                            </div>
                                            <div>
                                                <label>Contact Email / Phone</label>
                                                <input type="text" x-model="ref.contact">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom panel controls -->
                    <div>
                        <div>
                            <span>Style:</span>
                            <select x-model="template">
                                <option value="classic">Classic Serif</option>
                                <option value="modern">Modern Professional</option>
                                <option value="creative">Creative Minimalist</option>
                            </select>
                        </div>
                        
                        <button type="button" @click="printResume()">
                            Print / Download PDF
                        </button>
                    </div>
                </div>

                <!-- Right Pane: Real-time preview canvas -->
                <div>
                    <div 
                         id="resume-print-area"
                         :
                    >
                        <!-- 1. MODERN PROFESSIONAL TEMPLATE -->
                        <div x-show="template === 'modern'">
                            <!-- Name & Headline -->
                            <div>
                                <div>
                                    <h1 x-text="(personal.firstName + ' ' + personal.lastName).trim() || 'Your Name'"></h1>
                                    <p x-text="personal.headline || 'Professional Headline'"></p>
                                </div>
                                <div>
                                    <p x-text="personal.email"></p>
                                    <p x-text="personal.phone"></p>
                                    <p x-text="personal.location"></p>
                                    <p x-text="personal.website"></p>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div x-show="personal.summary">
                                <h4>Professional Summary</h4>
                                <p x-text="personal.summary"></p>
                            </div>

                            <!-- Experience -->
                            <div x-show="experiences.length > 0">
                                <h4>Work History</h4>
                                <div>
                                    <template x-for="exp in experiences">
                                        <div>
                                            <div>
                                                <h5 x-text="exp.designation + ' - ' + exp.company"></h5>
                                                <span x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></span>
                                            </div>
                                            <p x-text="exp.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Education -->
                            <div x-show="education.length > 0">
                                <h4>Education</h4>
                                <div>
                                    <template x-for="edu in education">
                                        <div>
                                            <div>
                                                <h5 x-text="edu.degree + ' (' + edu.field_of_study + ')'"></h5>
                                                <p x-text="edu.institution"></p>
                                            </div>
                                            <div>
                                                <span x-text="edu.start_date + ' — ' + edu.end_date"></span>
                                                <p x-show="edu.grade" x-text="'Grade: ' + edu.grade"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Skills Grid -->
                            <div x-show="skills.length > 0">
                                <h4>Key Skills</h4>
                                <div>
                                    <template x-for="skill in skills">
                                        <span x-text="skill"></span>
                                    </template>
                                </div>
                            </div>

                            <!-- Projects -->
                            <div x-show="projects.length > 0">
                                <h4>Projects</h4>
                                <div>
                                    <template x-for="proj in projects">
                                        <div>
                                            <div>
                                                <h5 x-text="proj.project_name"></h5>
                                                <span x-text="proj.url"></span>
                                            </div>
                                            <p x-show="proj.technologies" x-text="'Technologies: ' + proj.technologies"></p>
                                            <p x-text="proj.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>

                        <!-- 2. CLASSIC SERIF TEMPLATE -->
                        <div x-show="template === 'classic'">
                            <div>
                                <h1 x-text="(personal.firstName + ' ' + personal.lastName).trim() || 'Your Name'"></h1>
                                <p x-text="personal.headline || 'Professional Headline'"></p>
                                <div>
                                    <span x-text="personal.email"></span>
                                    <span>&bull;</span>
                                    <span x-text="personal.phone"></span>
                                    <span>&bull;</span>
                                    <span x-text="personal.location"></span>
                                </div>
                            </div>

                            <hr>

                            <!-- Summary -->
                            <div x-show="personal.summary">
                                <h4>Professional Summary</h4>
                                <p x-text="personal.summary"></p>
                            </div>

                            <!-- Experience -->
                            <div x-show="experiences.length > 0">
                                <h4>Experience</h4>
                                <div>
                                    <template x-for="exp in experiences">
                                        <div>
                                            <div>
                                                <span x-text="exp.designation + ', ' + exp.company"></span>
                                                <span x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></span>
                                            </div>
                                            <p x-text="exp.description"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Education -->
                            <div x-show="education.length > 0">
                                <h4>Education</h4>
                                <div>
                                    <template x-for="edu in education">
                                        <div>
                                            <div>
                                                <span x-text="edu.degree + ' ' + edu.field_of_study"></span>
                                                <p x-text="edu.institution"></p>
                                            </div>
                                            <span x-text="edu.start_date + ' — ' + edu.end_date"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- 3. CREATIVE MINIMALIST TEMPLATE -->
                        <div x-show="template === 'creative'">
                            <!-- Left Sidebar block -->
                            <div>
                                <div>
                                    <h1 x-text="personal.firstName || 'First'"></h1>
                                    <h1 x-text="personal.lastName || 'Last'"></h1>
                                    <p x-text="personal.headline"></p>
                                </div>

                                <div>
                                    <h4>Contact</h4>
                                    <p x-text="personal.email"></p>
                                    <p x-text="personal.phone"></p>
                                    <p x-text="personal.location"></p>
                                </div>

                                <div x-show="skills.length > 0">
                                    <h4>Skills</h4>
                                    <div>
                                        <template x-for="skill in skills">
                                            <span x-text="skill"></span>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="languages.length > 0">
                                    <h4>Languages</h4>
                                    <div>
                                        <template x-for="lang in languages">
                                            <p x-text="lang"></p>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content block -->
                            <div>
                                <div x-show="personal.summary">
                                    <h4>Profile</h4>
                                    <p x-text="personal.summary"></p>
                                </div>

                                <div x-show="experiences.length > 0">
                                    <h4>Experience</h4>
                                    <div>
                                        <template x-for="exp in experiences">
                                            <div>
                                                <h5 x-text="exp.designation + ' at ' + exp.company"></h5>
                                                <p x-text="exp.start_date + ' — ' + (exp.currently_working ? 'Present' : exp.end_date)"></p>
                                                <p x-text="exp.description"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div x-show="education.length > 0">
                                    <h4>Education</h4>
                                    <div>
                                        <template x-for="edu in education">
                                            <div>
                                                <h5 x-text="edu.degree"></h5>
                                                <p x-text="edu.institution + ' &bull; ' + edu.start_date + ' — ' + edu.end_date"></p>
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
