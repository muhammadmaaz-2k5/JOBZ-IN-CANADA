@php
    use App\Models\Application;
    use App\Models\JobSeekerProfile;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $job->title }} at {{ $job->company->company_name }}. Apply now on JOBZ IN CANADA.">
    <title>{{ $job->title }} - JOBZ IN CANADA</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-white text-gray-900 font-sans antialiased min-h-screen flex flex-col">

<header class="home-nav">
    <div class="home-nav-inner">
        <a href="/" class="brand">
            <div class="brand-icon">J</div>
            <span class="brand-text">JOBZ IN <span class="brand-accent">CANADA</span></span>
        </a>
        <nav class="nav-links">
            <a href="{{ route('jobs.index') }}" class="hnav-link">Find Jobs</a>
            <a href="{{ route('companies.index') }}" class="hnav-link">Companies</a>
            <a href="{{ route('pricing') }}" class="hnav-link">Pricing</a>
        </nav>
        <div class="nav-actions">
            <button @click="dark = !dark" type="button"
                    class="icon-btn" title="Toggle theme">
                <span x-show="!dark">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9 0 0012 21a9.003 9 0 008.354-5.646z"/>
                    </svg>
                </span>
                <span x-show="dark">
                    <svg class="icon-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </span>
            </button>
            <x-nav-auth />
        </div>
    </div>
</header>

<main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    
    {{-- Search Bars Area (Pill style, Indeed match) --}}
    <form method="GET" action="{{ route('jobs.index') }}" class="mb-12 flex w-full max-w-3xl mx-auto items-center bg-white border border-gray-300 rounded-full shadow-sm relative p-0.5 z-40">
        <!-- What -->
        <div class="relative flex-1 flex items-center focus-within:ring-2 focus-within:ring-[#1650e1] focus-within:z-10 rounded-l-full transition-all bg-white h-full">
            <div class="pl-5 pr-2 text-gray-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                   class="w-full py-3.5 pr-4 text-sm bg-transparent border-none focus:ring-0 outline-none placeholder-gray-500 form-input-premium" 
                   placeholder="Job title, keywords, or company">
        </div>

        <!-- Divider -->
        <div class="h-8 w-px bg-gray-300 relative z-0"></div>

        <!-- Where -->
        <div class="relative flex-1 flex items-center focus-within:ring-2 focus-within:ring-[#1650e1] focus-within:z-10 transition-all bg-white h-full">
            <div class="pl-4 pr-2 text-gray-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <input type="text" name="location" value="{{ request('location') }}"
                   class="w-full py-3.5 pr-4 text-sm bg-transparent border-none focus:ring-0 outline-none placeholder-gray-500 form-input-premium" 
                   placeholder='City, state, zip code, or "remote"'>
        </div>

        <!-- Button -->
        <div class="pr-1 pl-1 shrink-0 relative z-20">
            <button type="submit" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold text-sm px-6 py-2.5 rounded-full transition-colors whitespace-nowrap">
                Find jobs
            </button>
        </div>
    </form>

    {{-- Job Details Content --}}
    <div class="max-w-2xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
            
            <a href="{{ route('companies.show', $job->company->slug) }}" class="text-sm text-gray-700 hover:underline flex items-center gap-1 w-fit mb-1">
                {{ $job->company->company_name }}
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
            
            <div class="text-sm text-gray-800 mb-2">{{ $job->city }}@if($job->country), {{ $job->country }}@endif</div>
            
            <div class="text-sm font-semibold text-gray-800 mb-4">
                @if($job->salary_min && $job->salary_max)
                    ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }} a {{ $job->salary_type ?? 'year' }}
                @elseif($job->salary_min)
                    From ${{ number_format($job->salary_min) }} a {{ $job->salary_type ?? 'year' }}
                @else
                    Competitive
                @endif
            </div>
            
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="bg-[#1650e1] text-white font-bold text-sm px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors">Apply Now</a>
                @else
                    @php
                        $user = Auth::user();
                        $isSeeker = $user && $user->hasRole('job_seeker');
                        $hasApplied = false;
                        if ($isSeeker) {
                            $hasApplied = Application::where('job_id', $job->id)->where('applicant_id', $user->id)->where('status', '!=', 'withdrawn')->exists();
                        }
                    @endphp
                    @if($isSeeker)
                        @if($hasApplied)
                            <button disabled class="bg-gray-300 text-gray-600 font-bold text-sm px-6 py-2.5 rounded-lg cursor-not-allowed">Applied</button>
                        @else
                            <a href="{{ route('jobs.apply', $job->slug) }}" class="bg-[#1650e1] text-white font-bold text-sm px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors">Apply Now</a>
                        @endif
                    @endif
                @endguest
                
                <button class="bg-gray-100 p-2.5 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </button>
                <button class="bg-gray-100 p-2.5 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- Job Details section --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Job details</h2>
            
            <div class="space-y-6">
                {{-- Pay --}}
                @if($job->salary_min || $job->salary_max)
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold text-sm text-gray-900">Pay</span>
                    </div>
                    <div class="ml-7">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-semibold bg-gray-100 text-gray-800">
                            @if($job->salary_min && $job->salary_max)
                                ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }} a {{ $job->salary_type ?? 'year' }}
                            @else
                                From ${{ number_format($job->salary_min) }} a {{ $job->salary_type ?? 'year' }}
                            @endif
                        </span>
                    </div>
                </div>
                @endif

                {{-- Job Type --}}
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-bold text-sm text-gray-900">Job type</span>
                    </div>
                    <div class="ml-7">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-semibold bg-gray-100 text-gray-800">
                            {{ ucfirst(str_replace('_', '-', $job->employment_type)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- Location section --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Location</h2>
            <div class="flex items-center gap-2 text-sm text-gray-800">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ $job->city }}@if($job->country), {{ $job->country }}@endif</span>
            </div>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- Full Job Description --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Full job description</h2>
            
            <div class="text-gray-800 text-sm leading-relaxed space-y-4">
                {!! nl2br(e($job->description)) !!}
                
                @if($job->responsibilities)
                    <p class="mt-4">{!! nl2br(e($job->responsibilities)) !!}</p>
                @endif
                
                @if($job->requirements)
                    <p class="mt-4">{!! nl2br(e($job->requirements)) !!}</p>
                @endif
                
                <div class="mt-6 pt-4 space-y-2">
                    @if($job->salary_min)
                    <p>Pay: 
                        @if($job->salary_min && $job->salary_max)
                            ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }} per {{ $job->salary_type ?? 'year' }}
                        @else
                            ${{ number_format($job->salary_min) }} per {{ $job->salary_type ?? 'year' }}
                        @endif
                    </p>
                    @endif
                    <p>Work Location: {{ ucfirst($job->workplace_type) }}</p>
                </div>
            </div>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- Report Job Button --}}
        <div class="mb-12">
            <button class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-sm px-4 py-2.5 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                </svg>
                Report job
            </button>
        </div>

        <hr class="border-gray-200 my-8">

        {{-- Bottom Links --}}
        <div class="space-y-4 pb-12">
            @if($job->category)
            <a href="#" class="block text-sm text-gray-600 hover:underline border-b border-gray-200 pb-2 w-fit">
                {{ $job->category->name }} jobs in {{ $job->city }}
            </a>
            @endif
            <a href="#" class="block text-sm text-gray-600 hover:underline border-b border-gray-200 pb-2 w-fit">
                Jobs at {{ $job->company->company_name }} in {{ $job->city }}
            </a>
        </div>
        
    </div>

</main>

<x-footer />

</body>
</html>
