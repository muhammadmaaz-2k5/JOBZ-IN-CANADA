<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $type;
    public $data;
    public $subjectLine;
    public $line1;
    public $line2;
    public $actionUrl;
    public $actionText;

    /**
     * Create a new message instance.
     */
    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->buildMailDetails();
    }

    protected function buildMailDetails()
    {
        switch ($this->type) {
            case 'submitted':
                $this->subjectLine = 'Application Submitted Successfully';
                $this->line1 = "Your application for the position of **{$this->data['job_title']}** at **{$this->data['company_name']}** has been submitted successfully.";
                $this->line2 = 'The employer will review your profile, and we will update you as soon as they make a decision.';
                break;

            case 'employer_alert':
                $this->subjectLine = 'New Application Received';
                $this->line1 = "You have received a new application from **{$this->data['applicant_name']}** for your job listing: **{$this->data['job_title']}**.";
                $this->actionUrl = url('/employer/applicants');
                $this->actionText = 'Review Application';
                break;

            case 'status_updated':
                $this->subjectLine = "Application Status Update: {$this->data['status']}";
                $this->line1 = "The status of your application for **{$this->data['job_title']}** at **{$this->data['company_name']}** has been changed to **" . ucfirst($this->data['status']) . "**.";
                if (!empty($this->data['remarks'])) {
                    $this->line2 = "Employer Remarks: *\"{$this->data['remarks']}\"*";
                }
                break;

            case 'withdrawn':
                $this->subjectLine = 'Application Withdrawn';
                $this->line1 = "The candidate **{$this->data['applicant_name']}** has withdrawn their application for **{$this->data['job_title']}**.";
                break;

            case 'resume_downloaded':
                $this->subjectLine = 'Resume Viewed by Employer';
                $this->line1 = "Your resume has been viewed and downloaded by **{$this->data['company_name']}** for the position of **{$this->data['job_title']}**!";
                break;

            default:
                $this->subjectLine = 'Job Application Update';
                $this->line1 = 'There is a new update regarding your job application.';
                break;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application',
        );
    }
}
