<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Apply for ') }} {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ step: 1 }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Stepper Header -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 mb-8">
                <div class="flex items-center justify-between relative">
                    <!-- Background Connector Line -->
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-700 -translate-y-1/2 z-0"></div>
                    <!-- Dynamic Progress Line -->
                    <div class="absolute top-1/2 left-0 h-0.5 bg-indigo-600 transition-all duration-300 -translate-y-1/2 z-0" 
                         :style="'width: ' + ((step - 1) * 33.33) + '%'"></div>

                    <!-- Step 1 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300"
                             :class="step >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600'">1</div>
                        <span class="text-3xs font-semibold mt-1 uppercase text-gray-400">Resume</span>
                    </div>
                    <!-- Step 2 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300"
                             :class="step >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600'">2</div>
                        <span class="text-3xs font-semibold mt-1 uppercase text-gray-400">Cover Letter</span>
                    </div>
                    <!-- Step 3 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300"
                             :class="step >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600'">3</div>
                        <span class="text-3xs font-semibold mt-1 uppercase text-gray-400">Screening</span>
                    </div>
                    <!-- Step 4 -->
                    <div class="z-10 text-center flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300"
                             :class="step >= 4 ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600'">4</div>
                        <span class="text-3xs font-semibold mt-1 uppercase text-gray-400">Review</span>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-8">
                
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-950/20 border border-red-500/35 text-red-750 dark:text-red-400 p-4 rounded-xl shadow-sm text-sm mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>&bull; {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('jobs.apply.submit', $job->slug) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- STEP 1: RESUME SELECTION -->
                    <div x-show="step === 1" class="space-y-6">
                        <h3 class="font-extrabold text-lg text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Step 1: Select Your Resume</h3>
                        
                        <div x-data="{ resumeOption: 'library' }" class="space-y-4">
                            <div class="flex items-center gap-6">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer font-semibold">
                                    <input type="radio" name="resume_option" value="library" x-model="resumeOption" checked class="text-indigo-600" />
                                    Choose from Library
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer font-semibold">
                                    <input type="radio" name="resume_option" value="new" x-model="resumeOption" class="text-indigo-600" />
                                    Upload New Resume
                                </label>
                            </div>

                            <!-- Option A: Library Select -->
                            <div x-show="resumeOption === 'library'" class="space-y-3 pt-2">
                                <x-input-label for="resume_id" :value="__('Select a Saved Resume')" />
                                @forelse($resumes as $res)
                                    <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 transition">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="resume_id" value="{{ $res->id }}" @checked($res->is_default) class="text-indigo-600" />
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $res->title }}</p>
                                                <p class="text-xs text-gray-500">Uploaded on {{ $res->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if($res->is_default)
                                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-800 text-3xs font-extrabold rounded-full">Default</span>
                                        @endif
                                    </label>
                                @empty
                                    <p class="text-xs text-gray-500">No resumes saved in library. Please select "Upload New Resume" option above.</p>
                                @endforelse
                            </div>

                            <!-- Option B: Upload new -->
                            <div x-show="resumeOption === 'new'" class="space-y-4 pt-2">
                                <div>
                                    <x-input-label for="resume_title" :value="__('Resume Title')" />
                                    <x-text-input id="resume_title" name="resume_title" type="text" class="mt-1 block w-full" placeholder="e.g. My General Resume, Dev Resume" />
                                </div>
                                <div>
                                    <x-input-label for="resume_file" :value="__('Upload File (PDF, DOC, DOCX up to 5MB)')" />
                                    <input id="resume_file" name="resume_file" type="file" class="mt-1 block w-full text-xs text-gray-500 border border-gray-300 dark:border-gray-700 dark:bg-gray-950 rounded-xl p-2.5" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end">
                            <button type="button" @click="step = 2" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-750 text-white font-bold rounded-xl text-sm transition">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: COVER LETTER -->
                    <div x-show="step === 2" class="space-y-6">
                        <h3 class="font-extrabold text-lg text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Step 2: Cover Letter</h3>
                        
                        <div>
                            <x-input-label for="cover_letter" :value="__('Cover Letter (Optional)')" />
                            <textarea id="cover_letter" name="cover_letter" rows="8" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-sm shadow-sm" placeholder="Write a short pitch or cover letter explaining why you are a great fit..."></textarea>
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 1" class="px-5 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm transition">
                                Back
                            </button>
                            <button type="button" @click="step = 3" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-750 text-white font-bold rounded-xl text-sm transition">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: SCREENING QUESTIONS -->
                    <div x-show="step === 3" class="space-y-6">
                        <h3 class="font-extrabold text-lg text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Step 3: Screening Questions</h3>
                        
                        <div class="space-y-4">
                            @forelse($job->screeningQuestions as $q)
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                        {{ $q->question_text }}
                                        @if($q->is_required)
                                            <span class="text-red-500 font-bold">*</span>
                                        @endif
                                    </label>
                                    <x-text-input name="answers[{{ $q->id }}]" type="text" class="mt-1 block w-full" :required="$q->is_required" placeholder="Your answer here..." />
                                </div>
                            @empty
                                <p class="text-xs text-gray-500">No screening questions required for this position.</p>
                            @endforelse
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 2" class="px-5 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm transition">
                                Back
                            </button>
                            <button type="button" @click="step = 4" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-750 text-white font-bold rounded-xl text-sm transition">
                                Review Application
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: REVIEW & SUBMIT -->
                    <div x-show="step === 4" class="space-y-6">
                        <h3 class="font-extrabold text-lg text-gray-950 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Step 4: Review Your Details</h3>
                        
                        <div class="space-y-4 text-sm text-gray-650 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-900 p-6 rounded-xl border border-gray-100 dark:border-gray-800">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Applying For Position</h4>
                                <p class="text-xs">{{ $job->title }} at {{ $job->company->company_name }}</p>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-800 pt-3">
                                <h4 class="font-bold text-gray-900 dark:text-white">Profile Readiness</h4>
                                <p class="text-xs text-emerald-500 font-bold">Verified seeker profile complete</p>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-800 pt-3">
                                <h4 class="font-bold text-gray-900 dark:text-white">Terms of Submission</h4>
                                <p class="text-xs">By clicking "Submit", you certify that your resume and details are accurate. The employer will be notified immediately.</p>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-between">
                            <button type="button" @click="step = 3" class="px-5 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm transition">
                                Back
                            </button>
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl transition shadow-md">
                                Submit Application
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
