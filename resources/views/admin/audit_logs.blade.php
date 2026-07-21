<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('System Audit Logs') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Search and Filter -->
            <div>
                <form method="GET" action="{{ route('admin.audit-logs.index') }}">
                    <div>
                        <x-input-label for="action" :value="__('Filter By Action Key')" />
                        <input type="text" name="action" id="action" placeholder="e.g. user_suspended" value="{{ request('action') }}" />
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Moderator Name')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Admin" value="{{ request('search') }}" />
                    </div>

                    <div>
                        <button type="submit">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Audit Logs List Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Performed By</th>
                                <th>Description</th>
                                <th>IP Address</th>
                                <th>Date Performed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <span>
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System / Guest' }}
                                    </td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>{{ $log->created_at->format('M d, Y - h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No audit log records logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
