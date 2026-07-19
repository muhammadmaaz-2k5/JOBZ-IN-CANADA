<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Platform Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen"
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-red-650 to-rose-500 rounded-3xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                <div class="md:flex md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">Platform Management Console</h1>
                        <p class="mt-2 text-red-100 max-w-xl text-sm">Review companies verification requests, moderate active jobs listings, manage reported contents, handle user status suspension, update categories and broadcast messages.</p>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation Links -->
            <div class="flex flex-wrap gap-6 border-b border-gray-250 dark:border-gray-800 pb-2 text-sm font-bold text-gray-500 dark:text-gray-400 no-print">
                <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">System Overview</button>
                <button @click="currentTab = 'cms'" :class="currentTab === 'cms' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">CMS & Pages</button>
                <button @click="currentTab = 'media'" :class="currentTab === 'media' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Media Library</button>
                <button @click="currentTab = 'payments'" :class="currentTab === 'payments' ? 'text-primary-500 border-b-2 border-primary-500 pb-2' : 'hover:text-gray-900 dark:hover:text-white pb-2'" class="transition cursor-pointer">Coupons & Pricing</button>
            </div>

            <!-- 1. SYSTEM OVERVIEW TAB -->
            <div x-show="currentTab === 'overview'" class="space-y-8" x-transition>
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-red-50 dark:bg-red-950/30 text-red-650 dark:text-red-400 rounded-xl text-lg">
                            👥
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['total_users'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Total Users</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 rounded-xl text-lg">
                            🏢
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['companies_count'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Companies</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 rounded-xl text-lg">
                            💼
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['active_jobs'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Active Jobs</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 flex items-center gap-3">
                        <div class="p-2.5 bg-rose-50 dark:bg-rose-950/30 text-rose-650 dark:text-rose-400 rounded-xl text-lg">
                            ⚠️
                        </div>
                        <div>
                            <div class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $metrics['reports_count'] }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase">Pending Reports</div>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout: Main Actions Navigation & Recent Audits -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Actions Dashboard Grid -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 space-y-4">
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-50 dark:border-gray-700">Administrative Sub-Panels</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('admin.users.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">👥</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">User Management</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Suspend, activate, reset user credentials.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.companies.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">🏢</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Company Verifications</h4>
                                        <p class="text-[10px] text-gray-455 font-semibold mt-0.5">Approve, reject, or verify employer accounts.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.jobs.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">💼</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Listing Moderations</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Feature, mark urgent, approve, or hide postings.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.reports.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">⚠️</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Abuse Moderation Queue</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Investigate duplicate listings, spam, scam reports.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.categories.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">📁</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Master Categories</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Add, edit, or delete parent/child fields.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.skills.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">🛠️</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Skills Mapping</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Merge duplicate skills, manage master list.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.reviews.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">💬</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Review Moderations</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Approve, hide, or moderate company reviews.</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.announcements.index') }}" class="p-5 bg-gray-50 dark:bg-gray-900 hover:bg-gray-105 dark:hover:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex items-center gap-4 transition duration-200">
                                    <span class="text-2xl">📢</span>
                                    <div>
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Announcements Broadcast</h4>
                                        <p class="text-[10px] text-gray-450 font-semibold mt-0.5">Send alerts broadcast notifications to all users.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Recent Audits Activity -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-150 dark:border-gray-700/50 p-6 space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-50 dark:border-gray-700">
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">System Audit Log</h3>
                                <a href="{{ route('admin.audit-logs.index') }}" class="text-xs font-bold text-primary-500 hover:underline">View All</a>
                            </div>

                            <div class="space-y-4">
                                @forelse($recentAudits as $log)
                                    <div class="border-l-2 border-red-500 ps-3 py-0.5 space-y-0.5">
                                        <p class="text-xs font-bold text-gray-900 dark:text-white uppercase">{{ str_replace('_', ' ', $log->action) }}</p>
                                        <p class="text-[10px] text-gray-500 font-medium leading-relaxed">{{ $log->description }}</p>
                                        <span class="text-[9px] text-gray-400 block">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">No audit records found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. CMS & PAGES TAB -->
            <div x-show="currentTab === 'cms'" class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-6" x-transition style="display: none;">
                <div class="flex justify-between items-center pb-2 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">Page Contents Moderation (CMS)</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-400">Page:</span>
                        <select x-model="cmsPage" class="px-2 py-1 bg-gray-50 dark:bg-dark-850 rounded border border-gray-250 text-xs font-bold focus:outline-none">
                            <option value="terms">Terms of Service</option>
                            <option value="privacy">Privacy Policy</option>
                            <option value="about">About Us</option>
                            <option value="faq">FAQ Listing</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-1">Editor Console</label>
                        <textarea rows="8" x-model="cmsContent" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-750 bg-white dark:bg-dark-850 text-sm leading-relaxed focus:outline-none"></textarea>
                    </div>
                    
                    <button type="button" @click="saveCms()" class="px-5 py-2.5 bg-primary-500 text-white rounded-xl text-xs font-bold hover:bg-primary-600 transition cursor-pointer">
                        Publish Updates
                    </button>
                </div>
            </div>

            <!-- 3. MEDIA LIBRARY TAB -->
            <div x-show="currentTab === 'media'" class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4" x-transition style="display: none;">
                <h3 class="font-bold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750">Assets & Media Directory</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-3 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">📄</div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs truncate">maaz_resume_2026.pdf</h4>
                            <p class="text-[9px] text-gray-400">PDF &bull; 412 KB</p>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">🖼️</div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs truncate">company_cover_default.jpg</h4>
                            <p class="text-[9px] text-gray-400">JPEG &bull; 1.2 MB</p>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-dark-850 rounded-2xl border border-gray-150 dark:border-gray-800 flex flex-col justify-between h-40">
                        <div class="text-3xl text-center py-2">🏢</div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs truncate">techcorp_logo.png</h4>
                            <p class="text-[9px] text-gray-400">PNG &bull; 95 KB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. COUPONS & PRICING TAB -->
            <div x-show="currentTab === 'payments'" class="space-y-6" x-transition style="display: none;">
                
                <!-- Coupon Builder -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750">Active Promo Coupons</h3>
                    
                    <div class="flex flex-wrap gap-3 items-end">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-450 uppercase mb-1">Coupon Code</label>
                            <input type="text" x-model="newCouponCode" placeholder="e.g. HALIFAX20" class="px-3 py-1.5 rounded border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs font-bold focus:outline-none uppercase" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-455 uppercase mb-1">Discount %</label>
                            <input type="text" x-model="newCouponDiscount" placeholder="e.g. 20%" class="px-3 py-1.5 rounded border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-800 text-xs font-bold focus:outline-none" />
                        </div>
                        <button type="button" @click="addCoupon()" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded text-xs font-bold transition cursor-pointer">
                            + Create Coupon
                        </button>
                    </div>

                    <div class="overflow-x-auto pt-4">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 text-[10px] font-extrabold uppercase text-gray-400 border-b border-gray-100 dark:border-gray-850">
                                    <th class="p-3">Coupon Code</th>
                                    <th class="p-3">Discount</th>
                                    <th class="p-3">Claims Limit</th>
                                    <th class="p-3">Total Claims</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-600 dark:text-gray-300 font-semibold">
                                <template x-for="(coupon, i) in coupons" :key="i">
                                    <tr>
                                        <td class="p-3 font-mono font-bold" x-text="coupon.code"></td>
                                        <td class="p-3 text-primary-500" x-text="coupon.discount"></td>
                                        <td class="p-3" x-text="coupon.limit"></td>
                                        <td class="p-3" x-text="coupon.claims"></td>
                                        <td class="p-3">
                                            <span :class="coupon.status === 'Active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-400' : 'bg-gray-100 text-gray-800 dark:bg-dark-800 dark:text-gray-500'" 
                                                  class="px-2 py-0.5 rounded text-[10px] font-bold" 
                                                  x-text="coupon.status"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Revenue details -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-base text-gray-900 dark:text-white">Revenue Analytics Breakdown</h3>
                        <a href="{{ route('admin.revenue-analytics') }}" class="text-xs font-bold text-primary-500 hover:underline">Full Analytics Page</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Total Subscription Earnings</span>
                            <p class="text-lg font-black mt-0.5 text-emerald-500">$24,850 CAD</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-xl">
                            <span class="text-[10px] font-bold text-gray-400">Active Paid Corporate Subscriptions</span>
                            <p class="text-lg font-black mt-0.5 text-primary-500">182 Active Plans</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
