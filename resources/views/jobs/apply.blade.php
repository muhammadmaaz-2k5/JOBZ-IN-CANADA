<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4 no-print">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Apply for Position') }}
            </h2>
            <span class="status-badge status-active text-[10px]">
                💼 Job: {{ $job->title }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-dark-900 min-h-screen" 
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Stepper Header -->
            <x-card variant="default" class="p-6 mb-8 no-print">
                <div class="flex items-center justify-between relative">
                    <!-- Background Connector Line -->
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-800 -translate-y-1/2 z-0"></div>
                    <!-- Dynamic Progress Line -->
                    <div class="absolute top-1/2 left-0 h-0.5 bg-primary-500 transition-all duration-300 -translate-y-1/2 z-0" 
                         :style="'width: ' + ((step - 1) * 33.33) + '%'"></div>

                    <!-- Step 1 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300 shadow-sm"
                             :class="step >= 1 ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-400'">1</div>
                        <span class="text-[9px] font-bold mt-1.5 uppercase tracking-wider text-gray-400">Resume</span>
                    </div>
                    <!-- Step 2 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300 shadow-sm"
                             :class="step >= 2 ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-400'">2</div>
                        <span class="text-[9px] font-bold mt-1.5 uppercase tracking-wider text-gray-400">Cover Letter</span>
                    </div>
                    <!-- Step 3 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300 shadow-sm"
                             :class="step >= 3 ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-400'">3</div>
                        <span class="text-[9px] font-bold mt-1.5 uppercase tracking-wider text-gray-400">Screening</span>
                    </div>
                    <!-- Step 4 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300 shadow-sm"
                             :class="step >= 4 ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-800 text-gray-400'">4</div>
                        <span class="text-[9px] font-bold mt-1.5 uppercase tracking-wider text-gray-400">Review</span>
                    </div>
                </div>
            </x-card>

            <!-- Loader Skeletons (Shows when processing submission) -->
            <div x-show="isSubmitting" class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-800 p-12 text-center space-y-6" x-transition>
                <div class="flex items-center justify-center">
                    <span class="w-10 h-10 border-4 border-primary-500 border-t-transparent rounded-full animate-spin"></span>
                </div>
                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Submitting your application...</h3>
                <p class="text-xs text-gray-500 dark:text-gray-450">Recruiter is being notified. Please wait.</p>
            </div>

            <!-- Application Form -->
            <div x-show="!isSubmitting" class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-150 dark:border-gray-800 p-8">
                
                @if ($errors->any())
                    <x-alert type="danger" class="mb-6">
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
                    <div x-show="step === 1" class="space-y-6" x-transition>
                        <h3 class="font-extrabold text-base text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Step 1: Select Your Resume</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-6">
                                <label class="inline-flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 cursor-pointer font-bold uppercase tracking-wider">
                                    <input type="radio" name="resume_option" value="library" x-model="resumeOption" checked class="text-primary-500" />
                                    Choose from Library
                                </label>
                                <label class="inline-flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 cursor-pointer font-bold uppercase tracking-wider">
                                    <input type="radio" name="resume_option" value="new" x-model="resumeOption" class="text-primary-500" />
                                    Upload New Resume
                                </label>
                            </div>

                            <!-- Option A: Library Select -->
                            <div x-show="resumeOption === 'library'" class="space-y-3 pt-2" x-transition>
                                <x-input-label for="resume_id" :value="__('Select a Saved Resume')" />
                                @forelse($resumes as $res)
                                    <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/40 border border-gray-150 dark:border-gray-800 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-850/60 transition">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="resume_id" value="{{ $res->id }}" @checked($res->is_default) class="text-primary-500" />
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $res->title }}</p>
                                                <p class="text-xs text-gray-500">Uploaded on {{ $res->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if($res->is_default)
                                            <span class="status-badge status-active text-[9px]">Default</span>
                                        @endif
                                    </label>
                                @empty
                                    <p class="text-xs text-gray-500">No resumes saved in library. Please select "Upload New Resume" option above.</p>
                                @endforelse
                            </div>

                            <!-- Option B: Upload new with Drag & Drop -->
                            <div x-show="resumeOption === 'new'" class="space-y-4 pt-2" x-transition style="display: none;">
                                <div>
                                    <x-input-label for="resume_title" :value="__('Resume Title')" />
                                    <x-text-input id="resume_title" name="resume_title" type="text" class="mt-1 block w-full text-xs font-semibold" placeholder="e.g. My General Resume, Dev Resume" />
                                </div>
                                
                                <!-- Drag zone -->
                                <div class="space-y-2">
                                    <span class="block text-xs font-semibold text-gray-400">File Attachment (PDF, DOC, DOCX up to 5MB)</span>
                                    <div @dragover.prevent="isDragging = true" 
                                         @dragleave.prevent="isDragging = false"
                                         @drop.prevent="triggerDrop($event)"
                                         :class="isDragging ? 'border-primary-500 bg-primary-50/10' : 'border-gray-250 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40'"
                                         class="border-2 border-dashed rounded-2xl p-8 text-center transition cursor-pointer relative">
                                        
                                        <input type="file" name="resume_file" id="resume_file" @change="triggerSelect($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                                        
                                        <div class="space-y-2">
                                            <div class="text-3xl">📤</div>
                                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">Drag and drop your file here, or click to browse</p>
                                            <p class="text-[10px] text-gray-400">PDF, DOC, or DOCX formats accepted.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Progress bar -->
                                <div x-show="isUploading" class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-150 dark:border-gray-850 space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="font-bold truncate" x-text="uploadedFileName"></span>
                                        <span class="font-mono" x-text="uploadProgress + '%'"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-primary-500 h-full transition-all duration-150" :style="'width: ' + uploadProgress + '%'"></div>
                                    </div>
                                </div>

                                <div x-show="!isUploading && uploadedFileName" class="p-3 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-xs rounded-xl flex items-center justify-between">
                                    <span class="font-bold truncate" x-text="'✓ Attached: ' + uploadedFileName"></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end">
                            <button type="button" @click="step = 2" class="btn btn-primary">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: COVER LETTER -->
                    <div x-show="step === 2" class="space-y-6" x-transition style="display: none;">
                        <h3 class="font-extrabold text-base text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Step 2: Cover Letter</h3>
                        
                        <div>
                            <x-input-label for="cover_letter" :value="__('Cover Letter (Optional)')" />
                            <textarea id="cover_letter" name="cover_letter" x-model="coverLetterText" rows="8" class="mt-1 block w-full" placeholder="Write a short pitch or cover letter explaining why you are a great fit..."></textarea>
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 1" class="btn btn-ghost">
                                Back
                            </button>
                            <button type="button" @click="step = 3" class="btn btn-primary">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: SCREENING QUESTIONS -->
                    <div x-show="step === 3" class="space-y-6" x-transition style="display: none;">
                        <h3 class="font-extrabold text-base text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Step 3: Screening Questions</h3>
                        
                        <div class="space-y-4">
                            @forelse($job->screeningQuestions as $q)
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                        {{ $q->question_text }}
                                        @if($q->is_required)
                                            <span class="text-red-500 font-bold">*</span>
                                        @endif
                                    </label>
                                    <x-text-input name="answers[{{ $q->id }}]" type="text" class="mt-1 block w-full text-xs font-semibold" :required="$q->is_required" placeholder="Your answer here..." />
                                </div>
                            @empty
                                <p class="text-xs text-gray-550 dark:text-gray-450 italic">No screening questions required for this position.</p>
                            @endforelse
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 2" class="btn btn-ghost">
                                Back
                            </button>
                            <button type="button" @click="step = 4" class="btn btn-primary">
                                Review Application
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: REVIEW & SUBMIT -->
                    <div x-show="step === 4" class="space-y-6" x-transition style="display: none;">
                        <h3 class="font-extrabold text-base text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">Step 4: Review Your Details</h3>
                        
                        <div class="space-y-4 text-xs text-gray-650 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-150 dark:border-gray-800">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Applying For Position</h4>
                                <p class="text-gray-500 dark:text-gray-400 font-semibold mt-0.5">{{ $job->title }} at {{ $job->company->company_name }}</p>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-850 pt-3">
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Resume Status</h4>
                                <p class="text-gray-500 dark:text-gray-400 font-semibold mt-0.5" x-text="resumeOption === 'library' ? 'Using resume from profile library' : 'Using newly uploaded resume: ' + uploadedFileName"></p>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-850 pt-3">
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Terms of Submission</h4>
                                <p class="text-gray-500 dark:text-gray-400 font-semibold mt-0.5">By clicking &quot;Submit&quot;, you certify that your resume and details are accurate. The employer will be notified immediately.</p>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 3" class="btn btn-ghost">
                                Back
                            </button>
                            <button type="submit" class="btn btn-primary bg-emerald-600 hover:bg-emerald-700">
                                Submit Application
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
