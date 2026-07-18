<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employer Dashboard') }}
            </h2>
            <span class="text-sm px-3 py-1 bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400 font-medium rounded-full border border-amber-200 dark:border-amber-900/50">
                Company: {{ $employerProfile->company->company_name ?? 'Not Assigned' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-teal-500 to-emerald-600 rounded-2xl shadow-xl overflow-hidden text-white p-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Hire top talent for {{ $employerProfile->company->company_name ?? 'your Company' }}!</h1>
                        <p class="mt-2 text-emerald-100 max-w-xl">Create job postings, manage incoming applications, schedule candidate interviews, and view company analytics from this console.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex gap-3">
                        <a href="#" class="px-5 py-2.5 bg-white text-emerald-600 font-semibold rounded-xl shadow-md hover:bg-emerald-50 transition duration-200 text-sm">
                            Post a Job
                        </a>
                        <a href="#" class="px-5 py-2.5 bg-emerald-700/50 text-white font-semibold rounded-xl hover:bg-emerald-700/70 transition duration-200 text-sm border border-emerald-400/30">
                            Company Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Active Jobs -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .552-.448 1-1 1H4.75c-.552 0-1-.448-1-1v-4.25m16.5 0a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5m16.5 0v-4.25c0-.552-.448-1-1-1H4.75c-.552 0-1 .448-1 1v4.25M12 3v9m0 0l3-3m-3 3L9 9" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Active Jobs</div>
                    </div>
                </div>

                <!-- Total Applicants -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A4.125 4.125 0 0 1 11.062 23H4.938A4.125 4.125 0 0 1 1 19.237v-.109m14-5.029a4.125 4.125 0 0 0-4.474-3.978M15 14.128c0-1.103-.28-2.148-.775-3.057m-4.5 11.996h-.008v-.008h.008v.008Zm0-.008v-.008h-.008v.008h.008Zm0-3h-.008v-.008h.008v.008Zm0-.008v-.008h-.008v.008h.008Zm3-6h-.008v-.008h.008v.008Zm0-.008v-.008h-.008v.008h.008Zm0 3h-.008v-.008h.008v.008Zm0-.008v-.008h-.008v.008h.008Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Applicants</div>
                    </div>
                </div>

                <!-- Interviews Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Scheduled Interviews</div>
                    </div>
                </div>

                <!-- Avg Rating Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-3 bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.172-.437.695-.437.868 0l3.007 7.625c.106.27.359.467.653.488l8.28.588c.477.034.667.618.322.955l-6.17 6.023a.75.75 0 0 0-.213.655l1.644 8.243c.095.474-.413.844-.827.601L12 21.054l-7.387 4.043c-.414.243-.922-.127-.827-.601l1.644-8.243a.75.75 0 0 0-.213-.655l-6.17-6.023c-.345-.337-.155-.921.322-.955l8.28-.588c.294-.021.547-.218.653-.488l3.007-7.625Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $employerProfile->company->average_rating ?? '0.00' }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Company Rating</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Area -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Active Job Postings</h3>
                    <div class="flex flex-col items-center justify-center py-10 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">You haven't posted any jobs yet.</p>
                        <a href="#" class="mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-sm transition duration-150">
                            Post Your First Job
                        </a>
                    </div>
                </div>

                <!-- Sidebar Details -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Company Profile</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Industry</span>
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">{{ $employerProfile->company->industry ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Company Size</span>
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">{{ $employerProfile->company->company_size ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Website</span>
                            <p class="text-sm font-semibold">
                                <a href="{{ $employerProfile->company->website ?? '#' }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                    {{ $employerProfile->company->website ?? 'N/A' }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Your Designation</span>
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">{{ $employerProfile->designation ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
