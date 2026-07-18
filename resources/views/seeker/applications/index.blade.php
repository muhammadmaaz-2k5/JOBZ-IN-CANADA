<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dashboard Filters -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 flex flex-wrap gap-2">
                @foreach([
                    'all' => 'All Applications',
                    'active' => 'Active',
                    'pending' => 'Pending Review',
                    'shortlisted' => 'Shortlisted',
                    'interviews' => 'Interviews',
                    'offers' => 'Offers',
                    'rejected' => 'Rejected',
                    'withdrawn' => 'Withdrawn'
                ] as $key => $label)
                    <a href="{{ route('seeker.applications.index', ['filter' => $key]) }}"
                       class="px-4 py-2 text-xs font-bold rounded-xl transition duration-200 
                       @if($filter === $key) bg-indigo-600 text-white shadow-sm @else bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-950 @endif">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Applications List -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/50">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Submission History</h3>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-750">
                    @forelse($applications as $app)
                        <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-extrabold text-base text-gray-900 dark:text-white hover:text-indigo-600 transition">
                                        <a href="{{ route('seeker.applications.show', $app->id) }}">{{ $app->job->title }}</a>
                                    </h4>
                                    
                                    <!-- Status Badges -->
                                    <span class="px-2.5 py-0.5 rounded-full text-3xs font-extrabold uppercase 
                                        @if($app->status === 'applied') bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                                        @elseif($app->status === 'pending_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300
                                        @elseif($app->status === 'shortlisted') bg-indigo-100 text-indigo-850 dark:bg-indigo-950 dark:text-indigo-300
                                        @elseif(str_contains($app->status, 'interview')) bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300
                                        @elseif($app->status === 'offered') bg-pink-100 text-pink-850 dark:bg-pink-950 dark:text-pink-300
                                        @elseif($app->status === 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                                        @elseif($app->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                                        @endif">
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-650 dark:text-gray-400 font-semibold">
                                    {{ $app->job->company->company_name }} &bull; Applied on {{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}
                                </p>
                                <div class="text-3xs text-gray-400">
                                    Resume: {{ $app->resume->title }}
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                                <a href="{{ route('seeker.applications.show', $app->id) }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:underline">View Details</a>
                                
                                @if(!in_array($app->status, ['rejected', 'withdrawn', 'hired']))
                                    <form method="POST" action="{{ route('seeker.applications.withdraw', $app->id) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to withdraw your application? This cannot be undone.');" class="text-xs font-semibold text-red-650 hover:underline">
                                            Withdraw
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500">
                            No job applications found in this category. Let's find some openings!
                        </div>
                    @endforelse
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-900/30">
                    {{ $applications->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
