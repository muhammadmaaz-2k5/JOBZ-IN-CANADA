<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Jobs\SendJobAlerts;

Schedule::job(new SendJobAlerts('daily'))->daily();
Schedule::job(new SendJobAlerts('weekly'))->weekly();
