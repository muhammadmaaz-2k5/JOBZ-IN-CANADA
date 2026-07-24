<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tight relative z-10">
            {{ __('Notification Preferences') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
        <!-- Decorative Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
            <div class="absolute top-[40%] -right-[10%] w-[40%] h-[60%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 shadow-xl p-8 md:p-12">
            
            @if (session('success'))
                <div class="p-4 mb-8 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 backdrop-blur-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.notifications.update') }}" class="space-y-12">
                @csrf
                @method('PUT')

                <div>
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-blue-50 text-blue-600 rounded-lg dark:bg-blue-900/30 dark:text-blue-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg></span>
                            Alert Channels
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium mt-2">Choose where you want to receive notifications</p>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <label class="relative flex flex-col p-5 cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm focus-within:ring-2 focus-within:ring-[#1650e1]">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></div>
                                <input type="checkbox" name="email_enabled" value="1" @checked($preferences->email_enabled) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1]" />
                            </div>
                            <span class="font-bold text-slate-900 dark:text-white">Email Notifications</span>
                        </label>

                        <label class="relative flex flex-col p-5 cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm focus-within:ring-2 focus-within:ring-[#1650e1]">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg></div>
                                <input type="checkbox" name="push_enabled" value="1" @checked($preferences->push_enabled) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1]" />
                            </div>
                            <span class="font-bold text-slate-900 dark:text-white">Push Notifications</span>
                        </label>

                        <label class="relative flex flex-col p-5 cursor-pointer rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm focus-within:ring-2 focus-within:ring-[#1650e1]">
                            <div class="flex items-center justify-between mb-3">
                                <div class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg></div>
                                <input type="checkbox" name="in_app_enabled" value="1" @checked($preferences->in_app_enabled) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1]" />
                            </div>
                            <span class="font-bold text-slate-900 dark:text-white">In-App Notifications</span>
                        </label>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700/50" />

                <div>
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg dark:bg-emerald-900/30 dark:text-emerald-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg></span>
                            Topic Preferences
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium mt-2">Select topics you want to stay updated on</p>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center gap-4 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm cursor-pointer">
                            <input type="checkbox" name="job_alerts" value="1" @checked($preferences->job_alerts) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1] shrink-0" />
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-lg">Job Alerts & Matches</span>
                                <span class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-0.5 block">Get notified when new jobs match your core skills and preferences.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm cursor-pointer">
                            <input type="checkbox" name="application_updates" value="1" @checked($preferences->application_updates) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1] shrink-0" />
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-lg">Application Status & Hiring Updates</span>
                                <span class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-0.5 block">Receive alerts when an employer reviews your application or updates its status.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm cursor-pointer">
                            <input type="checkbox" name="marketing_emails" value="1" @checked($preferences->marketing_emails) class="w-5 h-5 text-[#1650e1] rounded-md border-slate-300 focus:ring-[#1650e1] shrink-0" />
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-lg">Marketing & Promotional Offers</span>
                                <span class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-0.5 block">Updates about new platform features, resume tips, and promotional offers.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-[#1650e1] hover:bg-blue-700 text-white font-black text-lg rounded-xl transition-colors shadow-lg shadow-blue-900/20">
                        Save Preferences
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>