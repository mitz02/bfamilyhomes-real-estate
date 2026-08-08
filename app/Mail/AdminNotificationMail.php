<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $type,
        public string $title,
        public string $body,
        public array $details = [],
        public ?string $actionUrl = null,
        public ?string $actionText = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->title} - B-Family Homes",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-notification',
        );
    }
}
