<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Apply for Position') }}
            </h2>
            <span>
                💼 Job: {{ $job->title }}
            </span>
        </div>
    </x-slot>

    <div 
         x-data="{ 
            step: 1,
            isDragging: false,
            isUploading: false,
            uploadProgress: 0,
            uploadedFileName: '',
            resumeOption: 'library',
            isSubmitting: false,
            coverLetterText: '',
            
            triggerDrop(e) {
                this.isDragging = false;
                const file = e.dataTransfer.files[0];
                if (file) {
                    this.handleFile(file);
                }
            },
            triggerSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    this.handleFile(file);
                }
            },
            handleFile(file) {
                this.uploadedFileName = file.name;
                this.isUploading = true;
                this.uploadProgress = 0;
                const interval = setInterval(() => {
                    if (this.uploadProgress < 100) {
                        this.uploadProgress += 25;
                    } else {
                        clearInterval(interval);
                        this.isUploading = false;
                    }
                }, 100);
            },
            submitApp(e) {
                this.isSubmitting = true;
                setTimeout(() => {
                    e.target.submit();
                }, 1500);
            }
         }"
    >
        <div>
            
            <!-- Progress Stepper Header -->
            <x-card variant="default">
                <div>
                    <!-- Background Connector Line -->
                    <div></div>
                    <!-- Dynamic Progress Line -->
                    <div 
                         :></div>

                    <!-- Step 1 -->
                    <div>
                        <div
                             :>1</div>
                        <span>Resume</span>
                    </div>
                    <!-- Step 2 -->
                    <div>
                        <div
                             :>2</div>
                        <span>Cover Letter</span>
                    </div>
                    <!-- Step 3 -->
                    <div>
                        <div
                             :>3</div>
                        <span>Screening</span>
                    </div>
                    <!-- Step 4 -->
                    <div>
                        <div
                             :>4</div>
                        <span>Review</span>
                    </div>
                </div>
            </x-card>

            <!-- Loader Skeletons (Shows when processing submission) -->
            <div x-show="isSubmitting" x-transition>
                <div>
                    <span></span>
                </div>
                <h3>Submitting your application...</h3>
                <p>Recruiter is being notified. Please wait.</p>
            </div>

            <!-- Application Form -->
            <div x-show="!isSubmitting">
                
                @if ($errors->any())
                    <x-alert type="danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>&bull; {{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('jobs.apply.submit', $job->slug) }}" enctype="multipart/form-data" @submit.prevent="submitApp($event)">
                    @csrf

                    <!-- STEP 1: RESUME SELECTION -->
                    <div x-show="step === 1" x-transition>
                        <h3>Step 1: Select Your Resume</h3>
                        
                        <div>
                            <div>
                                <label>
                                    <input type="radio" name="resume_option" value="library" x-model="resumeOption" checked />
                                    Choose from Library
                                </label>
                                <label>
                                    <input type="radio" name="resume_option" value="new" x-model="resumeOption" />
                                    Upload New Resume
                                </label>
                            </div>

                            <!-- Option A: Library Select -->
                            <div x-show="resumeOption === 'library'" x-transition>
                                <x-input-label for="resume_id" :value="__('Select a Saved Resume')" />
                                @forelse($resumes as $res)
                                    <label>
                                        <div>
                                            <input type="radio" name="resume_id" value="{{ $res->id }}" @checked($res->is_default) />
                                            <div>
                                                <p>{{ $res->title }}</p>
                                                <p>Uploaded on {{ $res->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if($res->is_default)
                                            <span>Default</span>
                                        @endif
                                    </label>
                                @empty
                                    <p>No resumes saved in library. Please select "Upload New Resume" option above.</p>
                                @endforelse
                            </div>

                            <!-- Option B: Upload new with Drag & Drop -->
                            <div x-show="resumeOption === 'new'" x-transition>
                                <div>
                                    <x-input-label for="resume_title" :value="__('Resume Title')" />
                                    <x-text-input id="resume_title" name="resume_title" type="text" placeholder="e.g. My General Resume, Dev Resume" />
                                </div>
                                
                                <!-- Drag zone -->
                                <div>
                                    <span>File Attachment (PDF, DOC, DOCX up to 5MB)</span>
                                    <div @dragover.prevent="isDragging = true" 
                                         @dragleave.prevent="isDragging = false"
                                         @drop.prevent="triggerDrop($event)"
                                         :>
                                        
                                        <input type="file" name="resume_file" id="resume_file" @change="triggerSelect($event)" />
                                        
                                        <div>
                                            <div>📤</div>
                                            <p>Drag and drop your file here, or click to browse</p>
                                            <p>PDF, DOC, or DOCX formats accepted.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Progress bar -->
                                <div x-show="isUploading">
                                    <div>
                                        <span x-text="uploadedFileName"></span>
                                        <span x-text="uploadProgress + '%'"></span>
                                    </div>
                                    <div>
                                        <div :></div>
                                    </div>
                                </div>

                                <div x-show="!isUploading && uploadedFileName">
                                    <span x-text="'✓ Attached: ' + uploadedFileName"></span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="button" @click="step = 2">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: COVER LETTER -->
                    <div x-show="step === 2" x-transition>
                        <h3>Step 2: Cover Letter</h3>
                        
                        <div>
                            <x-input-label for="cover_letter" :value="__('Cover Letter (Optional)')" />
                            <textarea id="cover_letter" name="cover_letter" x-model="coverLetterText" rows="8" placeholder="Write a short pitch or cover letter explaining why you are a great fit..."></textarea>
                        </div>

                        <div>
                            <button type="button" @click="step = 1">
                                Back
                            </button>
                            <button type="button" @click="step = 3">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: SCREENING QUESTIONS -->
                    <div x-show="step === 3" x-transition>
                        <h3>Step 3: Screening Questions</h3>
                        
                        <div>
                            @forelse($job->screeningQuestions as $q)
                                <div>
                                    <label>
                                        {{ $q->question_text }}
                                        @if($q->is_required)
                                            <span>*</span>
                                        @endif
                                    </label>
                                    <x-text-input name="answers[{{ $q->id }}]" type="text" :required="$q->is_required" placeholder="Your answer here..." />
                                </div>
                            @empty
                                <p>No screening questions required for this position.</p>
                            @endforelse
                        </div>

                        <div>
                            <button type="button" @click="step = 2">
                                Back
                            </button>
                            <button type="button" @click="step = 4">
                                Review Application
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: REVIEW & SUBMIT -->
                    <div x-show="step === 4" x-transition>
                        <h3>Step 4: Review Your Details</h3>
                        
                        <div>
                            <div>
                                <h4>Applying For Position</h4>
                                <p>{{ $job->title }} at {{ $job->company->company_name }}</p>
                            </div>
                            <div>
                                <h4>Resume Status</h4>
                                <p x-text="resumeOption === 'library' ? 'Using resume from profile library' : 'Using newly uploaded resume: ' + uploadedFileName"></p>
                            </div>
                            <div>
                                <h4>Terms of Submission</h4>
                                <p>By clicking &quot;Submit&quot;, you certify that your resume and details are accurate. The employer will be notified immediately.</p>
                            </div>
                        </div>

                        <div>
                            <button type="button" @click="step = 3">
                                Back
                            </button>
                            <button type="submit">
                                Submit Application
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
