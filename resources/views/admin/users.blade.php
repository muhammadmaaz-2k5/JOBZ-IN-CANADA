<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('User Management') }}
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
            @if(session('error'))
                <div>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div>
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div>
                        <x-input-label for="role" :value="__('Filter By Role')" />
                        <select name="role" id="role">
                            <option value="">All Roles</option>
                            <option value="job_seeker" @selected(request('role') == 'job_seeker')>Job Seeker</option>
                            <option value="employer" @selected(request('role') == 'employer')>Employer</option>
                            <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Filter By Status')" />
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="suspended" @selected(request('status') == 'suspended')>Suspended</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Name/Email')" />
                        <input type="text" name="search" id="search" placeholder="e.g. John" value="{{ request('search') }}" />
                    </div>

                    <div>
                        <button type="submit">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users List Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div>{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ str_replace('_', ' ', $user->role) }}</td>
                                    <td>
                                        <span>
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div>
                                            @if($user->id !== Auth::id())
                                                <!-- Impersonate -->
                                                <form method="POST" action="{{ route('admin.users.impersonate', $user->id) }}">
                                                    @csrf
                                                    <button type="submit">
                                                        Impersonate
                                                    </button>
                                                </form>

                                                <!-- Suspend / Activate -->
                                                <form method="POST" action="{{ route('admin.users.status', $user->id) }}">
                                                    @csrf
                                                    <button type="submit">
                                                        {{ $user->status === 'suspended' ? 'Activate' : 'Suspend' }}
                                                    </button>
                                                </form>

                                                <!-- Reset Password Trigger -->
                                                <button onclick="openResetModal({{ $user->id }})">
                                                    Reset Pass
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No users found matching the criteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Password Reset Modal container -->
    <div id="resetModal">
        <div>
            <h3>Reset User Password</h3>
            
            <form id="resetForm" method="POST" action="">
                @csrf
                <div>
                    <x-input-label for="new_password" :value="__('New Password')" />
                    <input type="password" name="password" required id="new_password" />
                </div>
                <div>
                    <x-input-label for="new_password_confirmation" :value="__('Confirm Password')" />
                    <input type="password" name="password_confirmation" required id="new_password_confirmation" />
                </div>

                <div>
                    <button type="button" onclick="closeResetModal()">Cancel</button>
                    <button type="submit">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResetModal(userId) {
            const modal = document.getElementById('resetModal');
            const form = document.getElementById('resetForm');
            form.action = '/admin/users/' + userId + '/password-reset';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeResetModal() {
            const modal = document.getElementById('resetModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
