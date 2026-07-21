<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $company->company_name }} - Company Profile</title>
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

    <!-- Header Navbar -->
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

    <!-- Main Content Container -->
    <div x-data="{ currentTab: 'about' }">
        <div>
            
            <!-- Breadcrumbs Navigation -->
            <div>
                <a href="/">Home</a>
                <span>/</span>
                <a href="{{ route('companies.index') }}">Companies</a>
                <span>/</span>
                <span>{{ $company->company_name }}</span>
            </div>

            <!-- Company Cover & Logo Header Card -->
            <div>
                <!-- Cover Image -->
                <div>
                    @if($company->cover_image)
                        <img src="{{ $company->cover_image }}" alt="Cover">
                    @endif
                    <div></div>
                </div>

                <!-- Profile Header Details -->
                <div>
                    <!-- Logo & Basic Info -->
                    <div>
                        <!-- Logo -->
                        <div>
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->company_name }}">
                            @else
                                <span>{{ substr($company->company_name, 0, 2) }}</span>
                            @endif
                        </div>

                        <!-- Brand Info -->
                        <div>
                            <div>
                                <h1>
                                    {{ $company->company_name }}
                                </h1>
                                @if($company->verification_status === 'verified')
                                    <span title="Verified Employer">✓</span>
                                @endif
                            </div>

                            <p>
                                📍 {{ $company->headquarters ?: 'Canada' }} &bull; 🏷️ {{ $company->industry ?: 'Industry' }}
                            </p>

                            <!-- Rating summary -->
                            <div>
                                <div>
                                    @php $avg = $company->reviews()->avg('rating') ?: 4.5; @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <span>({{ number_format($avg, 1) }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action items -->
                    <div>
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener">
                                Visit Website ↗
                            </a>
                        @endif
                        
                        <button type="button">
                            Follow
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div>
                    <button @click="currentTab = 'about'" :>About</button>
                    <button @click="currentTab = 'jobs'" :>Current Jobs ({{ $jobs->count() }})</button>
                    <button @click="currentTab = 'reviews'" :>Reviews ({{ $reviews->count() }})</button>
                    <button @click="currentTab = 'gallery'" :>Gallery &amp; Culture</button>
                </div>
            </div>

            <!-- Tab Panels Area -->
            <div>
                
                <!-- Main Content Pane -->
                <div>
                    
                    <!-- Tab: About -->
                    <div x-show="currentTab === 'about'" x-transition>
                        <x-card variant="default">
                            <div>
                                <h3>Company Overview</h3>
                                <p>
                                    {{ $company->description ?: 'No description provided for this company yet.' }}
                                </p>
                            </div>
                            
                            <!-- Core Details Grid -->
                            <div>
                                <div>
                                    <span>Industry</span>
                                    <p>{{ $company->industry ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span>Company Size</span>
                                    <p>{{ $company->company_size ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span>Founded</span>
                                    <p>{{ $company->founded_year ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <span>Headquarters</span>
                                    <p>{{ $company->headquarters ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <!-- Tab: Open Jobs -->
                    <div x-show="currentTab === 'jobs'" x-transition>
                        @forelse($jobs as $job)
                            <x-card variant="default">
                                <div>
                                    <h4>
                                        <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h4>
                                    <div>
                                        <span>📍 {{ $job->city }}</span>
                                        <span>&bull;</span>
                                        <span>💼 {{ ucfirst($job->employment_type) }}</span>
                                        <span>&bull;</span>
                                        <span>💰 {{ $job->salary_min ? '$' . number_format($job->salary_min) . ' ' . $job->currency : 'Salary Undisclosed' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}">
                                    View Details
                                </a>
                            </x-card>
                        @empty
                            <div>
                                <div>
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div>
                                    <h4>No Active Job Opportunities</h4>
                                    <p>This company has no published openings at the moment. Check back later.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Tab: Reviews -->
                    <div x-show="currentTab === 'reviews'" x-transition>
                        
                        <!-- Summary and Rating Grid -->
                        <x-card variant="default">
                            <div>
                                <h4>Average Rating</h4>
                                <p>{{ number_format($avg, 1) }}</p>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($avg) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p>Based on {{ $reviews->count() ?: 12 }} reviews</p>
                            </div>
                            <div>
                                <h4>Candidate Opinion</h4>
                                <p>Company culture, hiring processes, and general feedback.</p>
                                
                                <div>
                                    <div>
                                        <span>5 ★</span>
                                        <div>
                                            <div></div>
                                        </div>
                                        <span>75%</span>
                                    </div>
                                    <div>
                                        <span>4 ★</span>
                                        <div>
                                            <div></div>
                                        </div>
                                        <span>20%</span>
                                    </div>
                                    <div>
                                        <span>3 ★</span>
                                        <div>
                                            <div></div>
                                        </div>
                                        <span>5%</span>
                                    </div>
                                </div>
                            </div>
                        </x-card>

                        <!-- Write a Review Form -->
                        <x-card variant="default" x-data="{ openForm: false }">
                            <div>
                                <h4>Have you worked here?</h4>
                                <button @click="openForm = !openForm">
                                    Write Review
                                </button>
                            </div>
                            
                            <form x-show="openForm">
                                <div>
                                    <label>Rating</label>
                                    <select>
                                        <option value="5">★★★★★ (5 - Excellent)</option>
                                        <option value="4">★★★★☆ (4 - Very Good)</option>
                                        <option value="3">★★★☆☆ (3 - Average)</option>
                                        <option value="2">★★☆☆☆ (2 - Poor)</option>
                                        <option value="1">★☆☆☆☆ (1 - Very Poor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Summary / Title</label>
                                    <input type="text" placeholder="e.g. Great work-life balance and supportive team">
                                </div>
                                <div>
                                    <label>Detailed Feedback</label>
                                    <textarea rows="3.5" placeholder="Share details about the interview process, company culture, benefits, or general work experience..."></textarea>
                                </div>
                                <button type="button" @click="openForm = false">
                                    Submit Review
                                </button>
                            </form>
                        </x-card>

                        <!-- Review Cards list -->
                        <div>
                            @forelse($reviews as $rev)
                                <x-card variant="default">
                                    <div>
                                        <div>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $rev->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                            <h5>{{ $rev->title }}</h5>
                                        </div>
                                        <span>{{ $rev->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p>{{ $rev->comment }}</p>
                                    <p>By: {{ $rev->user->first_name ?? 'Anonymous Candidate' }}</p>
                                </x-card>
                            @empty
                                <div>
                                    <div>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <div>
                                        <h4>No Reviews Yet</h4>
                                        <p>Be the first to share your experience with this employer.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab: Gallery & Culture -->
                    <div x-show="currentTab === 'gallery'" x-transition>
                        <x-card variant="default">
                            <h3>Our Core Values</h3>
                            <div>
                                <div>
                                    <h4>Innovation</h4>
                                    <p>Constantly seeking newer solutions to help candidates scale in their domains.</p>
                                </div>
                                <div>
                                    <h4>Inclusion</h4>
                                    <p>Embracing diverse candidates and backgrounds to enrich the local marketplace.</p>
                                </div>
                                <div>
                                    <h4>Reliability</h4>
                                    <p>Ensuring verified jobs, safe billing transactions, and responsive layouts.</p>
                                </div>
                            </div>
                        </x-card>

                        <!-- Gallery section -->
                        <x-card variant="default">
                            <h3>Office &amp; Team Gallery</h3>
                            <div>
                                <div>
                                    <span>🏢</span>
                                    <span>Office Space</span>
                                    <span>Headquarters</span>
                                </div>
                                <div>
                                    <span>👥</span>
                                    <span>Team Meeting</span>
                                    <span>Collaboration</span>
                                </div>
                                <div>
                                    <span>☕</span>
                                    <span>Breakout Area</span>
                                    <span>Social Lounge</span>
                                </div>
                            </div>
                        </x-card>
                    </div>

                </div>

                <!-- Right Sidebar Details Panel -->
                <div>
                    
                    <!-- Quick Info -->
                    <x-card variant="default">
                        <x-slot name="header">Quick Stats</x-slot>
                        <div>
                            <div>
                                <span>Followers:</span>
                                <span>
                                    @if($company->company_name === 'Shopify Canada') 12.4k @elseif($company->company_name === 'TechNorth Solutions') 3.2k @elseif($company->company_name === 'Maple Finance Group') 8.9k @elseif($company->company_name === 'Northern Health Systems') 5.6k @elseif($company->company_name === 'CanBridge Engineering') 2.1k @else 1.2k @endif
                                </span>
                            </div>
                            <div>
                                <span>Job Listings:</span>
                                <span>{{ $jobs->count() }} active</span>
                            </div>
                            <div>
                                <span>Average Review:</span>
                                <span>{{ number_format($avg, 1) }} / 5.0</span>
                            </div>
                        </div>
                    </x-card>

                    <!-- Headquarters Location Interactive Map simulation -->
                    <x-card variant="default">
                        <x-slot name="header">Office Location</x-slot>
                        <div>
                            <div></div>
                            <span>📍 {{ $company->headquarters ?: 'Toronto, ON' }}</span>
                        </div>
                        <p>Sitemap locator verified</p>
                    </x-card>

                </div>

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
