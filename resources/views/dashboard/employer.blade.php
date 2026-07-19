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

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" 
         x-data="{ 
            currentTab: 'overview', 
            chatUser: 'Muhammad Maaz', 
            messageText: '', 
            messagesList: [
                { sender: 'employer', text: 'Hi Muhammad, thanks for applying to our Senior Architect role. We loved your portfolio!' },
                { sender: 'candidate', text: 'Thank you! I am very excited about the opportunity in Canada.' },
                { sender: 'employer', text: 'Great. Are you available for a brief Google Meet next Monday?' }
            ],
            sendMsg() {
                if(this.messageText.trim()){
                    this.messagesList.push({ sender: 'employer', text: this.messageText.trim() });
                    this.messageText = '';
                    setTimeout(() => {
                        this.messagesList.push({ sender: 'candidate', text: 'Sounds good! I will confirm that time.' });
                    }, 1000);
                }
            }
         }"
    >
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

            <!-- Tab Navigation Links -->
            <div class="flex flex-wrap gap-6 border-b border-gray-200 dark:border-gray-800 pb-2 text-sm font-bold text-gray-500 dark:text-gray-400 no-print">
                <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Overview</button>
                <button @click="currentTab = 'analytics'" :class="currentTab === 'analytics' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Analytics Insights</button>
                <button @click="currentTab = 'scheduler'" :class="currentTab === 'scheduler' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Interview Schedule</button>
                <button @click="currentTab = 'messages'" :class="currentTab === 'messages' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Messages Inbox</button>
                <button @click="currentTab = 'billing'" :class="currentTab === 'billing' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Plans & Billing</button>
            </div>

            <!-- 1. OVERVIEW TAB -->
            <div x-show="currentTab === 'overview'" class="space-y-8" x-transition>
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                            💼
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['active_jobs'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Active Postings</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 rounded-xl">
                            👥
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['total_applications'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Total Applications</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 rounded-xl">
                            📅
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['interviews_scheduled'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Scheduled Interviews</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-purple-50 dark:bg-purple-950/30 text-purple-650 dark:text-purple-400 rounded-xl">
                            🌟
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['candidates_hired'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Candidates Hired</div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Analytics Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 md:col-span-2 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Applications Over Time (Last 4 Weeks)</h3>
                        <div class="h-64">
                            <canvas id="applicationsLineChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Applications Status</h3>
                        <div class="h-64 flex items-center justify-center">
                            <canvas id="statusDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Recent Applications -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Recent Incoming Applications</h3>
                                <a href="{{ route('employer.applicants.index') }}" class="text-xs font-bold text-primary-500 hover:underline">View All</a>
                            </div>

                            <div class="divide-y divide-gray-100 dark:divide-gray-750">
                                @forelse($recentApplications as $app)
                                    <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center font-extrabold text-xs text-gray-500">
                                                {{ substr($app->applicant->first_name,0,1) }}{{ substr($app->applicant->last_name,0,1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">
                                                    <a href="{{ route('employer.applicants.show', $app->id) }}" class="hover:text-primary-500 transition">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</a>
                                                </h4>
                                                <p class="text-[10px] text-gray-400 font-semibold">{{ $app->job->title }} &bull; Applied {{ $app->applied_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase 
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
                                            <a href="{{ route('employer.applicants.show', $app->id) }}" class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 font-bold rounded-xl text-[10px] transition">Review</a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic py-6 text-center">No applications received yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Job Listings Performance -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Active Postings Performance</h3>
                                <a href="{{ route('employer.jobs.index') }}" class="text-xs font-bold text-primary-500 hover:underline">Manage Jobs</a>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-900 text-[10px] font-extrabold uppercase text-gray-400 border-b border-gray-100 dark:border-gray-850">
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

                    <!-- Right Column Sidebar -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 space-y-4">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Company Reputation</h3>
                            <div class="space-y-4 text-center">
                                <div>
                                    <p class="text-3xl font-black text-primary-500">{{ number_format($averageRating, 1) }}</p>
                                    <div class="flex items-center justify-center gap-1 mt-1 text-xs text-amber-500 font-bold">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= round($averageRating) ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Based on {{ $reviewsCount }} company reviews</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $metrics['followers_count'] }}</p>
                                        <p class="text-[9px] text-gray-450 uppercase font-semibold">Total Followers</p>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $metrics['total_views'] }}</p>
                                        <p class="text-[9px] text-gray-455 uppercase font-semibold">Listing Views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. ANALYTICS INSIGHTS TAB -->
            <div x-show="currentTab === 'analytics'" class="space-y-6" x-transition style="display: none;">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Hiring Conversion Rate</span>
                        <p class="text-3xl font-black text-emerald-500 mt-1">8.5%</p>
                        <p class="text-[10px] text-gray-500 mt-1">Conversions from initial view to hired status</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Average Time-to-Hire</span>
                        <p class="text-3xl font-black text-primary-500 mt-1">18 Days</p>
                        <p class="text-[10px] text-gray-500 mt-1">Average pipeline progression duration</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50">
                        <span class="text-xs font-semibold text-gray-400 uppercase">Offer Acceptance</span>
                        <p class="text-3xl font-black text-purple-500 mt-1">92%</p>
                        <p class="text-[10px] text-gray-500 mt-1">Percentage of candidate job acceptances</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Detailed Channel Insights</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Total Views</span>
                            <p class="text-xl font-black mt-1">1,480</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Applications</span>
                            <p class="text-xl font-black mt-1">125</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Interviews</span>
                            <p class="text-xl font-black mt-1">15</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Offers Issued</span>
                            <p class="text-xl font-black mt-1">4</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. INTERVIEW SCHEDULER TAB -->
            <div x-show="currentTab === 'scheduler'" class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-transition style="display: none;">
                <!-- Calendar layout -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">July 2026 Calendar</h3>
                    <div class="grid grid-cols-7 gap-2 text-center text-xs font-semibold text-gray-400 py-2 border-b border-gray-100 dark:border-gray-700">
                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                    </div>
                    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-700 dark:text-gray-300 pt-2">
                        <!-- Dates padding -->
                        @for($i = 1; $i <= 3; $i++) <div></div> @endfor
                        @for($day = 1; $day <= 31; $day++)
                            <div class="p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-700 relative cursor-pointer {{ $day === 20 ? 'bg-primary-500 text-white hover:bg-primary-600' : '' }} {{ $day === 22 ? 'border border-amber-500' : '' }}">
                                {{ $day }}
                                @if($day === 20 || $day === 22)
                                    <span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full {{ $day === 20 ? 'bg-white' : 'bg-amber-500' }}"></span>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Agenda Sidebar -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750">Upcoming Interviews</h3>
                    
                    <div class="space-y-4 text-xs">
                        <div class="p-3.5 bg-primary-500/5 rounded-xl border border-primary-500/20 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-extrabold text-primary-500">July 20, 10:00 AM</span>
                                <span class="bg-emerald-500/20 text-emerald-400 px-1.5 py-0.5 rounded text-[9px] font-bold">Confirmed</span>
                            </div>
                            <p class="font-bold">Candidate: Muhammad Maaz</p>
                            <p class="text-gray-500">Role: Senior Full-Stack Architect</p>
                            <p class="text-gray-500">Channel: Google Meet Video Room</p>
                        </div>

                        <div class="p-3.5 bg-amber-500/5 rounded-xl border border-amber-500/20 space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-extrabold text-amber-600">July 22, 02:00 PM</span>
                                <span class="bg-amber-500/20 text-amber-500 px-1.5 py-0.5 rounded text-[9px] font-bold">Pending Confirmation</span>
                            </div>
                            <p class="font-bold">Candidate: Jane Doe</p>
                            <p class="text-gray-500">Role: Lead UX/UI designer</p>
                            <p class="text-gray-500">Channel: Local Office Interview</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. CHAT MESSAGES TAB -->
            <div x-show="currentTab === 'messages'" class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 h-[500px] flex overflow-hidden" x-transition style="display: none;">
                <!-- Chat candidate sidebar -->
                <div class="w-1/3 border-r border-gray-150 dark:border-gray-700 flex flex-col justify-between">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 font-bold text-xs uppercase text-gray-400">Candidate Chats</div>
                    <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-750 text-xs font-semibold text-gray-700 dark:text-gray-300">
                        <button @click="chatUser = 'Muhammad Maaz'" :class="chatUser === 'Muhammad Maaz' ? 'bg-primary-50 dark:bg-dark-850 text-primary-500' : 'hover:bg-gray-50 dark:hover:bg-dark-800/40'" class="w-full text-left p-4 flex items-center gap-3 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-950/20 text-primary-500 flex items-center justify-center font-bold text-xs">MM</div>
                            <div>
                                <h4 class="font-bold">Muhammad Maaz</h4>
                                <p class="text-[10px] text-gray-400">Senior Architect candidate</p>
                            </div>
                        </button>
                        <button @click="chatUser = 'Jane Doe'" :class="chatUser === 'Jane Doe' ? 'bg-primary-50 dark:bg-dark-850 text-primary-500' : 'hover:bg-gray-50 dark:hover:bg-dark-800/40'" class="w-full text-left p-4 flex items-center gap-3 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-950/20 text-purple-500 flex items-center justify-center font-bold text-xs">JD</div>
                            <div>
                                <h4 class="font-bold">Jane Doe</h4>
                                <p class="text-[10px] text-gray-400">Lead UX designer</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Chat message dialogue pane -->
                <div class="w-2/3 flex flex-col justify-between h-full bg-gray-50/50 dark:bg-dark-900/10">
                    <!-- Dialogue header -->
                    <div class="px-6 py-4 border-b border-gray-150 dark:border-gray-700/50 bg-white dark:bg-gray-800 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white" x-text="chatUser"></h4>
                            <p class="text-[10px] text-gray-400 flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Online &bull; Candidate</p>
                        </div>
                    </div>

                    <!-- Conversation bubble display -->
                    <div class="flex-1 p-6 overflow-y-auto space-y-4">
                        <template x-for="(msg, i) in messagesList" :key="i">
                            <div class="flex" :class="msg.sender === 'employer' ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[70%] p-3 rounded-2xl text-xs leading-relaxed" 
                                     :class="msg.sender === 'employer' ? 'bg-primary-500 text-white rounded-tr-none shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-tl-none border border-gray-150 dark:border-gray-700'">
                                    <p x-text="msg.text"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Send input area -->
                    <div class="p-4 border-t border-gray-150 dark:border-gray-700/50 bg-white dark:bg-gray-800 flex items-center gap-2">
                        <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type a message to candidate..." class="flex-1 w-full px-4 py-2.5 rounded-xl border border-gray-250 dark:border-gray-705 bg-gray-50 dark:bg-dark-850 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm" />
                        <button type="button" @click="sendMsg()" class="px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                            Send
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. PLANS & BILLING TAB -->
            <div x-show="currentTab === 'billing'" class="space-y-6" x-transition style="display: none;">
                <!-- Plan summary -->
                <div class="bg-gradient-to-r from-primary-600 to-indigo-700 rounded-3xl p-6 md:p-8 text-white flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-extrabold bg-accent-500 text-white mb-2 tracking-wider uppercase">Active Membership</span>
                        <h3 class="text-2xl font-bold">Premium Corporate Plan</h3>
                        <p class="text-xs text-primary-100 mt-1">Provides access to candidate database search, verified status, and unlimited postings. Renewal Date: August 31, 2026</p>
                    </div>
                    <span class="text-3xl font-black text-accent-500 shrink-0">$129 CAD / mo</span>
                </div>

                <!-- Plans upgrade cards list -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                    <!-- Standard card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 flex flex-col justify-between min-h-[300px]">
                        <div>
                            <h4 class="font-bold text-base text-gray-900 dark:text-white">Basic Starter</h4>
                            <p class="text-xs text-gray-400 mt-1">For single hirers posting role requirements.</p>
                            <p class="text-2xl font-black text-gray-900 dark:text-white mt-4">$49<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                            <ul class="text-[10px] text-gray-500 mt-4 space-y-1.5 font-semibold">
                                <li>✓ Post up to 3 jobs</li>
                                <li>✓ Standard placement status</li>
                                <li>✓ Email candidate notifications</li>
                            </ul>
                        </div>
                        <button type="button" class="w-full mt-6 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 text-xs font-bold hover:bg-gray-50 cursor-pointer">Downgrade</button>
                    </div>

                    <!-- Premium card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border-2 border-primary-500 shadow-md flex flex-col justify-between min-h-[300px] relative">
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-primary-500 text-white">Current Plan</span>
                        <div>
                            <h4 class="font-bold text-base text-gray-900 dark:text-white">Premium Corporate</h4>
                            <p class="text-xs text-gray-400 mt-1">Complete candidates screen pipeline access.</p>
                            <p class="text-2xl font-black text-primary-500 mt-4">$129<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                            <ul class="text-[10px] text-gray-500 mt-4 space-y-1.5 font-semibold">
                                <li>✓ Unlimited job listings</li>
                                <li>✓ Candidate search filters</li>
                                <li>✓ Verified employer badge logo</li>
                                <li>✓ Analytics tracking tools</li>
                            </ul>
                        </div>
                        <button type="button" class="w-full mt-6 py-2.5 rounded-xl bg-primary-500 text-white text-xs font-bold hover:bg-primary-600 shadow-sm cursor-pointer" disabled>Active</button>
                    </div>

                    <!-- Enterprise card -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50 flex flex-col justify-between min-h-[300px]">
                        <div>
                            <h4 class="font-bold text-base text-gray-900 dark:text-white">Enterprise Scaler</h4>
                            <p class="text-xs text-gray-400 mt-1">Custom agency candidate listings panel.</p>
                            <p class="text-2xl font-black text-gray-900 dark:text-white mt-4">$299<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                            <ul class="text-[10px] text-gray-500 mt-4 space-y-1.5 font-semibold">
                                <li>✓ Unlimited corporate channels</li>
                                <li>✓ API automated postings</li>
                                <li>✓ Dedicated support manager</li>
                                <li>✓ AI recruiter screener tool</li>
                            </ul>
                        </div>
                        <button type="button" class="w-full mt-6 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 text-xs font-bold hover:bg-gray-50 cursor-pointer">Upgrade Plan</button>
                    </div>
                </div>

                <!-- Transaction Invoices List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750">Billing History Invoices</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 text-[10px] font-extrabold uppercase text-gray-450 border-b border-gray-100 dark:border-gray-850">
                                    <th class="p-3">Billing Date</th>
                                    <th class="p-3">Invoice Number</th>
                                    <th class="p-3">Payment Amount</th>
                                    <th class="p-3">Payment Type</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-600 dark:text-gray-300 font-semibold">
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20">
                                    <td class="p-3">July 01, 2026</td>
                                    <td class="p-3 text-primary-500 hover:underline cursor-pointer">INV-26901-89</td>
                                    <td class="p-3">$129.00 CAD</td>
                                    <td class="p-3">Monthly Membership Renew</td>
                                    <td class="p-3"><span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-400 px-2 py-0.5 rounded text-[10px] font-extrabold">Paid</span></td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20">
                                    <td class="p-3">June 01, 2026</td>
                                    <td class="p-3 text-primary-500 hover:underline cursor-pointer">INV-26901-44</td>
                                    <td class="p-3">$129.00 CAD</td>
                                    <td class="p-3">Monthly Membership Renew</td>
                                    <td class="p-3"><span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-400 px-2 py-0.5 rounded text-[10px] font-extrabold">Paid</span></td>
                                </tr>
                            </tbody>
                        </table>
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
                borderColor: 'rgb(79, 70, 229)',
                datasets: [{
                    label: 'Applications Received',
                    data: Object.values(weeklyData),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    tension: 0.35,
                    fill: true,
                    borderWidth: 2.5
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
                        labels: { boxWidth: 8, font: { size: 9 } }
                    }
                }
            }
        });
    </script>
</x-app-layout>
