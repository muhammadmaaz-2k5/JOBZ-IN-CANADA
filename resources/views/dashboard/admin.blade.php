<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administrator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl shadow-xl overflow-hidden text-white p-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Platform Administration Console</h1>
                        <p class="mt-2 text-red-100 max-w-xl">Moderate job postings, handle user reports, review company registrations, and configure global master categories and skills.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Users Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A4.125 4.125 0 0 1 11.062 23H4.938A4.125 4.125 0 0 1 1 19.237v-.109" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">1</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Users</div>
                    </div>
                </div>

                <!-- Companies Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pending Approvals</div>
                    </div>
                </div>

                <!-- Jobs Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .552-.448 1-1 1H4.75c-.552 0-1-.448-1-1v-4.25m16.5 0a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Listings</div>
                    </div>
                </div>

                <!-- Reports Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Active Reports</div>
                    </div>
                </div>
            </div>

            <!-- Management Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Activity -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Moderate Reported Jobs</h3>
                    <div class="flex flex-col items-center justify-center py-10 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No active job reports to review.</p>
                    </div>
                </div>

                <!-- Admin Action Sidebar -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Quick Management</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-300 rounded-xl transition duration-150">
                                <span class="text-sm font-semibold">Verify Employer Companies</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-300 rounded-xl transition duration-150">
                                <span class="text-sm font-semibold">Manage Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-300 rounded-xl transition duration-150">
                                <span class="text-sm font-semibold">Manage Skills List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
