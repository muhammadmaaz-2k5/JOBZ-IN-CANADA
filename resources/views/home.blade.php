@php
    try {
        // Fetch featured jobs. If less than 3, fill with latest published jobs to complete 3 columns.
        $featuredJobs = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->where('featured', true)->latest()->take(3)->get();
        if ($featuredJobs->count() < 3) {
            $extraFeatured = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->where('featured', false)->latest()->take(3 - $featuredJobs->count())->get();
            $featuredJobs = $featuredJobs->concat($extraFeatured);
        }

        // Fetch recent jobs. If less than 6, loop fill to ensure a full 6-card grid on desktop.
        $recentJobs = \App\Models\Job::with(['company', 'skills'])->where('status', 'published')->latest()->take(6)->get();
        if ($recentJobs->count() > 0 && $recentJobs->count() < 6) {
            $needed = 6 - $recentJobs->count();
            for ($i = 0; $i < $needed; $i++) {
                $recentJobs->push($recentJobs[$i % $recentJobs->count()]);
            }
        }

        $companies = \App\Models\Company::with('jobs')->where('verification_status', 'verified')->latest()->take(5)->get();
        $jobsCount = \App\Models\Job::count();
    } catch (\Throwable $e) {
        $featuredJobs = collect();
        $recentJobs = collect();
        $companies = collect();
        $jobsCount = 0;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JOBZ IN CANADA - Find Your Dream Job</title>
    <!-- Fonts -->
    
    
    
    <!-- Scripts & Styles -->
    
</head>
<body>

    <!-- Premium Mesh and Blobs Background -->
    <div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Header Navbar (Expanded Height: 72px) -->
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
                <a href="{{ route('jobs.index') }}">
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}">
                    Companies
                </a>
                <a href="#">
                    Pricing
                </a>
                <a href="#">
                    Resources
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

                <!-- Post a Job ghost button -->
                <a href="{{ route('register.employer') }}">
                    Post a Job
                </a>

                @auth
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Search Section (Reduced padding height by 25%) -->
    <section>
        <div>
            <!-- Alert Badge -->
            <span>
                🇨🇦 Canada Wide Jobs &bull; {{ $jobsCount ?: '12,480' }} Active Roles
            </span>

            <h1>
                Find your dream job <br /> in <span>Canada</span>
            </h1>
            <p>
                Discover thousands of exciting opportunities from Canada's top employers. Transparent salaries, remote options, and one-click applications.
            </p>

            <!-- Search Panel (Expanded Height: 68px, Custom shadow-premium) -->
            <form action="{{ route('jobs.index') }}" method="GET">
                <!-- What Input -->
                <div>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="What job title, keywords or company...">
                </div>

                <!-- Where Input -->
                <div>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="text" name="location" placeholder="City, province or 'Remote'...">
                </div>

                <!-- Search Button -->
                <button type="submit">
                    Search
                </button>
            </form>

            <!-- Popular Category Tags & Dark Mode Slider -->
            <div>
                <div>
                    <span>Popular:</span>
                    @foreach(['Tech', 'Remote', 'Software Engineering', 'Healthcare', 'Finance', 'Software'] as $cat)
                        <a href="{{ route('jobs.index', ['category' => $cat]) }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
                
                <!-- Dark Mode Slider Indicator Card -->
                <div>
                    <span>Dark Mode</span>
                    <button @click="dark = !dark" type="button" :>
                        <span :></span>
                    </button>
                </div>
            </div>

            <!-- Quick Suggestions Underneath -->
            <div>
                <span>Try searching:</span>
                @foreach(['Developer', 'Designer', 'Remote', 'Toronto', 'Vancouver', 'AI', 'React', 'Python'] as $suggestion)
                    <a href="{{ route('jobs.index', ['search' => $suggestion]) }}">
                        {{ $suggestion }}
                    </a>
                    @if(!$loop->last) <span>&bull;</span> @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trusted By Logos Strip Section [NEW] -->
    <section>
        <div>
            <span>Trusted by top Canadian teams</span>
            <div>
                <span>Google</span>
                <span>Shopify</span>
                <span>amazon</span>
                <span>RBC Royal Bank</span>
                <span>TD Bank</span>
                <span>Microsoft</span>
            </div>
        </div>
    </section>

    <!-- Compact Connected Stats Strip (Smaller height, thin border, no shadow float) -->
    <section>
        <div>
            <div>
                <p>12,480+</p>
                <p>Jobs Posted</p>
            </div>
            <div>
                <p>3,200+</p>
                <p>Companies</p>
            </div>
            <div>
                <p>450k+</p>
                <p>Job Seekers</p>
            </div>
            <div>
                <p>8,000+</p>
                <p>Monthly Applies</p>
            </div>
        </div>
    </section>

    <!-- Browse by Category Section (Alternating bg, size: 170x85) -->
    <section>
        <div>
            <div>
                <h2>Browse by Category</h2>
                <p>Explore roles across top Canadian industries</p>
            </div>
            <a href="{{ route('jobs.index') }}">View All &rarr;</a>
        </div>

        <div>
            @php
                $cats = [
                    ['title' => 'Tech & Dev', 'icon' => '💻', 'count' => '1,420 jobs', 'val' => 'Software Development', 'bg' => 'bg-blue-50 dark:bg-blue-950/20 text-blue-500'],
                    ['title' => 'Healthcare', 'icon' => '🩺', 'count' => '850 jobs', 'val' => 'Healthcare', 'bg' => 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-500'],
                    ['title' => 'Finance', 'icon' => '💵', 'count' => '640 jobs', 'val' => 'Finance', 'bg' => 'bg-amber-50 dark:bg-amber-950/20 text-amber-500'],
                    ['title' => 'Marketing', 'icon' => '📣', 'count' => '420 jobs', 'val' => 'Marketing', 'bg' => 'bg-rose-50 dark:bg-rose-950/20 text-rose-500'],
                    ['title' => 'Construction', 'icon' => '🏗️', 'count' => '310 jobs', 'val' => 'Construction', 'bg' => 'bg-purple-50 dark:bg-purple-950/20 text-purple-500'],
                    ['title' => 'Remote', 'icon' => '🏠', 'count' => '980 jobs', 'val' => 'Remote', 'bg' => 'bg-indigo-50 dark:bg-indigo-950/20 text-indigo-500'],
                ];
            @endphp
            @foreach($cats as $c)
                <a href="{{ route('jobs.index', ['category' => $c['val']]) }}">
                    <div>
                        {{ $c['icon'] }}
                    </div>
                    <h3>{{ $c['title'] }}</h3>
                    <p>{{ $c['count'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Jobs Section (Alternating bg, premium padded cards) -->
    <section>
        <div>
            <div>
                <h2>⭐ Featured Jobs</h2>
                <p>Promoted opportunities from certified partners</p>
            </div>
            <!-- Slider navigation arrows -->
            <div>
                <button>
                    &larr;
                </button>
                <button>
                    &rarr;
                </button>
            </div>
        </div>

        <div>
            @foreach($featuredJobs as $job)
                @php
                    $initials = strtoupper(substr($job->company->company_name, 0, 2));
                    $bgColors = [
                        'Shopify Canada' => 'bg-blue-600',
                        'TechNorth Solutions' => 'bg-teal-605',
                        'Maple Finance Group' => 'bg-amber-705',
                        'Northern Health Systems' => 'bg-emerald-605',
                        'CanBridge Engineering' => 'bg-indigo-655',
                    ];
                    $bgClass = $bgColors[$job->company->company_name] ?? 'bg-primary-600';
                @endphp
                <x-card variant="default">
                    <div>
                        <!-- Top Row: Logo left, Title & Info right -->
                        <div>
                            <!-- Logo Box (Expanded) -->
                            <div>
                                @if($job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="Logo" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>

                            <div>
                                <!-- Badges Row (Filled Pills) -->
                                <div>
                                    @if($job->featured)
                                        <span>Featured</span>
                                    @endif
                                    @if($job->screeningQuestions->count() === 0)
                                        <span>Easy Apply</span>
                                    @endif
                                </div>
                                <h3>
                                    <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                </h3>
                                <p>
                                    {{ $job->company->company_name }}
                                    @if($job->company->verification_status === 'verified')
                                        <span>✓</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Job meta: location & type -->
                        <div>
                            <span>
                                📍 {{ $job->city }}, {{ $job->country }}
                            </span>
                            <span>&bull;</span>
                            <span>
                                💼 {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p>{{ $job->description }}</p>

                        <!-- Skill tags (Filled rounded-full pills) -->
                        <div>
                            @foreach($job->skills->take(3) as $skill)
                                <span>{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Footer: Salary (Stand out, green, 18px, bold) and Save buttons -->
                    <div>
                        <span>
                            @if($job->salary_min)
                                ${{ number_format($job->salary_min / 1000) }}K - ${{ number_format($job->salary_max / 1000) }}K
                            @else
                                Competitive
                            @endif
                        </span>
                        
                        <!-- Bookmark button -->
                        <button>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- Why Choose JOBZINCANADA Card (Padded: 80px / py-20, Custom Emojis) -->
    <section>
        <div>
            <div></div>
            <div></div>

            <div>
                <div>
                    <h2>Why choose JOBZINCANADA?</h2>
                    <p>Built with candidates and local employers in mind</p>
                </div>

                <div>
                    <div>
                        <div>✔️</div>
                        <h3>Verified Employers</h3>
                        <p>All job posts are double-checked for corporate credentials to avoid scams.</p>
                    </div>
                    <div>
                        <div>📍</div>
                        <h3>Canada-Wide Positions</h3>
                        <p>From remote positions to local roles in Toronto, Vancouver, and Montreal.</p>
                    </div>
                    <div>
                        <div>💵</div>
                        <h3>Salary Transparency</h3>
                        <p>Access details regarding annual packages and benefits before applying.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Employers Section (Logo, Name, Industry, Active Job Counts) -->
    <section>
        <div>
            <div>
                <h2>Top Employers</h2>
                <p>Partner brands actively recruiting talent in Canada</p>
            </div>
            <a href="{{ route('companies.index') }}">All Companies &rarr;</a>
        </div>

        <div>
            @foreach($companies as $company)
                @php
                    $initials = strtoupper(substr($company->company_name, 0, 2));
                    $bgColors = [
                        'Shopify Canada' => 'bg-blue-600',
                        'TechNorth Solutions' => 'bg-teal-600',
                        'Maple Finance Group' => 'bg-amber-700',
                        'Northern Health Systems' => 'bg-emerald-600',
                        'CanBridge Engineering' => 'bg-indigo-655',
                    ];
                    $bgClass = $bgColors[$company->company_name] ?? 'bg-primary-600';
                @endphp
                <a href="{{ route('companies.show', $company->slug) }}">
                    <div>
                        <div>
                            @if($company->logo)
                                    <img src="{{ $company->logo }}" alt="Logo" />
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <h3>{{ $company->company_name }}</h3>
                        <p>{{ $company->industry ?: 'Industry' }}</p>
                    </div>
                    <div>
                        {{ $company->jobs->count() }} Open Jobs &rarr;
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Testimonials Section [NEW] -->
    <section>
        <div>
            <span>Success Stories</span>
            <h2>Loved by thousands of Canadians</h2>
        </div>
        <div>
            <x-card variant="default">
                <div>
                    <div>★★★★★</div>
                    <p>"I was skeptical at first, but after uploading my resume here, I got matched with a remote role at Shopify and was hired within 8 days!"</p>
                </div>
                <div>
                    <div>SL</div>
                    <div>
                        <h4>Sarah Jenkins</h4>
                        <p>Frontend Developer</p>
                    </div>
                </div>
            </x-card>
            <x-card variant="default">
                <div>
                    <div>★★★★★</div>
                    <p>"This platform is a breath of fresh air. Every employer is verified, which saved me so much time avoiding spam posts. Highly recommend."</p>
                </div>
                <div>
                    <div>MA</div>
                     <div>
                        <h4>Marcus Aurelius</h4>
                        <p>DevOps Lead</p>
                    </div>
                </div>
            </x-card>
            <x-card variant="default">
                <div>
                    <div>★★★★★</div>
                    <p>"As an employer, finding qualified candidates in Canada is usually tough. The candidate pipeline dashboard here is outstandingly simple."</p>
                </div>
                <div>
                    <div>NL</div>
                    <div>
                        <h4>Natalie Long</h4>
                        <p>Recruiting Manager</p>
                    </div>
                </div>
            </x-card>
        </div>
    </section>

    <!-- Recently Posted Section (Full 6-card Grid, No Empty Space) -->
    <section>
        <div>
            <div>
                <h2>Recently Posted</h2>
                <p>New career opportunities added today</p>
            </div>
            <a href="{{ route('jobs.index') }}">All Jobs &rarr;</a>
        </div>

        <div>
            @foreach($recentJobs as $job)
                @php
                    $initials = strtoupper(substr($job->company->company_name, 0, 2));
                    $bgColors = [
                        'Shopify Canada' => 'bg-blue-600',
                        'TechNorth Solutions' => 'bg-teal-600',
                        'Maple Finance Group' => 'bg-amber-700',
                        'Northern Health Systems' => 'bg-emerald-600',
                        'CanBridge Engineering' => 'bg-indigo-655',
                    ];
                    $bgClass = $bgColors[$job->company->company_name] ?? 'bg-primary-600';
                @endphp
                <x-card variant="default">
                    <div>
                        <!-- Top Row: Logo left, Title & Info right -->
                        <div>
                            <!-- Logo Box -->
                            <div>
                                @if($job->company->logo)
                                    <img src="{{ $job->company->logo }}" alt="Logo" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>

                            <div>
                                <!-- Badges Row -->
                                <div>
                                    @if($job->featured)
                                        <span>Featured</span>
                                    @endif
                                    @if($job->screeningQuestions->count() === 0)
                                        <span>Easy Apply</span>
                                    @endif
                                </div>
                                <h3>
                                    <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                </h3>
                                <p>
                                    {{ $job->company->company_name }}
                                    @if($job->company->verification_status === 'verified')
                                        <span>✓</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Job meta: location & type -->
                        <div>
                            <span>
                                📍 {{ $job->city }}, {{ $job->country }}
                            </span>
                            <span>&bull;</span>
                            <span>
                                💼 {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p>{{ $job->description }}</p>

                        <!-- Skill tags (Filled rounded-full pills) -->
                        <div>
                            @foreach($job->skills->take(3) as $skill)
                                <span>{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Footer: Salary (Stand out, green, 18px, bold) and Action buttons -->
                    <div>
                        <span>
                            @if($job->salary_min)
                                ${{ number_format($job->salary_min / 1000) }}K - ${{ number_format($job->salary_max / 1000) }}K
                            @else
                                Competitive
                            @endif
                        </span>
                        
                        <!-- Bookmark button -->
                        <button>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- Portal Options Grid (Job Seekers vs Employers, button heights: 52px, illustrations) -->
    <section>
        
        <!-- Job Seeker Portal Card -->
        <x-card variant="default">
            <div></div>
            
            <div>
                👨‍💻
            </div>
            
            <h2>I am a Job Seeker</h2>
            <p>
                Create a customized professional profile, upload multiple resumes, set up real-time job alerts, and apply to top Canadian vacancies in seconds.
            </p>
            
            <div>
                <a href="{{ route('register.seeker') }}">
                    Get Started
                </a>
                <a href="{{ route('jobs.index') }}">
                    Browse jobs &rarr;
                </a>
            </div>
        </x-card>

        <!-- Employer Portal Card -->
        <x-card variant="default">
            <div></div>
            
            <div>
                🏢
            </div>
            
            <h2>I am a Canadian Employer</h2>
            <p>
                Publish roles, screen potential applicants via our pipeline dashboard, look up matching resumes in our premium candidate archive, and verify your brand credentials.
            </p>
            
            <div>
                <a href="{{ route('register.employer') }}">
                    Post a Job
                </a>
                <a href="{{ route('login') }}">
                    Employer sign-in &rarr;
                </a>
            </div>
        </x-card>
    </section>

    <!-- Newsletter Capture Section [NEW] -->
    <section>
        <div>
            <div>
                <h3>Subscribe to Job Alerts</h3>
                <p>Get weekly updates on new vacancies, salary reports, and hiring companies.</p>
            </div>
            <form action="#" method="POST">
                <input type="email" placeholder="Enter your email address...">
                <button type="submit">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- Footer (Enriched with newsletter specs, support details, and quick links) -->
    <footer>
        <div>
            <div>
                <a href="/">
                    <div>
                        <span>J</span>
                    </div>
                    <span>JOBZIN<span>CANADA</span></span>
                </a>
                <p>Canada's premier job board connecting top talent with leading employers nationwide.</p>
                <p>📍 250 Yonge St, Toronto, ON, Canada</p>
                <p>📧 support@jobzincanada.ca</p>
            </div>
            
            <div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/">Home Page</a></li>
                        <li><a href="{{ route('companies.index') }}">Verified Companies</a></li>
                        <li><a href="#">Pricing Plans</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Candidates</h4>
                    <ul>
                        <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
                        <li><a href="#">Career Advice</a></li>
                        <li><a href="#">Salary Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Employers</h4>
                    <ul>
                        <li><a href="#">Post a Job</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Talent Search</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Connect</h4>
                    <div>
                        <span>LN</span>
                        <span>TW</span>
                        <span>FB</span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p>© {{ date('Y') }} JOBZINCANADA. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookies Settings</a>
            </div>
        </div>
    </footer>

</body>
</html>
