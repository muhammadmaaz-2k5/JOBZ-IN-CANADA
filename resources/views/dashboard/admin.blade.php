<x-app-layout>
    <x-slot name="header">
        {{ __('Platform Admin Dashboard') }}
    </x-slot>

    <div
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
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Welcome Header banner -->
        <x-card variant="gradient" color="rose" padding="lg">
            <div>
                <div>
                    <span>
                        Platform Control Center
                    </span>
                    <h1>Platform Management Console</h1>
                    <p>
                        Review companies verification requests, moderate active jobs listings, manage reported contents, handle user status suspension, update categories and broadcast messages.
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Tab Navigation Links -->
        <div>
            <button @click="currentTab = 'overview'" :>System Overview</button>
            <button @click="currentTab = 'cms'" :>CMS &amp; Pages</button>
            <button @click="currentTab = 'media'" :>Media Library</button>
            <button @click="currentTab = 'payments'" :>Coupons &amp; Pricing</button>
        </div>

        <!-- 1. SYSTEM OVERVIEW TAB -->
        <div x-show="currentTab === 'overview'" x-transition>
            <!-- Stats Grid -->
            <div>
                <x-card variant="stat" label="Total Users" value="{{ $metrics['total_users'] }}" color="rose" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Companies" value="{{ $metrics['companies_count'] }}" color="blue" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Active Jobs" value="{{ $metrics['active_jobs'] }}" color="amber" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                        </svg>
                    </x-slot>
                </x-card>

                <x-card variant="stat" label="Pending Reports" value="{{ $metrics['reports_count'] }}" color="rose" padding="sm">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Two Column Layout: Main Actions Navigation & Recent Audits -->
            <div>
                <!-- Left Column: Actions Dashboard Grid -->
                <div>
                    <x-card variant="default">
                        <x-slot name="header">Administrative Sub-Panels</x-slot>
                        
                        <div>
                            <a href="{{ route('admin.users.index') }}">
                                <span>👥</span>
                                <div>
                                    <h4>User Management</h4>
                                    <p>Suspend, activate, reset user credentials.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.companies.index') }}">
                                <span>🏢</span>
                                <div>
                                    <h4>Company Verifications</h4>
                                    <p>Approve, reject, or verify employer accounts.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.jobs.index') }}">
                                <span>💼</span>
                                <div>
                                    <h4>Listing Moderations</h4>
                                    <p>Feature, mark urgent, approve, or hide postings.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports.index') }}">
                                <span>⚠️</span>
                                <div>
                                    <h4>Abuse Moderation Queue</h4>
                                    <p>Investigate duplicate listings, spam, scam reports.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.categories.index') }}">
                                <span>📁</span>
                                <div>
                                    <h4>Master Categories</h4>
                                    <p>Add, edit, or delete parent/child fields.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.skills.index') }}">
                                <span>🛠️</span>
                                <div>
                                    <h4>Skills Mapping</h4>
                                    <p>Merge duplicate skills, manage master list.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reviews.index') }}">
                                <span>💬</span>
                                <div>
                                    <h4>Review Moderations</h4>
                                    <p>Approve, hide, or moderate company reviews.</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.announcements.index') }}">
                                <span>📢</span>
                                <div>
                                    <h4>Announcements Broadcast</h4>
                                    <p>Send alerts broadcast notifications to all users.</p>
                                </div>
                            </a>
                        </div>
                    </x-card>
                </div>

                <!-- Right Column: Recent Audits Activity -->
                <div>
                    <x-card variant="default">
                        <x-slot name="header">
                            <div>
                                <span>System Audit Log</span>
                                <a href="{{ route('admin.audit-logs.index') }}">View All</a>
                            </div>
                        </x-slot>

                        <div>
                            @forelse($recentAudits as $log)
                                @if(is_object($log) && isset($log->action))
                                    <div>
                                        <p>{{ str_replace('_', ' ', $log->action) }}</p>
                                        <p>{{ $log->description }}</p>
                                        <span>{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                @elseif(is_string($log))
                                    <div>
                                        <p>{{ $log }}</p>
                                    </div>
                                @endif
                            @empty
                                <p>No audit records found.</p>
                            @endforelse
                        </div>
                    </x-card>
                </div>
            </div>
        </div>

        <!-- 2. CMS & PAGES TAB -->
        <div x-show="currentTab === 'cms'" x-transition>
            <x-card variant="default">
                <x-slot name="header">
                    <div>
                        <span>Page Contents Moderation (CMS)</span>
                        <div>
                            <span>Page:</span>
                            <select x-model="cmsPage">
                                <option value="terms">Terms of Service</option>
                                <option value="privacy">Privacy Policy</option>
                                <option value="about">About Us</option>
                                <option value="faq">FAQ Listing</option>
                            </select>
                        </div>
                    </div>
                </x-slot>

                <div>
                    <div>
                        <label>Editor Console</label>
                        <textarea rows="8" x-model="cmsContent"></textarea>
                    </div>
                    
                    <button type="button" @click="saveCms()">
                        Publish Updates
                    </button>
                </div>
            </x-card>
        </div>

        <!-- 3. MEDIA LIBRARY TAB -->
        <div x-show="currentTab === 'media'" x-transition>
            <x-card variant="default">
                <x-slot name="header">Assets &amp; Media Directory</x-slot>
                
                <div>
                    <div>
                        <div>📄</div>
                        <div>
                            <h4>maaz_resume_2026.pdf</h4>
                            <p>PDF &bull; 412 KB</p>
                        </div>
                    </div>
                    <div>
                        <div>🖼️</div>
                        <div>
                            <h4>company_cover_default.jpg</h4>
                            <p>JPEG &bull; 1.2 MB</p>
                        </div>
                    </div>
                    <div>
                        <div>🏢</div>
                        <div>
                            <h4>techcorp_logo.png</h4>
                            <p>PNG &bull; 95 KB</p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- 4. COUPONS & PRICING TAB -->
        <div x-show="currentTab === 'payments'" x-transition>
            
            <!-- Coupon Builder -->
            <x-card variant="default">
                <x-slot name="header">Active Promo Coupons</x-slot>
                
                <div>
                    <div>
                        <label>Coupon Code</label>
                        <input type="text" x-model="newCouponCode" placeholder="e.g. HALIFAX20" />
                    </div>
                    <div>
                        <label>Discount %</label>
                        <input type="text" x-model="newCouponDiscount" placeholder="e.g. 20%" />
                    </div>
                    <button type="button" @click="addCoupon()">
                        Create Coupon
                    </button>
                </div>

                <div>
                    <table>
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
                                    <td x-text="coupon.code"></td>
                                    <td x-text="coupon.discount"></td>
                                    <td x-text="coupon.limit"></td>
                                    <td x-text="coupon.claims"></td>
                                    <td>
                                        <span : 
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
                    <div>
                        <span>Revenue Analytics Breakdown</span>
                        <a href="{{ route('admin.revenue-analytics.index') }}">Full Analytics Page</a>
                    </div>
                </x-slot>
                <div>
                    <div>
                        <span>Total Subscription Earnings</span>
                        <p>$24,850 CAD</p>
                    </div>
                    <div>
                        <span>Active Paid Corporate Subscriptions</span>
                        <p>182 Active Plans</p>
                    </div>
                </div>
            </x-card>
        </div>

    </div>
</x-app-layout>
