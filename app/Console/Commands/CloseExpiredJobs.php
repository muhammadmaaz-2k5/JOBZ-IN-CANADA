<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class CloseExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close job listings that have passed their application deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Job::where('status', 'published')
            ->where('auto_close_on_deadline', true)
            ->whereNotNull('application_deadline')
            ->where('application_deadline', '<', now())
            ->update(['status' => 'closed']);

        $this->info("Successfully closed {$count} expired job listings.");
    }
}
