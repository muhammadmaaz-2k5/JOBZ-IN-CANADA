<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Notification Preferences') }}
        </h2>
    </x-slot>

    <div>
        <div>
            <div>

                @if (session('success'))
                    <div>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.notifications.update') }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3>
                            Alert Channels
                        </h3>
                        <p>Choose where you want to receive notifications</p>

                        <div>
                            <label>
                                <input type="checkbox" name="email_enabled" value="1" @checked($preferences->email_enabled) />
                                <span>Email Notifications</span>
                            </label>

                            <label>
                                <input type="checkbox" name="push_enabled" value="1" @checked($preferences->push_enabled) />
                                <span>Push Notifications</span>
                            </label>

                            <label>
                                <input type="checkbox" name="in_app_enabled" value="1" @checked($preferences->in_app_enabled) />
                                <span>In-App Notifications</span>
                            </label>
                        </div>
                    </div>

                    <hr />

                    <div>
                        <h3>
                            Topic Preferences
                        </h3>
                        <p>Select topics you want to stay updated on</p>

                        <div>
                            <label>
                                <input type="checkbox" name="job_alerts" value="1" @checked($preferences->job_alerts) />
                                <span>Job Alerts & Matches</span>
                            </label>

                            <label>
                                <input type="checkbox" name="application_updates" value="1" @checked($preferences->application_updates) />
                                <span>Application Status & Hiring Updates</span>
                            </label>

                            <label>
                                <input type="checkbox" name="marketing_emails" value="1" @checked($preferences->marketing_emails) />
                                <span>Marketing & Promotional Offers</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit">
                            Save Preferences
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
