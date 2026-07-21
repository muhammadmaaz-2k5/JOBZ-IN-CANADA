<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Recruitment Console') }}
            </h2>
            <span class="status-badge status-pending font-bold">
                🏢 Company: {{ $employerProfile->company->company_name ?? 'Not Assigned' }}
            </span>
        </div>
    </x-slot>

    <div class="space-y-8 animate-fade-in" 
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
        @if(session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header banner -->
        <x-card variant="gradient" color="green" padding="lg" class="relative overflow-hidden shadow-xl border-0">
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                        Employer Dashboard
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white">Recruit Top Talents</h1>
                    <p class="text-emerald-100 max-w-xl text-sm leading-relaxed">
                        Create job postings, manage incoming applications, move candidates along hiring pipeline swimlanes, and view performance insights.
                    </p>
                </div>
                <div class="mt-6 md:mt-0 flex gap-3 flex-wrap">
                    <a href="{{ route('employer.jobs.create') }}" class="btn bg-white hover:bg-gray-50 text-emerald-600 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Post New Job
                    </a>
                    <a href="{{ route('employer.applicants.pipeline.all') }}" class="btn bg-white/10 hover:bg-white/20 text-white border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                        ATS Pipeline Board
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Tab Navigation Links -->
        <div class="tab-bar no-print">
            <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'tab-btn active' : 'tab-btn'">Overview</button>
            <button @click="currentTab = 'analytics'" :class="currentTab === 'analytics' ? 'tab-btn active' : 'tab-btn'">Analytics Insights</button>
            <button @click="currentTab = 'scheduler'" :class="currentTab === 'scheduler' ? 'tab-btn active' : 'tab-btn'">Interview Schedule</button>
            <button @click="currentTab = 'messages'" :class="currentTab === 'messages' ? 'tab-btn active' : 'tab-btn'">Messages Inbox</button>
            <button @click="currentTab = 'billing'" :class="currentTab === 'billing' ? 'tab-btn active' : 'tab-btn'">Plans &amp; Billing</button>
        </div>

        <!-- 1. OVERVIEW TAB -->
        <div x-show="currentTab === 'overview'" class="space-y-8" x-transition>
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                <x-card variant="stat" label="Active Postings" value="{{ $metrics['active_jobs'] }}" color="green" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.008v.008H12V12zm0 0h.008v.008H12V12z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Total Applications" value="{{ $metrics['total_applications'] }}" color="blue" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Scheduled Interviews" value="{{ $metrics['interviews_scheduled'] }}" color="amber" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Candidates Hired" value="{{ $metrics['candidates_hired'] }}" color="purple" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Charts & Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <x-card variant="default" class="lg:col-span-2">
                    <x-slot name="header">Applications Over Time (Last 4 Weeks)</x-slot>
                    <div class="h-64">
                        <canvas id="applicationsLineChart"></canvas>
                    </div>
                </x-card>

                <x-card variant="default">
                    <x-slot name="header">Applications Status</x-slot>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </x-card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Applications -->
                <div class="lg:col-span-2 space-y-6">
                    <x-card variant="default">
                        <x-slot name="header">
                            <div class="flex justify-between items-center w-full">
                                <span>Recent Incoming Applications</span>
                                <a href="{{ route('employer.applicants.index') }}" class="text-xs font-bold text-primary-500 hover:underline">View All</a>
                            </div>
                        </x-slot>

                        <div class="divide-y divide-gray-100 dark:divide-gray-800/60">
                            @forelse($recentApplications as $app)
                                <div class="py-4 flex justify-between items-center gap-4 flex-wrap first:pt-0 last:pb-0">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-950/20 flex items-center justify-center font-extrabold text-xs text-primary-600">
                                            {{ substr($app->applicant->first_name,0,1) }}{{ substr($app->applicant->last_name,0,1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                                                <a href="{{ route('employer.applicants.show', $app->id) }}" class="hover:text-primary-500 transition">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</a>
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="text-gray-700 dark:text-gray-300 font-semibold">{{ $app->job->title }}</span> &bull; 
                                                <span>Applied {{ $app->applied_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="status-badge 
                                            @if($app->status === 'applied') status-draft
                                            @elseif($app->status === 'pending_review') status-pending
                                            @elseif($app->status === 'shortlisted') status-hired
                                            @elseif(str_contains($app->status, 'interview')) status-interview
                                            @elseif($app->status === 'offered') status-active
                                            @elseif($app->status === 'hired') status-active
                                            @elseif($app->status === 'withdrawn') status-draft
                                            @else status-closed
                                            @endif">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('employer.applicants.show', $app->id) }}" class="btn btn-sm btn-ghost">Review</a>
                                    </div>
                                </div>
                            @empty
                                <x-empty-state title="No Applications" subtitle="No applications received yet. Improve your listings or promote them to gain visibility." icon="✉️" />
                            @endforelse
                        </div>
                    </x-card>

                    <!-- Job Listings Performance -->
                    <x-card variant="default">
                        <x-slot name="header">
                            <div class="flex justify-between items-center w-full">
                                <span>Active Postings Performance</span>
                                <a href="{{ route('employer.jobs.index') }}" class="text-xs font-bold text-primary-500 hover:underline">Manage Jobs</a>
                            </div>
                        </x-slot>
                        
                        <div class="overflow-x-auto -mx-6">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Views</th>
                                        <th>Applications</th>
                                        <th>Saves</th>
                                        <th>Conv. Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jobPerformance as $perf)
                                        <tr>
                                            <td class="font-bold text-gray-900 dark:text-white">{{ $perf->title }}</td>
                                            <td>{{ $perf->views_count }}</td>
                                            <td>{{ $perf->applications_count }}</td>
                                            <td>{{ $perf->saved_by_users_count }}</td>
                                            <td>
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
                    </x-card>
                </div>

                <!-- Right Column Sidebar -->
                <div class="space-y-6">
                    <x-card variant="default">
                        <x-slot name="header">Company Reputation</x-slot>
                        <div class="space-y-4 text-center">
                            <div class="py-2">
                                <p class="text-4xl font-black text-primary-500">{{ number_format($averageRating, 1) }}</p>
                                <div class="flex items-center justify-center gap-1 mt-1 text-base text-amber-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-3xs text-gray-400 mt-1">Based on {{ $reviewsCount }} reviews</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3 border-t border-gray-100 dark:border-gray-800 pt-4">
                                <div class="p-3 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                                    <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $metrics['followers_count'] }}</p>
                                    <p class="text-4xs text-gray-500 uppercase mt-1.5 font-bold tracking-wider">Followers</p>
                                </div>
                                <div class="p-3 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
                                    <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $metrics['total_views'] }}</p>
                                    <p class="text-4xs text-gray-500 uppercase mt-1.5 font-bold tracking-wider">Total Views</p>
                                </div>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>

        <!-- 2. ANALYTICS INSIGHTS TAB -->
        <div x-show="currentTab === 'analytics'" class="space-y-6" x-transition style="display: none;">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <x-card variant="default">
                    <span class="text-3xs font-bold text-gray-400 uppercase tracking-wider block">Hiring Conversion Rate</span>
                    <p class="text-3xl font-black text-emerald-500 mt-1">8.5%</p>
                    <p class="text-3xs text-gray-550 dark:text-gray-450 mt-1">Conversions from initial view to hired status</p>
                </x-card>
                <x-card variant="default">
                    <span class="text-3xs font-bold text-gray-400 uppercase tracking-wider block">Average Time-to-Hire</span>
                    <p class="text-3xl font-black text-primary-500 mt-1">18 Days</p>
                    <p class="text-3xs text-gray-550 dark:text-gray-450 mt-1">Average pipeline progression duration</p>
                </x-card>
                <x-card variant="default">
                    <span class="text-3xs font-bold text-gray-400 uppercase tracking-wider block">Offer Acceptance</span>
                    <p class="text-3xl font-black text-purple-500 mt-1">92%</p>
                    <p class="text-3xs text-gray-550 dark:text-gray-450 mt-1">Percentage of candidate job acceptances</p>
                </x-card>
            </div>

            <x-card variant="default">
                <x-slot name="header">Detailed Channel Insights</x-slot>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-450 uppercase tracking-wider block">Total Views</span>
                        <p class="text-2xl font-black mt-1 text-gray-900 dark:text-white leading-none">1,480</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-455 uppercase tracking-wider block">Applications</span>
                        <p class="text-2xl font-black mt-1 text-gray-900 dark:text-white leading-none">125</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-455 uppercase tracking-wider block">Interviews</span>
                        <p class="text-2xl font-black mt-1 text-gray-900 dark:text-white leading-none">15</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-455 uppercase tracking-wider block">Offers Issued</span>
                        <p class="text-2xl font-black mt-1 text-gray-900 dark:text-white leading-none">4</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 3. INTERVIEW SCHEDULER TAB -->
        <div x-show="currentTab === 'scheduler'" class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-transition style="display: none;">
            <!-- Calendar layout -->
            <x-card variant="default" class="lg:col-span-2">
                <x-slot name="header">July 2026 Calendar</x-slot>
                <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-400 py-2 border-b border-gray-100 dark:border-gray-800">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-700 dark:text-gray-300 pt-2">
                    @for($i = 1; $i <= 3; $i++) <div></div> @endfor
                    @for($day = 1; $day <= 31; $day++)
                        <div class="p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 relative cursor-pointer {{ $day === 20 ? 'bg-primary-500 text-white hover:bg-primary-650' : '' }} {{ $day === 22 ? 'border border-amber-500' : '' }}">
                            {{ $day }}
                            @if($day === 20 || $day === 22)
                                <span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full {{ $day === 20 ? 'bg-white' : 'bg-amber-500' }}"></span>
                            @endif
                        </div>
                    @endfor
                </div>
            </x-card>

            <!-- Agenda Sidebar -->
            <x-card variant="default">
                <x-slot name="header">Upcoming Interviews</x-slot>
                
                <div class="space-y-4 text-xs">
                    <div class="p-3.5 bg-primary-500/5 dark:bg-primary-950/20 rounded-xl border border-primary-500/20 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary-500">July 20, 10:00 AM</span>
                            <span class="status-badge status-active text-[9px]">Confirmed</span>
                        </div>
                        <p class="font-bold text-gray-900 dark:text-white">Candidate: Muhammad Maaz</p>
                        <p class="text-gray-500 dark:text-gray-400">Role: Senior Full-Stack Architect</p>
                        <p class="text-gray-550 dark:text-gray-450">Channel: Google Meet Video Room</p>
                    </div>

                    <div class="p-3.5 bg-amber-500/5 dark:bg-amber-950/20 rounded-xl border border-amber-500/20 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-amber-600 dark:text-amber-450">July 22, 02:00 PM</span>
                            <span class="status-badge status-pending text-[9px]">Pending</span>
                        </div>
                        <p class="font-bold text-gray-900 dark:text-white">Candidate: Jane Doe</p>
                        <p class="text-gray-500 dark:text-gray-400">Role: Lead UX/UI designer</p>
                        <p class="text-gray-550 dark:text-gray-450">Channel: Local Office Interview</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 4. CHAT MESSAGES TAB -->
        <div x-show="currentTab === 'messages'" class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-800/80 h-[500px] flex overflow-hidden shadow-sm" x-transition style="display: none;">
            <!-- Chat candidate sidebar -->
            <div class="w-1/3 border-r border-gray-150 dark:border-gray-850 flex flex-col justify-between bg-gray-50/50 dark:bg-gray-950/40">
                <div class="p-4 border-b border-gray-100 dark:border-gray-850 font-bold text-xs uppercase text-gray-400 tracking-wider">Candidate Chats</div>
                <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-850 text-xs font-semibold text-gray-700 dark:text-gray-300">
                    <button @click="chatUser = 'Muhammad Maaz'" :class="chatUser === 'Muhammad Maaz' ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-500' : 'hover:bg-gray-50 dark:hover:bg-gray-850/40'" class="w-full text-left p-4 flex items-center gap-3 cursor-pointer transition">
                        <div class="w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 flex items-center justify-center font-bold text-xs">MM</div>
                        <div class="min-w-0">
                            <h4 class="font-bold truncate">Muhammad Maaz</h4>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">Senior Architect candidate</p>
                        </div>
                    </button>
                    <button @click="chatUser = 'Jane Doe'" :class="chatUser === 'Jane Doe' ? 'bg-primary-50 dark:bg-primary-950/20 text-primary-500' : 'hover:bg-gray-50 dark:hover:bg-gray-850/40'" class="w-full text-left p-4 flex items-center gap-3 cursor-pointer transition">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-650 flex items-center justify-center font-bold text-xs">JD</div>
                        <div class="min-w-0">
                            <h4 class="font-bold truncate">Jane Doe</h4>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">Lead UX designer</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Chat message dialogue pane -->
            <div class="w-2/3 flex flex-col justify-between h-full bg-white dark:bg-gray-900">
                <!-- Dialogue header -->
                <div class="px-6 py-4 border-b border-gray-150 dark:border-gray-850 bg-gray-50/50 dark:bg-gray-950/20 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white" x-text="chatUser"></h4>
                        <p class="text-3xs text-gray-450 flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> 
                            <span>Online &bull; Candidate</span>
                        </p>
                    </div>
                </div>

                <!-- Conversation bubble display -->
                <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/20 dark:bg-dark-950/10">
                    <template x-for="(msg, i) in messagesList" :key="i">
                        <div class="flex" :class="msg.sender === 'employer' ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[70%] p-3.5 rounded-2xl text-xs leading-relaxed" 
                                 :class="msg.sender === 'employer' ? 'bg-primary-500 text-white rounded-tr-none shadow-sm' : 'bg-gray-100 dark:bg-gray-800 text-gray-850 dark:text-gray-200 rounded-tl-none border border-gray-150/60 dark:border-gray-700/60'">
                                <p x-text="msg.text" class="text-inherit"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Send input area -->
                <div class="p-4 border-t border-gray-150 dark:border-gray-850 bg-white dark:bg-gray-900 flex items-center gap-2">
                    <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type a message to candidate..." class="flex-1 text-xs" />
                    <button type="button" @click="sendMsg()" class="btn btn-sm btn-primary">
                        Send
                    </button>
                </div>
            </div>
        </div>

        <!-- 5. PLANS & BILLING TAB -->
        <div x-show="currentTab === 'billing'" class="space-y-6" x-transition style="display: none;">
            <!-- Plan summary -->
            <x-card variant="gradient" color="blue" padding="lg">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-extrabold bg-accent-500 text-white mb-2 tracking-wider uppercase">Active Membership</span>
                        <h3 class="text-2xl font-bold text-white">Premium Corporate Plan</h3>
                        <p class="text-xs text-blue-100 mt-1">Provides access to candidate database search, verified status, and unlimited postings. Renewal Date: August 31, 2026</p>
                    </div>
                    <span class="text-3xl font-black text-accent-500 shrink-0">$129 CAD <span class="text-xs font-normal text-blue-100">/ mo</span></span>
                </div>
            </x-card>

            <!-- Plans upgrade cards list -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                <!-- Starter card -->
                <x-card variant="default" class="flex flex-col justify-between min-h-[320px]">
                    <div>
                        <h4 class="font-bold text-base text-gray-900 dark:text-white">Basic Starter</h4>
                        <p class="text-xs text-gray-450 mt-1">For single hirers posting role requirements.</p>
                        <p class="text-2xl font-black text-gray-900 dark:text-white mt-4">$49<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                        <ul class="text-2xs text-gray-500 dark:text-gray-400 mt-4 space-y-2">
                            <li>✓ Post up to 3 jobs</li>
                            <li>✓ Standard placement status</li>
                            <li>✓ Email candidate notifications</li>
                        </ul>
                    </div>
                    <button type="button" class="w-full btn btn-ghost mt-6">Downgrade</button>
                </x-card>

                <!-- Premium card -->
                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border-2 border-primary-500 shadow-xl flex flex-col justify-between min-h-[320px] relative">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-primary-500 text-white shadow-sm">Current Plan</span>
                    <div>
                        <h4 class="font-bold text-base text-gray-900 dark:text-white">Premium Corporate</h4>
                        <p class="text-xs text-gray-450 mt-1">Complete candidates screen pipeline access.</p>
                        <p class="text-2xl font-black text-primary-500 mt-4">$129<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                        <ul class="text-2xs text-gray-500 dark:text-gray-400 mt-4 space-y-2">
                            <li>✓ Unlimited job listings</li>
                            <li>✓ Candidate search filters</li>
                            <li>✓ Verified employer badge logo</li>
                            <li>✓ Analytics tracking tools</li>
                        </ul>
                    </div>
                    <button type="button" class="w-full btn btn-primary mt-6 cursor-not-allowed opacity-50" disabled>Active</button>
                </div>

                <!-- Enterprise card -->
                <x-card variant="default" class="flex flex-col justify-between min-h-[320px]">
                    <div>
                        <h4 class="font-bold text-base text-gray-900 dark:text-white">Enterprise Scaler</h4>
                        <p class="text-xs text-gray-450 mt-1">Custom agency candidate listings panel.</p>
                        <p class="text-2xl font-black text-gray-900 dark:text-white mt-4">$299<span class="text-xs font-normal text-gray-500"> CAD/mo</span></p>
                        <ul class="text-2xs text-gray-500 dark:text-gray-400 mt-4 space-y-2">
                            <li>✓ Unlimited corporate channels</li>
                            <li>✓ API automated postings</li>
                            <li>✓ Dedicated support manager</li>
                            <li>✓ AI recruiter screener tool</li>
                        </ul>
                    </div>
                    <button type="button" class="w-full btn btn-ghost mt-6">Upgrade Plan</button>
                </x-card>
            </div>

            <!-- Transaction Invoices List -->
            <x-card variant="default">
                <x-slot name="header">Billing History Invoices</x-slot>
                
                <div class="overflow-x-auto -mx-6">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Billing Date</th>
                                <th>Invoice Number</th>
                                <th>Payment Amount</th>
                                <th>Payment Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>July 01, 2026</td>
                                <td class="text-primary-500 hover:underline cursor-pointer">INV-26901-89</td>
                                <td>$129.00 CAD</td>
                                <td>Monthly Membership Renew</td>
                                <td><span class="status-badge status-active text-[10px]">Paid</span></td>
                            </tr>
                            <tr>
                                <td>June 01, 2026</td>
                                <td class="text-primary-500 hover:underline cursor-pointer">INV-26901-44</td>
                                <td>$129.00 CAD</td>
                                <td>Monthly Membership Renew</td>
                                <td><span class="status-badge status-active text-[10px]">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
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
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
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
