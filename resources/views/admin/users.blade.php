<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-950/30 border border-red-500/30 text-red-800 dark:text-red-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <x-input-label for="role" :value="__('Filter By Role')" />
                        <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                            <option value="">All Roles</option>
                            <option value="job_seeker" @selected(request('role') == 'job_seeker')>Job Seeker</option>
                            <option value="employer" @selected(request('role') == 'employer')>Employer</option>
                            <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Filter By Status')" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                            <option value="">All Statuses</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="suspended" @selected(request('status') == 'suspended')>Suspended</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Name/Email')" />
                        <input type="text" name="search" id="search" placeholder="e.g. John" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" />
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Users List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">User</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Role</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Created Date</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    </td>
                                    <td class="p-4">{{ $user->email }}</td>
                                    <td class="p-4 uppercase text-3xs">{{ str_replace('_', ' ', $user->role) }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded-full text-4xs font-black uppercase {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-850' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-450">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($user->id !== Auth::id())
                                                <!-- Impersonate -->
                                                <form method="POST" action="{{ route('admin.users.impersonate', $user->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 font-bold rounded-xl text-3xs transition">
                                                        Impersonate
                                                    </button>
                                                </form>

                                                <!-- Suspend / Activate -->
                                                <form method="POST" action="{{ route('admin.users.status', $user->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1 {{ $user->status === 'suspended' ? 'bg-emerald-50 text-emerald-650' : 'bg-red-50 text-red-600' }} font-bold rounded-xl text-3xs transition">
                                                        {{ $user->status === 'suspended' ? 'Activate' : 'Suspend' }}
                                                    </button>
                                                </form>

                                                <!-- Reset Password Trigger -->
                                                <button onclick="openResetModal({{ $user->id }})" class="px-2.5 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 font-bold rounded-xl text-3xs transition">
                                                    Reset Pass
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No users found matching the criteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Password Reset Modal container -->
    <div id="resetModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl max-w-sm w-full space-y-4 shadow-xl border border-gray-100 dark:border-gray-700">
            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Reset User Password</h3>
            
            <form id="resetForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="new_password" :value="__('New Password')" />
                    <input type="password" name="password" required id="new_password" class="w-full text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl mt-1" />
                </div>
                <div>
                    <x-input-label for="new_password_confirmation" :value="__('Confirm Password')" />
                    <input type="password" name="password_confirmation" required id="new_password_confirmation" class="w-full text-xs border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl mt-1" />
                </div>

                <div class="flex justify-end gap-2 pt-2 text-xs">
                    <button type="button" onclick="closeResetModal()" class="px-4 py-2 border border-gray-200 dark:border-gray-750 text-gray-700 dark:text-gray-300 rounded-xl font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-650 hover:bg-indigo-755 text-white rounded-xl font-bold">Update Password</button>
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
