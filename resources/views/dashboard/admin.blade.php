<x-app-layout>
    <x-slot name="header">
        {{ __('Platform Admin Dashboard') }}
    </x-slot>

    <div class="space-y-8 animate-fade-in"
         x-data="{ 
            currentTab: 'overview',
            cmsPage: 'terms',
            cmsContent: 'Welcome to JOBZ IN CANADA. By accessing our platform, you agree to comply with our candidate recruitment policies...',
            saveCms() {
                alert('CMS draft successfully saved for: ' + this.cmsPage.toUpperCase());
            },
            coupons: [
                { code: 'CANADA150', discount: '15%', limit: 100, claims: 45, status: 'Active' },
                { code: 'STARTUP50', discount: '50%', limit: 50, claims: 50, status: 'Expired' }
            ],
            newCouponCode: '',
            newCouponDiscount: '',
            addCoupon() {
                if (this.newCouponCode.trim() && this.newCouponDiscount) {
                    this.coupons.push({
                        code: this.newCouponCode.toUpperCase().trim(),
                        discount: this.newCouponDiscount,
                        limit: 100,
                        claims: 0,
                        status: 'Active'
                    });
                    this.newCouponCode = '';
                    this.newCouponDiscount = '';
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
        <x-card variant="gradient" color="rose" padding="lg" class="relative overflow-hidden shadow-xl border-0">
            <div class="relative z-10 md:flex md:items-center md:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                        Platform Control Center
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white">Platform Management Console</h1>
                    <p class="text-rose-100 max-w-xl text-sm leading-relaxed">
                        Review companies verification requests, moderate active jobs listings, manage reported contents, handle user status suspension, update categories and broadcast messages.
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Tab Navigation Links -->
        <div class="tab-bar no-print">
            <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'tab-btn active' : 'tab-btn'">System Overview</button>
            <button @click="currentTab = 'cms'" :class="currentTab === 'cms' ? 'tab-btn active' : 'tab-btn'">CMS &amp; Pages</button>
            <button @click="currentTab = 'media'" :class="currentTab === 'media' ? 'tab-btn active' : 'tab-btn'">Media Library</button>
            <button @click="currentTab = 'payments'" :class="currentTab === 'payments' ? 'tab-btn active' : 'tab-btn'">Coupons &amp; Pricing</button>
        </div>

        <!-- 1. SYSTEM OVERVIEW TAB -->
        <div x-show="currentTab === 'overview'" class="space-y-8" x-transition>
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                <x-card variant="stat" label="Total Users" value="{{ $metrics['total_users'] }}" color="rose" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Companies" value="{{ $metrics['companies_count'] }}" color="blue" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Active Jobs" value="{{ $metrics['active_jobs'] }}" color="amber" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Pending Reports" value="{{ $metrics['reports_count'] }}" color="rose" padding="sm">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Two Column Layout: Main Actions Navigation & Recent Audits -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Actions Dashboard Grid -->
                <div class="lg:col-span-2">
                    <x-card variant="default">
                        <x-slot name="header">Administrative Sub-Panels</x-slot>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">👥</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">User Management</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Suspend, activate, reset user credentials.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.companies.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">🏢</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Company Verifications</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Approve, reject, or verify employer accounts.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.jobs.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">💼</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Listing Moderations</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Feature, mark urgent, approve, or hide postings.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">⚠️</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Abuse Moderation Queue</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Investigate duplicate listings, spam, scam reports.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.categories.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">📁</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Master Categories</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Add, edit, or delete parent/child fields.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.skills.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">🛠️</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Skills Mapping</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Merge duplicate skills, manage master list.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reviews.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">💬</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Review Moderations</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Approve, hide, or moderate company reviews.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.announcements.index') }}" class="p-5 bg-gray-50 dark:bg-gray-800/40 hover:border-rose-500/30 rounded-2xl border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                <span class="text-2xl">📢</span>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Announcements Broadcast</h4>
                                    <p class="text-4xs text-gray-500 mt-1">Send alerts broadcast notifications to all users.</p>
                                </div>
                            </a>
                        </div>
                    </x-card>
                </div>

                <!-- Right Column: Recent Audits Activity -->
                <div class="space-y-6">
                    <x-card variant="default">
                        <x-slot name="header">
                            <div class="flex justify-between items-center w-full">
                                <span>System Audit Log</span>
                                <a href="{{ route('admin.audit-logs.index') }}" class="text-xs font-bold text-primary-500 hover:underline">View All</a>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            @forelse($recentAudits as $log)
                                @if(is_object($log) && isset($log->action))
                                    <div class="border-s-2 border-rose-500 ps-3 py-0.5 space-y-0.5">
                                        <p class="text-xs font-bold text-gray-900 dark:text-white uppercase leading-none">{{ str_replace('_', ' ', $log->action) }}</p>
                                        <p class="text-4xs text-gray-500 dark:text-gray-450 leading-relaxed mt-1">{{ $log->description }}</p>
                                        <span class="text-4xs text-gray-400 block pt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                @elseif(is_string($log))
                                    <div class="border-s-2 border-gray-300 ps-3 py-0.5">
                                        <p class="text-xs text-gray-750 dark:text-gray-300">{{ $log }}</p>
                                    </div>
                                @endif
                            @empty
                                <p class="text-xs text-gray-400 italic py-2">No audit records found.</p>
                            @endforelse
                        </div>
                    </x-card>
                </div>
            </div>
        </div>

        <!-- 2. CMS & PAGES TAB -->
        <div x-show="currentTab === 'cms'" x-transition style="display: none;">
            <x-card variant="default">
                <x-slot name="header">
                    <div class="flex justify-between items-center w-full">
                        <span>Page Contents Moderation (CMS)</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Page:</span>
                            <select x-model="cmsPage" class="text-xs py-1.5 min-w-[150px]">
                                <option value="terms">Terms of Service</option>
                                <option value="privacy">Privacy Policy</option>
                                <option value="about">About Us</option>
                                <option value="faq">FAQ Listing</option>
                            </select>
                        </div>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Editor Console</label>
                        <textarea rows="8" x-model="cmsContent" class="w-full"></textarea>
                    </div>
                    
                    <button type="button" @click="saveCms()" class="btn btn-primary">
                        Publish Updates
                    </button>
                </div>
            </x-card>
        </div>

        <!-- 3. MEDIA LIBRARY TAB -->
        <div x-show="currentTab === 'media'" x-transition style="display: none;">
            <x-card variant="default">
                <x-slot name="header">Assets &amp; Media Directory</x-slot>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-2xl border border-gray-100 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">📄</div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-xs truncate text-gray-900 dark:text-white">maaz_resume_2026.pdf</h4>
                            <p class="text-4xs text-gray-400">PDF &bull; 412 KB</p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-2xl border border-gray-100 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">🖼️</div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-xs truncate text-gray-900 dark:text-white">company_cover_default.jpg</h4>
                            <p class="text-4xs text-gray-400">JPEG &bull; 1.2 MB</p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-2xl border border-gray-100 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">🏢</div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-xs truncate text-gray-900 dark:text-white">techcorp_logo.png</h4>
                            <p class="text-4xs text-gray-400">PNG &bull; 95 KB</p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 4. COUPONS & PRICING TAB -->
        <div x-show="currentTab === 'payments'" class="space-y-6" x-transition style="display: none;">
            
            <!-- Coupon Builder -->
            <x-card variant="default">
                <x-slot name="header">Active Promo Coupons</x-slot>
                
                <div class="flex flex-wrap gap-3 items-end border-b border-gray-100 dark:border-gray-850 pb-5">
                    <div>
                        <label class="block text-4xs font-bold text-gray-400 uppercase tracking-wider mb-2">Coupon Code</label>
                        <input type="text" x-model="newCouponCode" placeholder="e.g. HALIFAX20" class="uppercase text-xs" />
                    </div>
                    <div>
                        <label class="block text-4xs font-bold text-gray-400 uppercase tracking-wider mb-2">Discount %</label>
                        <input type="text" x-model="newCouponDiscount" placeholder="e.g. 20%" class="text-xs" />
                    </div>
                    <button type="button" @click="addCoupon()" class="btn btn-primary">
                        Create Coupon
                    </button>
                </div>

                <div class="overflow-x-auto -mx-6 pt-2">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Coupon Code</th>
                                <th>Discount</th>
                                <th>Claims Limit</th>
                                <th>Total Claims</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(coupon, i) in coupons" :key="i">
                                <tr>
                                    <td class="font-mono font-bold" x-text="coupon.code"></td>
                                    <td class="text-primary-500 font-bold" x-text="coupon.discount"></td>
                                    <td x-text="coupon.limit"></td>
                                    <td x-text="coupon.claims"></td>
                                    <td>
                                        <span :class="coupon.status === 'Active' ? 'status-badge status-active' : 'status-badge status-draft'" 
                                              x-text="coupon.status"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Revenue details -->
            <x-card variant="default">
                <x-slot name="header">
                    <div class="flex justify-between items-center w-full">
                        <span>Revenue Analytics Breakdown</span>
                        <a href="{{ route('admin.revenue-analytics.index') }}" class="text-xs font-bold text-primary-500 hover:underline">Full Analytics Page</a>
                    </div>
                </x-slot>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-450 uppercase tracking-wider block">Total Subscription Earnings</span>
                        <p class="text-xl font-black mt-1 text-emerald-500">$24,850 CAD</p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-800">
                        <span class="text-4xs font-bold text-gray-455 uppercase tracking-wider block">Active Paid Corporate Subscriptions</span>
                        <p class="text-xl font-black mt-1 text-primary-500">182 Active Plans</p>
                    </div>
                </div>
            </x-card>
        </div>

    </div>
</x-app-layout>
