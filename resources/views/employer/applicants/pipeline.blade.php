<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('ATS Kanban Board') }}
            </h2>
            <a href="{{ route('employer.applicants.index') }}">
                Table List View &rarr;
            </a>
        </div>
    </x-slot>

    <div 
         x-data="{
             columns: {
                 applied: {{ json_encode($columns['applied']->values()) }},
                 pending_review: {{ json_encode($columns['pending_review']->values()) }},
                 shortlisted: {{ json_encode($columns['shortlisted']->values()) }},
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
                     
                     const targetModelStatus = newStatus;
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
        
        <div>

            <!-- Job Picker Selector -->
            <div>
                <div>
                    <x-input-label for="job_select" :value="__('Select Job Listing')" />
                    <select id="job_select" name="job_id" onchange="window.location.href=this.value">
                        <option value="{{ route('employer.applicants.pipeline.all') }}">All Job Listings</option>
                        @foreach($jobsList as $j)
                            <option value="{{ route('employer.applicants.pipeline.job', $j->id) }}" @selected($jobId == $j->id)>{{ $j->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Kanban Horizontal Scroll Grid Container -->
            <div>
                
                <!-- Columns Definitions -->
                @foreach([
                    'applied' => ['title' => 'Applied', 'color' => 'bg-blue-500'],
                    'pending_review' => ['title' => 'Pending Review', 'color' => 'bg-yellow-500'],
                    'shortlisted' => ['title' => 'Shortlisted', 'color' => 'bg-indigo-500'],
                    'offer' => ['title' => 'Offer', 'color' => 'bg-pink-500'],
                    'hired' => ['title' => 'Hired', 'color' => 'bg-emerald-500'],
                    'rejected' => ['title' => 'Rejected', 'color' => 'bg-red-500']
                ] as $colKey => $colMeta)
                    
                    <div>
                        <!-- Column Header -->
                        <div>
                            <div>
                                <span></span>
                                <h3>{{ $colMeta['title'] }}</h3>
                            </div>
                            <span 
                                  x-text="columns.{{ $colKey }}.length">0</span>
                        </div>

                        <!-- Column Drop Area / Cards list -->
                        <div 
                             @dragover.prevent="" 
                             @drop="dropCard($event, '{{ $colKey }}')">
                            
                            <template x-for="app in columns.{{ $colKey }}" :key="app.id">
                                <div 
                                     draggable="true" 
                                     @dragstart="dragStart($event, app.id)">
                                    <div>
                                        <div>
                                            <span x-text="app.applicant.first_name.substring(0,1) + app.applicant.last_name.substring(0,1)"></span>
                                        </div>
                                        <div>
                                            <h4 x-text="app.applicant.first_name + ' ' + app.applicant.last_name"></h4>
                                            <p x-text="app.job.title"></p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <span x-text="new Date(app.applied_at).toLocaleDateString(undefined, {month: 'short', day: 'numeric'})"></span>
                                        <a :href="'/employer/applicants/' + app.id">Review &rarr;</a>
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
