<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight">
                {{ __('Recruitment Console') }}
            </h2>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold text-sm border border-blue-100 dark:border-blue-800/50">
                🏢 {{ $employerProfile->company->company_name ?? 'Not Assigned' }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10 relative z-10"
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
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
            <div class="absolute top-[40%] -right-[10%] w-[40%] h-[60%] rounded-full bg-indigo-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[40%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        @if(session('success'))
            <x-alert type="success" class="mb-8">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header Banner -->
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-emerald-600 via-teal-600 to-emerald-800 text-white shadow-2xl shadow-emerald-900/20 p-10 md:p-14 border border-white/10">
            <!-- Decorative overlay -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute -right-24 -top-24 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -left-24 -bottom-24 w-72 h-72 bg-emerald-400 opacity-20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-sm font-semibold tracking-wide backdrop-blur-md mb-3 shadow-sm border border-white/10">
                        Employer Dashboard
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 drop-shadow-sm">Recruit Top Talents</h1>
                    <p class="text-emerald-50 max-w-xl text-lg font-medium leading-relaxed">
                        Create job postings, manage incoming applications, move candidates along hiring pipeline swimlanes, and view performance insights.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 shrink-0 w-full md:w-auto">
                    <a href="{{ route('employer.jobs.create') }}" class="group relative inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-emerald-700 bg-white rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full sm:w-auto overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-white via-emerald-50 to-white opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <svg class="w-5 h-5 relative z-10 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="relative z-10">Post New Job</span>
                    </a>
                    <a href="{{ route('employer.applicants.pipeline.all') }}" class="group inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-white bg-emerald-700/50 hover:bg-emerald-600/80 backdrop-blur-md rounded-xl border border-white/20 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 w-full sm:w-auto">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                        ATS Pipeline Board
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Navigation Links -->
        <div class="flex space-x-2 overflow-x-auto p-2 bg-white/40 dark:bg-slate-800/40 backdrop-blur-xl border border-white/60 dark:border-slate-700/60 rounded-2xl shadow-lg shadow-slate-200/20 dark:shadow-none">
            <button @click="currentTab = 'overview'" 
                    :class="currentTab === 'overview' ? 'bg-white dark:bg-slate-700 text-emerald-600 dark:text-emerald-400 shadow-sm border-white/80 dark:border-slate-600' : 'text-slate-600 dark:text-slate-400 hover:text-emerald-600 hover:bg-white/60 dark:hover:bg-slate-700/60 border-transparent'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all border flex whitespace-nowrap">
                Overview
            </button>
            <button @click="currentTab = 'analytics'" 
                    :class="currentTab === 'analytics' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 shadow-sm border-white/80 dark:border-slate-600' : 'text-slate-600 dark:text-slate-400 hover:text-indigo-600 hover:bg-white/60 dark:hover:bg-slate-700/60 border-transparent'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all border flex whitespace-nowrap">
                Analytics Insights
            </button>
            <button @click="currentTab = 'messages'" 
                    :class="currentTab === 'messages' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm border-white/80 dark:border-slate-600' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-white/60 dark:hover:bg-slate-700/60 border-transparent'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all border flex whitespace-nowrap">
                Messages Inbox
            </button>
            <button @click="currentTab = 'billing'" 
                    :class="currentTab === 'billing' ? 'bg-white dark:bg-slate-700 text-purple-600 dark:text-purple-400 shadow-sm border-white/80 dark:border-slate-600' : 'text-slate-600 dark:text-slate-400 hover:text-purple-600 hover:bg-white/60 dark:hover:bg-slate-700/60 border-transparent'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all border flex whitespace-nowrap">
                Plans &amp; Billing
            </button>
        </div>

        <!-- 1. OVERVIEW TAB -->
        <div x-show="currentTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="group relative overflow-hidden rounded-[2rem] bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none hover:-translate-y-1 hover:shadow-2xl hover:border-emerald-500/30 transition-all duration-300 p-6 flex flex-col items-center text-center justify-center gap-4">
                    <div class="p-4 rounded-2xl ring-4 bg-emerald-50 text-emerald-600 ring-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:ring-emerald-800/40 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.008v.008H12V12zm0 0h.008v.008H12V12z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Active Postings</p>
                        <p class="text-4xl font-black text-slate-900 dark:text-white">{{ $metrics['active_jobs'] }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[2rem] bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none hover:-translate-y-1 hover:shadow-2xl hover:border-blue-500/30 transition-all duration-300 p-6 flex flex-col items-center text-center justify-center gap-4">
                    <div class="p-4 rounded-2xl ring-4 bg-blue-50 text-blue-600 ring-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:ring-blue-800/40 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Applications</p>
                        <p class="text-4xl font-black text-slate-900 dark:text-white">{{ $metrics['total_applications'] }}</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[2rem] bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none hover:-translate-y-1 hover:shadow-2xl hover:border-purple-500/30 transition-all duration-300 p-6 flex flex-col items-center text-center justify-center gap-4">
                    <div class="p-4 rounded-2xl ring-4 bg-purple-50 text-purple-600 ring-purple-100 dark:bg-purple-900/30 dark:text-purple-400 dark:ring-purple-800/40 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Candidates Hired</p>
                        <p class="text-4xl font-black text-slate-900 dark:text-white">{{ $metrics['candidates_hired'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts & Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4">Applications Over Time (Last 4 Weeks)</h3>
                    <div class="h-64 w-full">
                        <canvas id="applicationsLineChart"></canvas>
                    </div>
                </div>

                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4">Applications Status</h3>
                    <div class="h-64 w-full flex justify-center">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Applications & Postings (Left Column) -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Recent Applications -->
                    <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden transition-all duration-300">
                        <div class="px-8 py-6 border-b border-slate-100/50 dark:border-slate-700/50 flex items-center justify-between bg-white/30 dark:bg-slate-800/30">
                            <span class="font-black text-xl text-slate-900 dark:text-white">Recent Incoming Applications</span>
                            <a href="{{ route('employer.applicants.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">View All &rarr;</a>
                        </div>

                        <div class="p-8 space-y-4">
                            @forelse($recentApplications as $app)
                                @if(is_object($app) && isset($app->applicant))
                                    <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/50 dark:bg-slate-800/40 backdrop-blur-md shadow-sm hover:border-emerald-300 dark:hover:border-emerald-500 hover:shadow-md transition-all duration-300 gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-lg shrink-0">
                                                {{ substr($app->applicant->first_name ?? 'A',0,1) }}{{ substr($app->applicant->last_name ?? '',0,1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                                    <a href="{{ route('employer.applicants.show', $app->id) }}">{{ $app->applicant->first_name ?? 'Unknown' }} {{ $app->applicant->last_name ?? '' }}</a>
                                                </h4>
                                                <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">
                                                    <span>{{ optional($app->job)->title ?? 'Unknown Job' }}</span> &bull; 
                                                    <span>Applied {{ $app->applied_at ? $app->applied_at->diffForHumans() : 'recently' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0 w-full sm:w-auto">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full 
                                                @if($app->status === 'hired') bg-green-100 text-green-700
                                                @elseif($app->status === 'interview_scheduled') bg-blue-100 text-blue-700
                                                @elseif($app->status === 'rejected') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif
                                                uppercase tracking-wide">
                                                {{ str_replace('_', ' ', $app->status) }}
                                            </span>
                                            <a href="{{ route('employer.applicants.show', $app->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors text-sm">
                                                Review
                                            </a>
                                        </div>
                                    </div>
                                @elseif(is_string($app))
                                    <div class="p-5 rounded-xl border border-gray-100 bg-gray-50 text-gray-500 font-medium">
                                        <p>{{ $app }}</p>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-8">
                                    <div class="text-5xl mb-4">✉️</div>
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">No Applications Yet</h4>
                                    <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-md mx-auto">No applications received yet. Improve your listings or promote them to gain visibility.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Job Listings Performance -->
                    <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden transition-all duration-300">
                        <div class="px-8 py-6 border-b border-slate-100/50 dark:border-slate-700/50 flex items-center justify-between bg-white/30 dark:bg-slate-800/30">
                            <span class="font-black text-xl text-slate-900 dark:text-white">Active Postings Performance</span>
                            <a href="{{ route('employer.jobs.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Manage Jobs &rarr;</a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                                        <th class="px-8 py-4 font-bold border-b border-gray-100 dark:border-slate-700/50">Job Title</th>
                                        <th class="px-6 py-4 font-bold border-b border-gray-100 dark:border-slate-700/50 text-center">Views</th>
                                        <th class="px-6 py-4 font-bold border-b border-gray-100 dark:border-slate-700/50 text-center">Applications</th>
                                        <th class="px-6 py-4 font-bold border-b border-gray-100 dark:border-slate-700/50 text-center">Saves</th>
                                        <th class="px-6 py-4 font-bold border-b border-gray-100 dark:border-slate-700/50 text-center">Conv. Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
                                    @forelse($jobPerformance as $perf)
                                        <tr class="hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors group">
                                            <td class="px-8 py-4 font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">{{ $perf->title }}</td>
                                            <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-300 text-center">{{ $perf->views_count }}</td>
                                            <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-300 text-center">
                                                <span class="inline-flex items-center justify-center px-2 py-1 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 min-w-[2rem]">{{ $perf->applications_count }}</span>
                                            </td>
                                            <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-300 text-center">{{ $perf->saved_by_users_count }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-16 h-2 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                                        @php $rate = $perf->views_count > 0 ? round(($perf->applications_count / $perf->views_count) * 100, 1) : 0; @endphp
                                                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min($rate, 100) }}%"></div>
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $rate }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-10 text-center text-gray-500 dark:text-gray-400">No job postings created.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column Sidebar -->
                <div class="space-y-8">
                    <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden transition-all duration-300">
                        <div class="px-8 py-6 border-b border-slate-100/50 dark:border-slate-700/50 bg-white/30 dark:bg-slate-800/30 font-black text-xl text-slate-900 dark:text-white">Company Reputation</div>
                        <div class="p-8">
                            <div class="flex flex-col items-center text-center pb-8 border-b border-gray-100 dark:border-slate-700/50">
                                <p class="text-6xl font-black text-slate-900 dark:text-white mb-2">{{ number_format($averageRating, 1) }}</p>
                                <div class="text-2xl text-amber-400 tracking-widest mb-2 flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{!! $i <= round($averageRating) ? '&#9733;' : '&#9734;' !!}</span>
                                    @endfor
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Based on {{ $reviewsCount }} reviews</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-8">
                                <div class="text-center p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30">
                                    <p class="text-2xl font-black text-indigo-700 dark:text-indigo-400">{{ $metrics['followers_count'] }}</p>
                                    <p class="text-sm font-bold text-indigo-900/60 dark:text-indigo-300/80 uppercase tracking-wider mt-1">Followers</p>
                                </div>
                                <div class="text-center p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30">
                                    <p class="text-2xl font-black text-emerald-700 dark:text-emerald-400">{{ $metrics['total_views'] }}</p>
                                    <p class="text-sm font-bold text-emerald-900/60 dark:text-emerald-300/80 uppercase tracking-wider mt-1">Total Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. ANALYTICS INSIGHTS TAB -->
        <div x-show="currentTab === 'analytics'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-indigo-700 text-white shadow-xl shadow-indigo-900/20 border border-indigo-400/30 relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 opacity-10 text-8xl -mr-4 -mb-4">📈</div>
                    <span class="block text-indigo-100 font-semibold mb-2 uppercase tracking-wider text-sm">Hiring Conversion Rate</span>
                    <p class="text-5xl font-black mb-4">8.5%</p>
                    <p class="text-indigo-100 text-sm">Conversions from initial view to hired status across all postings.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-gradient-to-br from-purple-500 to-purple-700 text-white shadow-xl shadow-purple-900/20 border border-purple-400/30 relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 opacity-10 text-8xl -mr-4 -mb-4">⏱️</div>
                    <span class="block text-purple-100 font-semibold mb-2 uppercase tracking-wider text-sm">Average Time-to-Hire</span>
                    <p class="text-5xl font-black mb-4">18 <span class="text-2xl font-medium">Days</span></p>
                    <p class="text-purple-100 text-sm">Average pipeline progression duration from application to offer.</p>
                </div>
                <div class="p-8 rounded-[2rem] bg-gradient-to-br from-teal-500 to-teal-700 text-white shadow-xl shadow-teal-900/20 border border-teal-400/30 relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 opacity-10 text-8xl -mr-4 -mb-4">🤝</div>
                    <span class="block text-teal-100 font-semibold mb-2 uppercase tracking-wider text-sm">Offer Acceptance</span>
                    <p class="text-5xl font-black mb-4">92%</p>
                    <p class="text-teal-100 text-sm">Percentage of candidate job acceptances after offer stage.</p>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden p-8">
                <h3 class="font-black text-xl text-slate-900 dark:text-white mb-6">Detailed Channel Insights</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center text-center">
                        <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-xs mb-2">Total Views</span>
                        <p class="text-3xl font-black text-slate-900 dark:text-white">1,480</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center text-center">
                        <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-xs mb-2">Applications</span>
                        <p class="text-3xl font-black text-slate-900 dark:text-white">125</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 flex flex-col items-center justify-center text-center">
                        <span class="text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider text-xs mb-2">Offers Issued</span>
                        <p class="text-3xl font-black text-slate-900 dark:text-white">4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. CHAT MESSAGES TAB -->
        <div x-show="currentTab === 'messages'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden h-[700px] flex">
            
            <!-- Chat candidate sidebar -->
            <div class="w-1/3 border-r border-gray-100 dark:border-slate-700/50 flex flex-col bg-white/40 dark:bg-slate-800/40">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50">
                    <h3 class="font-black text-lg text-slate-900 dark:text-white">Candidate Chats</h3>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <button @click="chatUser = 'Muhammad Maaz'" :class="chatUser === 'Muhammad Maaz' ? 'bg-blue-50/80 dark:bg-blue-900/20 border-l-4 border-blue-500' : 'hover:bg-gray-50 dark:hover:bg-slate-800/50 border-l-4 border-transparent'" class="w-full flex items-center gap-4 px-6 py-4 transition-colors text-left border-b border-gray-50 dark:border-slate-700/30">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg shrink-0">MM</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 dark:text-white truncate">Muhammad Maaz</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5">Senior Architect candidate</p>
                        </div>
                    </button>
                    <button @click="chatUser = 'Jane Doe'" :class="chatUser === 'Jane Doe' ? 'bg-blue-50/80 dark:bg-blue-900/20 border-l-4 border-blue-500' : 'hover:bg-gray-50 dark:hover:bg-slate-800/50 border-l-4 border-transparent'" class="w-full flex items-center gap-4 px-6 py-4 transition-colors text-left border-b border-gray-50 dark:border-slate-700/30">
                        <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg shrink-0">JD</div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 dark:text-white truncate">Jane Doe</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5">Lead UX designer</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Chat message dialogue pane -->
            <div class="w-2/3 flex flex-col relative bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                <!-- Dialogue header -->
                <div class="px-8 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md flex items-center justify-between sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center font-bold text-lg" x-text="chatUser.charAt(0)"></div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-900 dark:text-white" x-text="chatUser"></h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mt-0.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> 
                                <span>Online &bull; Candidate</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Conversation bubble display -->
                <div class="flex-1 overflow-y-auto p-8 space-y-6 flex flex-col bg-white/20 dark:bg-slate-900/20">
                    <template x-for="(msg, i) in messagesList" :key="i">
                        <div :class="msg.sender === 'employer' ? 'flex justify-end' : 'flex justify-start'">
                            <div :class="msg.sender === 'employer' ? 'bg-blue-600 text-white rounded-2xl rounded-tr-sm' : 'bg-white dark:bg-slate-800 text-slate-800 dark:text-white border border-gray-100 dark:border-slate-700 rounded-2xl rounded-tl-sm shadow-sm'" 
                                 class="max-w-[75%] px-5 py-3.5 relative group">
                                <p x-text="msg.text" class="text-sm leading-relaxed font-medium"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Send input area -->
                <div class="p-6 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-t border-gray-100 dark:border-slate-700/50">
                    <div class="flex items-center gap-4">
                        <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type a message to candidate..." class="flex-1 rounded-full border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700/50 px-6 py-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-inner" />
                        <button type="button" @click="sendMsg()" class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition-transform hover:scale-105 shadow-lg shadow-blue-600/30 shrink-0">
                            <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. PLANS & BILLING TAB -->
        <div x-show="currentTab === 'billing'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-8">
            <!-- Plan summary -->
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-[2rem] p-10 shadow-2xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-8 border border-slate-700">
                <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-xs uppercase tracking-wider mb-4 border border-emerald-500/30">Active Membership</span>
                    <h3 class="text-3xl font-black mb-2">Premium Corporate Plan</h3>
                    <p class="text-slate-400 max-w-xl font-medium">Provides access to candidate database search, verified status, and unlimited postings. Renewal Date: <strong class="text-white">August 31, 2026</strong></p>
                </div>
                <div class="relative z-10 shrink-0 text-center sm:text-right">
                    <span class="text-5xl font-black">$129 <span class="text-xl text-slate-400 font-medium">/ mo</span></span>
                </div>
            </div>

            <!-- Plans upgrade cards list -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Starter card -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-gray-200 dark:border-slate-700 p-8 flex flex-col justify-between hover:shadow-xl transition-shadow relative">
                    <div>
                        <h4 class="text-xl font-black text-slate-900 dark:text-white">Basic Starter</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 mb-6 min-h-[40px]">For single hirers posting role requirements.</p>
                        <p class="text-4xl font-black text-slate-900 dark:text-white mb-6">$49<span class="text-lg text-gray-500 font-medium">/mo</span></p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Post up to 3 jobs</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Standard placement status</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Email candidate notifications</li>
                        </ul>
                    </div>
                    <button type="button" class="w-full py-3 px-4 rounded-xl font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:text-gray-300 dark:hover:bg-slate-700 transition-colors">Downgrade</button>
                </div>

                <!-- Premium card -->
                <div class="bg-white dark:bg-slate-800 rounded-[2rem] border-2 border-emerald-500 p-8 flex flex-col justify-between shadow-xl shadow-emerald-500/10 relative transform scale-105 z-10">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span class="bg-emerald-500 text-white font-bold text-xs uppercase tracking-widest py-1 px-4 rounded-full shadow-md">Current Plan</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-slate-900 dark:text-white mt-2">Premium Corporate</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 mb-6 min-h-[40px]">Complete candidates screen pipeline access.</p>
                        <p class="text-4xl font-black text-emerald-600 dark:text-emerald-400 mb-6">$129<span class="text-lg text-gray-500 font-medium">/mo</span></p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Unlimited job listings</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Candidate search filters</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Verified employer badge logo</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Analytics tracking tools</li>
                        </ul>
                    </div>
                    <button type="button" disabled class="w-full py-3 px-4 rounded-xl font-bold text-white bg-emerald-500 cursor-default flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Active Plan
                    </button>
                </div>

                <!-- Enterprise card -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-gray-200 dark:border-slate-700 p-8 flex flex-col justify-between hover:shadow-xl transition-shadow relative">
                    <div>
                        <h4 class="text-xl font-black text-slate-900 dark:text-white">Enterprise Scaler</h4>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 mb-6 min-h-[40px]">Custom agency candidate listings panel.</p>
                        <p class="text-4xl font-black text-slate-900 dark:text-white mb-6">$299<span class="text-lg text-gray-500 font-medium">/mo</span></p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Unlimited corporate channels</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> API automated postings</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Dedicated support manager</li>
                            <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300 font-medium"><svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> AI recruiter screener tool</li>
                        </ul>
                    </div>
                    <button type="button" class="w-full py-3 px-4 rounded-xl font-bold text-white bg-slate-900 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 transition-colors shadow-md">Upgrade Plan</button>
                </div>
            </div>

            <!-- Transaction Invoices List -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100/50 dark:border-slate-700/50 bg-white/30 dark:bg-slate-800/30 font-black text-xl text-slate-900 dark:text-white">Billing History Invoices</div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-8 py-5 font-bold border-b border-gray-100 dark:border-slate-700/50">Billing Date</th>
                                <th class="px-6 py-5 font-bold border-b border-gray-100 dark:border-slate-700/50">Invoice Number</th>
                                <th class="px-6 py-5 font-bold border-b border-gray-100 dark:border-slate-700/50">Payment Amount</th>
                                <th class="px-6 py-5 font-bold border-b border-gray-100 dark:border-slate-700/50">Payment Type</th>
                                <th class="px-8 py-5 font-bold border-b border-gray-100 dark:border-slate-700/50 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
                            <tr class="hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-5 font-medium text-gray-900 dark:text-white">July 01, 2026</td>
                                <td class="px-6 py-5 font-mono text-sm text-gray-600 dark:text-gray-400">INV-26901-89</td>
                                <td class="px-6 py-5 font-bold text-gray-900 dark:text-white">$129.00 CAD</td>
                                <td class="px-6 py-5 text-gray-600 dark:text-gray-400 font-medium">Monthly Membership Renew</td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Paid</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-5 font-medium text-gray-900 dark:text-white">June 01, 2026</td>
                                <td class="px-6 py-5 font-mono text-sm text-gray-600 dark:text-gray-400">INV-26901-44</td>
                                <td class="px-6 py-5 font-bold text-gray-900 dark:text-white">$129.00 CAD</td>
                                <td class="px-6 py-5 text-gray-600 dark:text-gray-400 font-medium">Monthly Membership Renew</td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart JS integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Use custom font for charts
        Chart.defaults.font.family = "'Outfit', 'Inter', sans-serif";
        Chart.defaults.color = '#64748b'; // slate-500

        // Applications weekly line chart
        const lineCtx = document.getElementById('applicationsLineChart').getContext('2d');
        const weeklyData = {!! json_encode($weeklyApplications) !!};
        
        // Gradient fill for line chart
        const lineGradient = lineCtx.createLinearGradient(0, 0, 0, 400);
        lineGradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
        lineGradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: Object.keys(weeklyData),
                datasets: [{
                    label: 'Applications Received',
                    data: Object.values(weeklyData),
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: lineGradient,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: 'rgb(16, 185, 129)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4, // Smooth curves
                    fill: true,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: false,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        border: { display: false },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)',
                            drawBorder: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });

        // Status doughnut chart
        const doughnutCtx = document.getElementById('statusDoughnutChart').getContext('2d');
        const statusData = {!! json_encode($statusData) !!};
        
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(k => k.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.85)',  // blue applied
                        'rgba(234, 179, 8, 0.85)',   // yellow pending_review
                        'rgba(99, 102, 241, 0.85)',  // indigo shortlisted
                        'rgba(168, 85, 247, 0.85)',  // purple interview
                        'rgba(236, 72, 153, 0.85)',  // pink offer
                        'rgba(16, 185, 129, 0.85)',  // emerald hired
                        'rgba(239, 68, 68, 0.85)'    // red rejected
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Thinner ring
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { 
                            boxWidth: 12,
                            padding: 20,
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        bodyFont: { weight: 'bold', size: 14 }
                    }
                }
            }
        });
    </script>
</x-app-layout>
