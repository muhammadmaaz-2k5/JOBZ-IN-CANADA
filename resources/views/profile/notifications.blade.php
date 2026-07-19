<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notification Preferences') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-6">

                @if (session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-xl text-xs font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.notifications.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <h3 class="font-black text-sm text-gray-900 dark:text-white uppercase tracking-wider">
                            Alert Channels
                        </h3>
                        <p class="text-2xs text-gray-400">Choose where you want to receive notifications</p>

                        <div class="space-y-3 pt-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="email_enabled" value="1" @checked($preferences->email_enabled) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">Email Notifications</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="push_enabled" value="1" @checked($preferences->push_enabled) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">Push Notifications</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="in_app_enabled" value="1" @checked($preferences->in_app_enabled) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">In-App Notifications</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-750" />

                    <div class="space-y-4">
                        <h3 class="font-black text-sm text-gray-900 dark:text-white uppercase tracking-wider">
                            Topic Preferences
                        </h3>
                        <p class="text-2xs text-gray-400">Select topics you want to stay updated on</p>

                        <div class="space-y-3 pt-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="job_alerts" value="1" @checked($preferences->job_alerts) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">Job Alerts & Matches</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="application_updates" value="1" @checked($preferences->application_updates) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">Application Status & Hiring Updates</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="marketing_emails" value="1" @checked($preferences->marketing_emails) class="rounded border-gray-300 text-indigo-650 shadow-sm" />
                                <span class="text-xs font-bold text-gray-750 dark:text-gray-350">Marketing & Promotional Offers</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Save Preferences
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
