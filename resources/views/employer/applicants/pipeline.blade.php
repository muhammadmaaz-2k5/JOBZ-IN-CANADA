<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ATS Kanban Board') }}
            </h2>
            <a href="{{ route('employer.applicants.index') }}" class="px-4 py-2 bg-indigo-650 text-white font-bold rounded-xl text-xs hover:bg-indigo-750 transition shadow-sm">
                Table List View &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" 
         x-data="{
             columns: {
                 applied: {{ json_encode($columns['applied']->values()) }},
                 pending_review: {{ json_encode($columns['pending_review']->values()) }},
                 shortlisted: {{ json_encode($columns['shortlisted']->values()) }},
                 interview: {{ json_encode($columns['interview']->values()) }},
                 offer: {{ json_encode($columns['offer']->values()) }},
                 hired: {{ json_encode($columns['hired']->values()) }},
                 rejected: {{ json_encode($columns['rejected']->values()) }}
             },
             draggingId: null,
             
             dragStart(event, appId) {
                 this.draggingId = appId;
                 event.dataTransfer.effectAllowed = 'move';
                 event.dataTransfer.setData('text/plain', appId);
             },
             
             dropCard(event, newStatus) {
                 const appId = this.draggingId;
                 if (!appId) return;

                 // Find card and previous status
                 let foundCard = null;
                 let prevColKey = null;

                 for (const colKey in this.columns) {
                     const idx = this.columns[colKey].findIndex(c => c.id == appId);
                     if (idx !== -1) {
                         foundCard = this.columns[colKey][idx];
                         prevColKey = colKey;
                         break;
                     }
                 }

                 if (foundCard && prevColKey !== newStatus) {
                     // Optimistic UI Update: move item
                     const idx = this.columns[prevColKey].findIndex(c => c.id == appId);
                     this.columns[prevColKey].splice(idx, 1);
                     
                     // If status is interview, update model status to interview_scheduled
                     const targetModelStatus = newStatus === 'interview' ? 'interview_scheduled' : newStatus;
                     foundCard.status = targetModelStatus;
                     this.columns[newStatus].push(foundCard);

                     // Make Ajax PUT/POST update
                     fetch('/employer/applicants/' + appId + '/status', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({
                             status: targetModelStatus,
                             remarks: 'Hiring stage changed via Kanban Board.'
                         })
                     })
                     .then(res => res.json())
                     .then(data => {
                         if (!data.success) {
                             // Revert on error
                             alert('Failed to update stage.');
                             window.location.reload();
                         }
                     })
                     .catch(err => {
                         console.error(err);
                         window.location.reload();
                     });
                 }
                 
                 this.draggingId = null;
             }
         }">
        
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Job Picker Selector -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                <div class="max-w-xs">
                    <x-input-label for="job_select" :value="__('Select Job Listing')" />
                    <select id="job_select" name="job_id" onchange="window.location.href=this.value" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-sm rounded-xl">
                        <option value="{{ route('employer.applicants.pipeline.all') }}">All Job Listings</option>
                        @foreach($jobsList as $j)
                            <option value="{{ route('employer.applicants.pipeline.job', $j->id) }}" @selected($jobId == $j->id)>{{ $j->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Kanban Horizontal Scroll Grid Container -->
            <div class="flex gap-4 overflow-x-auto pb-6 select-none items-start">
                
                <!-- Columns Definitions -->
                @foreach([
                    'applied' => ['title' => 'Applied', 'color' => 'bg-blue-500'],
                    'pending_review' => ['title' => 'Pending Review', 'color' => 'bg-yellow-500'],
                    'shortlisted' => ['title' => 'Shortlisted', 'color' => 'bg-indigo-500'],
                    'interview' => ['title' => 'Interview', 'color' => 'bg-purple-500'],
                    'offer' => ['title' => 'Offer', 'color' => 'bg-pink-500'],
                    'hired' => ['title' => 'Hired', 'color' => 'bg-emerald-500'],
                    'rejected' => ['title' => 'Rejected', 'color' => 'bg-red-500']
                ] as $colKey => $colMeta)
                    
                    <div class="w-72 bg-gray-100/60 dark:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex-shrink-0 flex flex-col max-h-[75vh]">
                        <!-- Column Header -->
                        <div class="p-4 border-b border-gray-150 dark:border-gray-800 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $colMeta['color'] }}"></span>
                                <h3 class="font-extrabold text-sm text-gray-900 dark:text-white">{{ $colMeta['title'] }}</h3>
                            </div>
                            <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-800 text-gray-650 dark:text-gray-400 text-3xs font-extrabold rounded-full" 
                                  x-text="columns.{{ $colKey }}.length">0</span>
                        </div>

                        <!-- Column Drop Area / Cards list -->
                        <div class="p-3 flex-grow overflow-y-auto space-y-3 min-h-[400px]" 
                             @dragover.prevent="" 
                             @drop="dropCard($event, '{{ $colKey }}')">
                            
                            <template x-for="app in columns.{{ $colKey }}" :key="app.id">
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700/50 hover:shadow-md cursor-grab active:cursor-grabbing transition" 
                                     draggable="true" 
                                     @dragstart="dragStart($event, app.id)">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center font-extrabold text-xs text-gray-400">
                                            <span x-text="app.applicant.first_name.substring(0,1) + app.applicant.last_name.substring(0,1)"></span>
                                        </div>
                                        <div class="space-y-0.5 flex-grow">
                                            <h4 class="font-extrabold text-xs text-gray-900 dark:text-white" x-text="app.applicant.first_name + ' ' + app.applicant.last_name"></h4>
                                            <p class="text-3xs text-gray-400 truncate" x-text="app.job.title"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 pt-2.5 border-t border-gray-100 dark:border-gray-700/50 flex justify-between items-center text-3xs text-gray-450">
                                        <span x-text="new Date(app.applied_at).toLocaleDateString(undefined, {month: 'short', day: 'numeric'})"></span>
                                        <a :href="'/employer/applicants/' + app.id" class="text-indigo-650 hover:underline font-bold">Review &rarr;</a>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
