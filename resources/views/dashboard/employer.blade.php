<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Recruitment Console') }}
            </h2>
            <span class="text-xs px-3.5 py-1.5 bg-amber-50 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400 font-bold rounded-xl border border-amber-250/30">
                🏢 Company: {{ $employerProfile->company->company_name ?? 'Not Assigned' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Header banner -->
            <div class="bg-gradient-to-r from-teal-600 to-emerald-600 rounded-3xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="md:flex md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Recruit Top Talents</h1>
                        <p class="mt-2 text-emerald-100 max-w-xl text-sm">Create job postings, manage incoming applications, move candidates along hiring pipeline swimlanes, and view performance insights.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex gap-3 flex-wrap">
                        <a href="{{ route('employer.jobs.create') }}" class="px-5 py-2.5 bg-white text-emerald-600 font-bold rounded-xl shadow hover:bg-emerald-50 transition text-xs">
                            + Post New Job
                        </a>
                        <a href="{{ route('employer.applicants.pipeline.all') }}" class="px-5 py-2.5 bg-emerald-800/40 text-white font-bold rounded-xl hover:bg-emerald-800/60 transition text-xs border border-emerald-400/20">
                            ATS Pipeline Board
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        💼
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['active_jobs'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Active Postings</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-650 dark:text-blue-400 rounded-xl">
                        👥
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['total_applications'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Total Applications</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-650 dark:text-amber-400 rounded-xl">
                        📅
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['interviews_scheduled'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Scheduled Interviews</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex items-center gap-3">
                    <div class="p-2.5 bg-purple-50 dark:bg-purple-950/30 text-purple-650 dark:text-purple-400 rounded-xl">
                        🌟
                    </div>
                    <div>
                        <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['candidates_hired'] }}</div>
                        <div class="text-3xs font-semibold text-gray-400 uppercase">Candidates Hired</div>
                    </div>
                </div>
            </div>

            <!-- Charts & Analytics Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Line Chart: Applications weekly -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 md:col-span-2 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Applications Over Time (Last 4 Weeks)</h3>
                    <div class="h-64">
                        <canvas id="applicationsLineChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Grouped by status -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4 font-semibold text-sm">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Applications Status</h3>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details: Applicants list -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Recent Applications -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Recent Incoming Applications</h3>
                            <a href="{{ route('employer.applicants.index') }}" class="text-xs font-bold text-indigo-650 hover:underline">View All</a>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-gray-750">
                            @forelse($recentApplications as $app)
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-900 flex items-center justify-center font-extrabold text-xs text-gray-400">
                                            {{ substr($app->applicant->first_name,0,1) }}{{ substr($app->applicant->last_name,0,1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">
                                                <a href="{{ route('employer.applicants.show', $app->id) }}" class="hover:text-indigo-650 transition">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</a>
                                            </h4>
                                            <p class="text-3xs text-gray-400 font-semibold">{{ $app->job->title }} &bull; Applied {{ $app->applied_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-3xs font-extrabold uppercase 
                                            @if($app->status === 'applied') bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                                            @elseif($app->status === 'pending_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300
                                            @elseif($app->status === 'shortlisted') bg-indigo-100 text-indigo-850 dark:bg-indigo-950 dark:text-indigo-300
                                            @elseif(str_contains($app->status, 'interview')) bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300
                                            @elseif($app->status === 'offered') bg-pink-100 text-pink-855 dark:bg-pink-950 dark:text-pink-300
                                            @elseif($app->status === 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                            @elseif($app->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                                            @endif">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('employer.applicants.show', $app->id) }}" class="px-3.5 py-1.5 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 text-gray-750 dark:text-gray-300 hover:bg-gray-100 font-bold rounded-xl text-3xs transition">Review</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-6 text-center">No applications received yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Job Listings Performance -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Active Postings Performance</h3>
                            <a href="{{ route('employer.jobs.index') }}" class="text-xs font-bold text-indigo-650 hover:underline">Manage Jobs</a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900 text-3xs font-extrabold uppercase text-gray-400 border-b border-gray-100 dark:border-gray-850">
                                        <th class="p-3">Job Title</th>
                                        <th class="p-3">Views</th>
                                        <th class="p-3">Applications</th>
                                        <th class="p-3">Saves</th>
                                        <th class="p-3">Conv. Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                                    @forelse($jobPerformance as $perf)
                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                            <td class="p-3 font-bold text-gray-900 dark:text-white">{{ $perf->title }}</td>
                                            <td class="p-3">{{ $perf->views_count }}</td>
                                            <td class="p-3">{{ $perf->applications_count }}</td>
                                            <td class="p-3">{{ $perf->saved_by_users_count }}</td>
                                            <td class="p-3">
                                                {{ $perf->views_count > 0 ? round(($perf->applications_count / $perf->views_count) * 100, 1) : 0 }}%
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-6 text-center text-gray-400 italic">No job postings created.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Company Analytics card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Company Reputation</h3>
                        
                        <div class="space-y-4 text-center">
                            <div>
                                <p class="text-3xl font-black text-indigo-650">{{ number_format($averageRating, 1) }}</p>
                                <div class="flex items-center justify-center gap-1 mt-1 text-xs text-amber-500 font-bold">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-3xs text-gray-400 mt-0.5">Based on {{ $reviewsCount }} company reviews</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $metrics['followers_count'] }}</p>
                                    <p class="text-4xs text-gray-400 uppercase font-semibold">Total Followers</p>
                                </div>
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $metrics['total_views'] }}</p>
                                    <p class="text-4xs text-gray-400 uppercase font-semibold">Listing Views</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Chart JS integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Applications weekly line chart
        const lineCtx = document.getElementById('applicationsLineChart').getContext('2d');
        const weeklyData = {{ json_encode($weeklyApplications) }};
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: Object.keys(weeklyData),
                datasets: [{
                    label: 'Applications Received',
                    data: Object.values(weeklyData),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Status doughnut chart
        const doughnutCtx = document.getElementById('statusDoughnutChart').getContext('2d');
        const statusData = {{ json_encode($statusData) }};
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(k => k.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.75)', // applied
                        'rgba(234, 179, 8, 0.75)',  // pending_review
                        'rgba(99, 102, 241, 0.75)',  // shortlisted
                        'rgba(168, 85, 247, 0.75)',  // interview
                        'rgba(236, 72, 153, 0.75)',  // offer
                        'rgba(16, 185, 129, 0.75)',  // hired
                        'rgba(239, 68, 68, 0.75)'    // rejected
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, font: { size: 9 } }
                    }
                }
            }
        });
    </script>
</x-app-layout>
