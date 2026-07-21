<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Abuse Moderation Queue') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
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

            <!-- Search and Filter -->
            <div>
                <form method="GET" action="{{ route('admin.reports.index') }}">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Report Status')" />
                        <select name="status" id="status">
                            <option value="">All Reports</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending Investigation</option>
                            <option value="reviewed" @selected(request('status') == 'reviewed')>Reviewed</option>
                            <option value="dismissed" @selected(request('status') == 'dismissed')>Dismissed</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reports List Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Reported Job</th>
                                <th>Employer Company</th>
                                <th>Reported By</th>
                                <th>Reason / Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $rep)
                                <tr>
                                    <td>
                                        @if($rep->job)
                                            <div>
                                                <a href="{{ route('jobs.show', $rep->job->slug) }}" target="_blank">{{ $rep->job->title }}</a>
                                            </div>
                                            <div>ID: {{ $rep->job->id }}</div>
                                        @else
                                            <span>Job Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $rep->job && $rep->job->company ? $rep->job->company->company_name : 'N/A' }}
                                    </td>
                                    <td>{{ $rep->user->first_name }} {{ $rep->user->last_name }}</td>
                                    <td>
                                        <span>{{ $rep->reason }}</span>
                                        <p>"{{ $rep->description }}"</p>
                                    </td>
                                    <td>{{ $rep->status }}</td>
                                    <td>
                                        <div>
                                            @if($rep->status === 'pending')
                                                <!-- Action Modals Trigger -->
                                                <button onclick="openActionModal({{ $rep->id }})">
                                                    Take Action
                                                </button>
                                            @else
                                                <span>Processed</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No abuse reports in queue.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $reports->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Moderation Action Modal container -->
    <div id="actionModal">
        <div>
            <h3>Investigate & Resolve Report</h3>
            
            <form id="actionForm" method="POST" action="">
                @csrf
                <div>
                    <x-input-label for="mod_action" :value="__('Select Action')" />
                    <select name="action" id="mod_action" required>
                        <option value="dismiss">Dismiss Report (No Action)</option>
                        <option value="remove_content">Close & Hide Job Listing</option>
                        <option value="warn_employer">Warn Employer Profile</option>
                        <option value="ban_employer">Ban & Suspend Employer Account</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="mod_notes" :value="__('Moderator Notes')" />
                    <textarea name="notes" id="mod_notes" rows="3" placeholder="Specify reasons or investigation logs..."></textarea>
                </div>

                <div>
                    <button type="button" onclick="closeActionModal()">Cancel</button>
                    <button type="submit">Submit Action</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openActionModal(reportId) {
            const modal = document.getElementById('actionModal');
            const form = document.getElementById('actionForm');
            form.action = '/admin/reports/' + reportId + '/action';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeActionModal() {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
