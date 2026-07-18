<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Platform Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-red-600 to-pink-600 rounded-3xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="md:flex md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Platform Management Console</h1>
                        <p class="mt-2 text-red-100 max-w-xl text-sm">Review companies verification requests, moderate active jobs listings, manage reported contents, handle user status suspension, update categories and broadcast messages.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-red-50 dark:bg-red-950/30 text-red-650 dark:text-red-400 rounded-xl text-lg">
                        👥
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['total_users'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Total Users</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-650 dark:text-blue-400 rounded-xl text-lg">
                        🏢
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['companies_count'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Companies</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-650 dark:text-amber-400 rounded-xl text-lg">
                        💼
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['active_jobs'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Active Jobs</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-rose-50 dark:bg-rose-950/30 text-rose-650 dark:text-rose-400 rounded-xl text-lg">
                        ⚠️
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['reports_count'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Pending Reports</div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout: Main Actions Navigation & Recent Audits -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Actions Dashboard Grid -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Administrative Sub-Panels</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">👥</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">User Management</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Suspend, activate, reset user passwords.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.companies.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">🏢</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Company Verifications</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Approve, reject, or verify employer companies.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.jobs.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">💼</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Listing Moderations</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Feature, mark urgent, approve, or hide job postings.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">⚠️</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Abuse Moderation Queue</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Investigate duplicate listings, spam, scam reports.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.categories.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">📁</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Master Categories</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Add, edit, or delete parent/child job fields.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.skills.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">🛠️</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Skills Mapping</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Merge duplicate skills, manage master list.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reviews.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">💬</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Review Moderations</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Approve, hide, or moderate company ratings reviews.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.announcements.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-950 rounded-2xl border border-gray-150 dark:border-gray-850 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">📢</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Announcements Broadcast</h4>
                                    <p class="text-3xs text-gray-500 font-semibold mt-0.5">Send alerts broadcast notifications to all users.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Recent Audits Activity -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">System Audit Log</h3>
                            <a href="{{ route('admin.audit-logs.index') }}" class="text-xs font-bold text-indigo-650 hover:underline">View All</a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentAudits as $log)
                                <div class="border-l-2 border-gray-200 dark:border-gray-700 ps-3 py-0.5 space-y-0.5">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white uppercase">{{ str_replace('_', ' ', $log->action) }}</p>
                                    <p class="text-3xs text-gray-500 font-medium leading-relaxed">{{ $log->description }}</p>
                                    <span class="text-4xs text-gray-400 block">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No audit records found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
