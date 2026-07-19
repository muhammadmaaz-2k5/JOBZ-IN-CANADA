<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MailMessageListener
{
    /**
     * Handle MessageSending event (before delivery).
     */
    public function handleSending(MessageSending $event)
    {
        try {
            $message = $event->message;
            $toAddresses = [];
            foreach ($message->getTo() as $address) {
                $toAddresses[] = $address->getAddress();
            }

            EmailLog::create([
                'recipient' => implode(', ', $toAddresses),
                'subject' => $message->getSubject() ?? '(No Subject)',
                'template' => null, // Can be parsed if using custom mailable headers
                'status' => 'pending',
                'provider' => 'smtp',
                'sent_at' => null,
            ]);
        } catch (\Exception $e) {
            Log::error('MailMessageListener sending log failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle MessageSent event (after successful delivery).
     */
    public function handleSent(MessageSent $event)
    {
        try {
            $message = $event->message;
            $toAddresses = [];
            foreach ($message->getTo() as $address) {
                $toAddresses[] = $address->getAddress();
            }

            $recipient = implode(', ', $toAddresses);
            $subject = $message->getSubject() ?? '(No Subject)';

            // Update the pending log to sent
            $log = EmailLog::where('recipient', $recipient)
                ->where('subject', $subject)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($log) {
                $log->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } else {
                EmailLog::create([
                    'recipient' => $recipient,
                    'subject' => $subject,
                    'status' => 'sent',
                    'provider' => 'smtp',
                    'sent_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('MailMessageListener sent log failed: ' . $e->getMessage());
        }
    }
}
