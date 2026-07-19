<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertMatchNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $jobs;
    public $keyword;

    public function __construct(User $user, $jobs, $keyword)
    {
        $this->user = $user;
        $this->jobs = $jobs;
        $this->keyword = $keyword;
    }

    public function build()
    {
        return $this->subject("New Job Match Updates for \"{$this->keyword}\" in Canada")
            ->view('emails.job_alert');
    }
}
