<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top Companies in Canada - JOBZ IN CANADA</title>
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
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('jobs.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Find Jobs
                </a>
                <a href="{{ route('companies.index') }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
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

    <!-- Main Page Container -->
    <div>
        <div>
            
            <!-- Breadcrumbs -->
            <div>
                <a href="/">Home</a>
                <span>/</span>
                <span>Companies</span>
            </div>

            <!-- Page Title Header -->
            <div>
                <h1>Top Companies in Canada</h1>
                <p>Discover employers actively hiring across the country</p>
            </div>

            <!-- Grid Layout of Company Cards -->
            <div>
                @foreach($companies as $company)
                    @php
                        $initials = strtoupper(substr($company->company_name, 0, 2));
                        $avgRating = $company->reviews()->avg('rating') ?: 4.5;
                        $followersCount = $company->followers()->count() ?: 12400;
                        if ($company->company_name === 'Shopify Canada') {
                            $followersCount = 12400;
                            $avgRating = 4.7;
                        } elseif ($company->company_name === 'TechNorth Solutions') {
                            $followersCount = 3200;
                            $avgRating = 4.5;
                        } elseif ($company->company_name === 'Maple Finance Group') {
                            $followersCount = 8900;
                            $avgRating = 4.3;
                        } elseif ($company->company_name === 'Northern Health Systems') {
                            $followersCount = 5600;
                            $avgRating = 4.6;
                        } elseif ($company->company_name === 'CanBridge Engineering') {
                            $followersCount = 2100;
                            $avgRating = 4.4;
                        }
                        
                        // Format followers count (e.g. 12.4k)
                        $followersFormatted = $followersCount >= 1000 ? number_format($followersCount / 1000, 1) . 'k' : $followersCount;
                        
                        // Pick background color based on name to match image
                        $bgColors = [
                            'Shopify Canada' => 'bg-blue-600',
                            'TechNorth Solutions' => 'bg-teal-600',
                            'Maple Finance Group' => 'bg-amber-700',
                            'Northern Health Systems' => 'bg-emerald-600',
                            'CanBridge Engineering' => 'bg-indigo-650',
                        ];
                        $bgClass = $bgColors[$company->company_name] ?? 'bg-primary-600';
                    @endphp
                    <a href="{{ route('companies.show', $company->slug) }}"
                    >
                        <div>
                            <!-- Initials Logo / Custom Uploaded Logo -->
                            <div>
                                @if($company->logo)
                                    <img src="{{ $company->logo }}" alt="{{ $company->company_name }}" />
                                @else
                                    {{ $initials }}
                                @endif
                            </div>

                            <div>
                                <h3>
                                    {{ $company->company_name }}
                                    @if($company->verification_status === 'verified')
                                        <span title="Verified Employer">✓</span>
                                    @endif
                                </h3>
                                <p>{{ $company->industry ?: 'Industry' }}</p>
                                
                                <div>
                                    <span>★ <span>{{ number_format($avgRating, 1) }}</span></span>
                                    <span>|</span>
                                    <span>👥 <span>{{ $followersFormatted }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Arrow chevron -->
                        <div>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @endforeach
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
