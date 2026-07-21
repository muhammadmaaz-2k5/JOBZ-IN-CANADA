<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Recruitment Console') }}
            </h2>
            <span>
                🏢 Company: {{ $employerProfile->company->company_name ?? 'Not Assigned' }}
            </span>
        </div>
    </x-slot>

    <div 
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
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header banner -->
        <x-card variant="gradient" color="green" padding="lg">
            <div>
                <div>
                    <span>
                        Employer Dashboard
                    </span>
                    <h1>Recruit Top Talents</h1>
                    <p>
                        Create job postings, manage incoming applications, move candidates along hiring pipeline swimlanes, and view performance insights.
                    </p>
                </div>
                <div>
                    <a href="{{ route('employer.jobs.create') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Post New Job
                    </a>
                    <a href="{{ route('employer.applicants.pipeline.all') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                        ATS Pipeline Board
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Tab Navigation Links -->
        <div>
            <button @click="currentTab = 'overview'" :>Overview</button>
            <button @click="currentTab = 'analytics'" :>Analytics Insights</button>
            <button @click="currentTab = 'scheduler'" :>Interview Schedule</button>
            <button @click="currentTab = 'messages'" :>Messages Inbox</button>
            <button @click="currentTab = 'billing'" :>Plans &amp; Billing</button>
        </div>

        <!-- 1. OVERVIEW TAB -->
        <div x-show="currentTab === 'overview'" x-transition>
            <!-- Stats Grid -->
            <div>
                <x-card variant="stat" label="Active Postings" value="{{ $metrics['active_jobs'] }}" color="green" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.008v.008H12V12zm0 0h.008v.008H12V12z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Total Applications" value="{{ $metrics['total_applications'] }}" color="blue" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Scheduled Interviews" value="{{ $metrics['interviews_scheduled'] }}" color="amber" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Candidates Hired" value="{{ $metrics['candidates_hired'] }}" color="purple" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Charts & Analytics Section -->
            <div>
                <x-card variant="default">
                    <x-slot name="header">Applications Over Time (Last 4 Weeks)</x-slot>
                    <div>
                        <canvas id="applicationsLineChart"></canvas>
                    </div>
                </x-card>

                <x-card variant="default">
                    <x-slot name="header">Applications Status</x-slot>
                    <div>
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </x-card>
            </div>

            <div>
                <!-- Recent Applications -->
                <div>
                    <x-card variant="default">
                        <x-slot name="header">
                            <div>
                                <span>Recent Incoming Applications</span>
                                <a href="{{ route('employer.applicants.index') }}">View All</a>
                            </div>
                        </x-slot>

                        <div>
                            @forelse($recentApplications as $app)
                                <div>
                                    <div>
                                        <div>
                                            {{ substr($app->applicant->first_name,0,1) }}{{ substr($app->applicant->last_name,0,1) }}
                                        </div>
                                        <div>
                                            <h4>
                                                <a href="{{ route('employer.applicants.show', $app->id) }}">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</a>
                                            </h4>
                                            <p>
                                                <span>{{ $app->job->title }}</span> &bull; 
                                                <span>Applied {{ $app->applied_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <span>
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                        <a href="{{ route('employer.applicants.show', $app->id) }}">Review</a>
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
                            <div>
                                <span>Active Postings Performance</span>
                                <a href="{{ route('employer.jobs.index') }}">Manage Jobs</a>
                            </div>
                        </x-slot>
                        
                        <div>
                            <table>
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
                                            <td>{{ $perf->title }}</td>
                                            <td>{{ $perf->views_count }}</td>
                                            <td>{{ $perf->applications_count }}</td>
                                            <td>{{ $perf->saved_by_users_count }}</td>
                                            <td>
                                                {{ $perf->views_count > 0 ? round(($perf->applications_count / $perf->views_count) * 100, 1) : 0 }}%
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No job postings created.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </x-card>
                </div>

                <!-- Right Column Sidebar -->
                <div>
                    <x-card variant="default">
                        <x-slot name="header">Company Reputation</x-slot>
                        <div>
                            <div>
                                <p>{{ number_format($averageRating, 1) }}</p>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p>Based on {{ $reviewsCount }} reviews</p>
                            </div>
                            <div>
                                <div>
                                    <p>{{ $metrics['followers_count'] }}</p>
                                    <p>Followers</p>
                                </div>
                                <div>
                                    <p>{{ $metrics['total_views'] }}</p>
                                    <p>Total Views</p>
                                </div>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>

        <!-- 2. ANALYTICS INSIGHTS TAB -->
        <div x-show="currentTab === 'analytics'" x-transition>
            <div>
                <x-card variant="default">
                    <span>Hiring Conversion Rate</span>
                    <p>8.5%</p>
                    <p>Conversions from initial view to hired status</p>
                </x-card>
                <x-card variant="default">
                    <span>Average Time-to-Hire</span>
                    <p>18 Days</p>
                    <p>Average pipeline progression duration</p>
                </x-card>
                <x-card variant="default">
                    <span>Offer Acceptance</span>
                    <p>92%</p>
                    <p>Percentage of candidate job acceptances</p>
                </x-card>
            </div>

            <x-card variant="default">
                <x-slot name="header">Detailed Channel Insights</x-slot>
                <div>
                    <div>
                        <span>Total Views</span>
                        <p>1,480</p>
                    </div>
                    <div>
                        <span>Applications</span>
                        <p>125</p>
                    </div>
                    <div>
                        <span>Interviews</span>
                        <p>15</p>
                    </div>
                    <div>
                        <span>Offers Issued</span>
                        <p>4</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 3. INTERVIEW SCHEDULER TAB -->
        <div x-show="currentTab === 'scheduler'" x-transition>
            <!-- Calendar layout -->
            <x-card variant="default">
                <x-slot name="header">July 2026 Calendar</x-slot>
                <div>
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div>
                    @for($i = 1; $i <= 3; $i++) <div></div> @endfor
                    @for($day = 1; $day <= 31; $day++)
                        <div>
                            {{ $day }}
                            @if($day === 20 || $day === 22)
                                <span></span>
                            @endif
                        </div>
                    @endfor
                </div>
            </x-card>

            <!-- Agenda Sidebar -->
            <x-card variant="default">
                <x-slot name="header">Upcoming Interviews</x-slot>
                
                <div>
                    <div>
                        <div>
                            <span>July 20, 10:00 AM</span>
                            <span>Confirmed</span>
                        </div>
                        <p>Candidate: Muhammad Maaz</p>
                        <p>Role: Senior Full-Stack Architect</p>
                        <p>Channel: Google Meet Video Room</p>
                    </div>

                    <div>
                        <div>
                            <span>July 22, 02:00 PM</span>
                            <span>Pending</span>
                        </div>
                        <p>Candidate: Jane Doe</p>
                        <p>Role: Lead UX/UI designer</p>
                        <p>Channel: Local Office Interview</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 4. CHAT MESSAGES TAB -->
        <div x-show="currentTab === 'messages'" x-transition>
            <!-- Chat candidate sidebar -->
            <div>
                <div>Candidate Chats</div>
                <div>
                    <button @click="chatUser = 'Muhammad Maaz'" :>
                        <div>MM</div>
                        <div>
                            <h4>Muhammad Maaz</h4>
                            <p>Senior Architect candidate</p>
                        </div>
                    </button>
                    <button @click="chatUser = 'Jane Doe'" :>
                        <div>JD</div>
                        <div>
                            <h4>Jane Doe</h4>
                            <p>Lead UX designer</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Chat message dialogue pane -->
            <div>
                <!-- Dialogue header -->
                <div>
                    <div>
                        <h4 x-text="chatUser"></h4>
                        <p>
                            <span></span> 
                            <span>Online &bull; Candidate</span>
                        </p>
                    </div>
                </div>

                <!-- Conversation bubble display -->
                <div>
                    <template x-for="(msg, i) in messagesList" :key="i">
                        <div :>
                            <div 
                                 :>
                                <p x-text="msg.text"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Send input area -->
                <div>
                    <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type a message to candidate..." />
                    <button type="button" @click="sendMsg()">
                        Send
                    </button>
                </div>
            </div>
        </div>

        <!-- 5. PLANS & BILLING TAB -->
        <div x-show="currentTab === 'billing'" x-transition>
            <!-- Plan summary -->
            <x-card variant="gradient" color="blue" padding="lg">
                <div>
                    <div>
                        <span>Active Membership</span>
                        <h3>Premium Corporate Plan</h3>
                        <p>Provides access to candidate database search, verified status, and unlimited postings. Renewal Date: August 31, 2026</p>
                    </div>
                    <span>$129 CAD <span>/ mo</span></span>
                </div>
            </x-card>

            <!-- Plans upgrade cards list -->
            <div>
                <!-- Starter card -->
                <x-card variant="default">
                    <div>
                        <h4>Basic Starter</h4>
                        <p>For single hirers posting role requirements.</p>
                        <p>$49<span> CAD/mo</span></p>
                        <ul>
                            <li>✓ Post up to 3 jobs</li>
                            <li>✓ Standard placement status</li>
                            <li>✓ Email candidate notifications</li>
                        </ul>
                    </div>
                    <button type="button">Downgrade</button>
                </x-card>

                <!-- Premium card -->
                <div>
                    <span>Current Plan</span>
                    <div>
                        <h4>Premium Corporate</h4>
                        <p>Complete candidates screen pipeline access.</p>
                        <p>$129<span> CAD/mo</span></p>
                        <ul>
                            <li>✓ Unlimited job listings</li>
                            <li>✓ Candidate search filters</li>
                            <li>✓ Verified employer badge logo</li>
                            <li>✓ Analytics tracking tools</li>
                        </ul>
                    </div>
                    <button type="button" disabled>Active</button>
                </div>

                <!-- Enterprise card -->
                <x-card variant="default">
                    <div>
                        <h4>Enterprise Scaler</h4>
                        <p>Custom agency candidate listings panel.</p>
                        <p>$299<span> CAD/mo</span></p>
                        <ul>
                            <li>✓ Unlimited corporate channels</li>
                            <li>✓ API automated postings</li>
                            <li>✓ Dedicated support manager</li>
                            <li>✓ AI recruiter screener tool</li>
                        </ul>
                    </div>
                    <button type="button">Upgrade Plan</button>
                </x-card>
            </div>

            <!-- Transaction Invoices List -->
            <x-card variant="default">
                <x-slot name="header">Billing History Invoices</x-slot>
                
                <div>
                    <table>
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
                                <td>INV-26901-89</td>
                                <td>$129.00 CAD</td>
                                <td>Monthly Membership Renew</td>
                                <td><span>Paid</span></td>
                            </tr>
                            <tr>
                                <td>June 01, 2026</td>
                                <td>INV-26901-44</td>
                                <td>$129.00 CAD</td>
                                <td>Monthly Membership Renew</td>
                                <td><span>Paid</span></td>
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
