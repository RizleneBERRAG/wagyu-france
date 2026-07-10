<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $kind,
        public Model $requestItem,
        public string $statusLabel,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre demande — ' . $this->requestItem->reference
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.requests.status',
            with: [
                'kind' => $this->kind,
                'requestItem' => $this->requestItem,
                'statusLabel' => $this->statusLabel,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}