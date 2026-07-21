<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore Opportunities - JOBZ IN CANADA</title>
    <!-- Fonts -->
    
    
    
    <!-- Scripts & Styles -->
    
</head>
<body>

    <!-- Premium Glow Background Elements -->
    <div></div>
    <div></div>

    <!-- Header Navbar (Homepage Style) -->
    <header>
        <div>
            <!-- Brand Logo -->
            <a href="/">
                <div>
                    <span>J</span>
                </div>
                <span>JOBZ IN <span>CANADA</span></span>
            </a>

            <!-- Nav Links -->
            <nav>
                <a href="{{ route('home') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('jobs.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Companies
                </a>
            </nav>

            <!-- Actions Panel -->
            <div>
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Top Hero and Search Hub Section -->
    <div>
        <div></div>

        <div>
            <!-- Alert Badge -->
            <span>
                🍁 Explore active listings across Canada
            </span>

            <h1>
                Find Your <span>Dream Career</span>
            </h1>
            <p>
                Connect with verified employers offering full-time, remote, and hybrid roles. Apply in seconds with our unified wizard.
            </p>

            <!-- Search Console Form -->
            <div
                 x-data="{ 
                     keyword: '{{ request('keyword') }}', 
                     suggestions: [], 
                     showSuggestions: false,
                     fetchSuggestions() {
                          if (this.keyword.length < 2) {
                              this.suggestions = [];
                              return;
                          }
                          fetch('/api/jobs/suggestions?query=' + encodeURIComponent(this.keyword))
                              .then(res => res.json())
                              .then(data => {
                                  this.suggestions = data;
                              });
                     }
                 }">
                <form method="GET" action="{{ route('jobs.index') }}">
                    
                    <!-- Keyword input -->
                    <div>
                        <span>🔍</span>
                        <input id="keyword" name="keyword" type="text" 
                                x-model="keyword"
                                @input.debounce.300ms="fetchSuggestions()"
                                @focus="showSuggestions = true"
                                @click.away="setTimeout(() => showSuggestions = false, 200)" 
                                placeholder="Job title, keywords, or company..." />

                        <!-- Suggestions Dropdown -->
                        <div x-show="showSuggestions && suggestions.length > 0"
                             x-transition>
                            <template x-for="item in suggestions">
                                <button type="button" 
                                        @click="keyword = item.text; showSuggestions = false; $el.closest('form').submit()">
                                    <span x-text="item.text"></span>
                                    <span x-text="item.type.replace('_', ' ')"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Location input -->
                    <div>
                        <span>📍</span>
                        <input id="location" name="location" type="text" 
                               placeholder="City, province, or 'Remote'..." 
                               value="{{ request('location') }}" />
                    </div>

                    <!-- Sort Options & Submit -->
                    <div>
                        <div>
                            <span>Sort:</span>
                            <select id="sort" name="sort">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest</option>
                                <option value="salary_desc" @selected(request('sort') == 'salary_desc')>Highest Salary</option>
                                <option value="salary_asc" @selected(request('sort') == 'salary_asc')>Lowest Salary</option>
                                <option value="closing_soon" @selected(request('sort') == 'closing_soon')>Closing Soon</option>
                            </select>
                        </div>
                        
                        <button type="submit">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Searches history chips -->
            @if(session()->has('recent_searches') && count(session('recent_searches')) > 0)
                <div>
                    <span>Recent Searches:</span>
                    @foreach(session('recent_searches') as $search)
                        <a href="{{ $search['url'] }}">
                            "{{ $search['keyword'] }}" {{ $search['location'] ? 'in ' . $search['location'] : '' }}
                        </a>
                    @endforeach
                    <form method="POST" action="{{ route('jobs.history.clear-search') }}">
                        @csrf
                        <button type="submit">Clear History</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Listings Section -->
    <div>
        <div>

            <!-- Recently Viewed horizontally -->
            @if(count($recentlyViewed) > 0)
                <x-card variant="glass">
                    <div>
                        <div>
                            <span>🕒</span>
                            <h4>Recently Viewed Listings</h4>
                        </div>
                        <form method="POST" action="{{ route('jobs.history.clear-viewed') }}">
                            @csrf
                            <button type="submit">Clear history</button>
                        </form>
                    </div>
                    <div>
                        @foreach($recentlyViewed as $viewedJob)
                            <div>
                                <a href="{{ route('jobs.show', $viewedJob->slug) }}">{{ $viewedJob->title }}</a>
                                <p>{{ $viewedJob->company->company_name }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif

            <!-- Job listings grid cards -->
            <div>
                @forelse($jobs as $job)
                    <x-card variant="default">
                        @if($job->featured)
                            <div>
                                Featured
                            </div>
                        @endif

                        <div>
                            <div>
                                <!-- Company Logo wrapper -->
                                @php
                                    $initials = strtoupper(substr($job->company->company_name, 0, 2));
                                    $bgColors = [
                                        'Shopify Canada' => 'bg-blue-600',
                                        'TechNorth Solutions' => 'bg-teal-600',
                                        'Maple Finance Group' => 'bg-amber-700',
                                        'Northern Health Systems' => 'bg-emerald-600',
                                        'CanBridge Engineering' => 'bg-indigo-650',
                                    ];
                                    $bgClass = $bgColors[$job->company->company_name] ?? 'bg-primary-600';
                                @endphp
                                <div>
                                    @if($job->company->logo)
                                        <img src="{{ $job->company->logo }}" alt="Logo" />
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                
                                <div>
                                    <div>
                                        <h4>
                                            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                        </h4>
                                        @if($job->urgent)
                                            <span>Urgent</span>
                                        @endif
                                        @if($job->screeningQuestions->count() === 0)
                                            <span>⚡ Easy Apply</span>
                                        @endif
                                    </div>
                                    
                                    <p>
                                        {{ $job->company->company_name }}
                                        @if($job->company->verification_status === 'verified')
                                            <span title="Verified Employer">✓</span>
                                        @endif
                                    </p>
                                    
                                    <div>
                                        <span>📍 {{ $job->city }}, {{ $job->country }}</span>
                                        <span>&bull;</span>
                                        <span>💼 {{ ucfirst($job->workplace_type) }}</span>
                                        <span>&bull;</span>
                                        <span>⏰ {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}</span>
                                    </div>
                                    
                                    <!-- Display Salary if Visible -->
                                    @if($job->salary_min || $job->salary_max)
                                        <div>
                                            💵 {{ $job->currency }} 
                                            @if($job->salary_min && $job->salary_max)
                                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                            @elseif($job->salary_min)
                                                {{ number_format($job->salary_min) }}
                                            @endif
                                            / {{ ucfirst($job->salary_type ?? 'yearly') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('jobs.show', $job->slug) }}">
                                    View details
                                </a>
                            </div>
                        </div>
                    </x-card>
                @empty
                    <x-empty-state title="No Job Listings Found" subtitle="Try clearing search inputs, broadening keyword terms, or selecting different locations." icon="🔍" />
                @endforelse
            </div>

            <!-- Pagination -->
            <div>
                {{ $jobs->links() }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div>
            <p>© {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div>
                <a href="#">Terms of Service</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>
