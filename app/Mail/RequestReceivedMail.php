<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $kind,
        public Model $requestItem,
        public bool $forAdmin = false,
    ) {}

    public function envelope(): Envelope
    {
        $labels = [
            'shop' => 'demande boutique',
            'contact' => 'message de contact',
            'pro' => 'demande professionnelle',
        ];

        $label = $labels[$this->kind] ?? 'demande';
        $prefix = $this->forAdmin ? 'Nouveau ' : 'Votre ';

        return new Envelope(
            subject: ucfirst($prefix . $label) . ' — ' . $this->requestItem->reference
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.requests.received',
            with: [
                'kind' => $this->kind,
                'requestItem' => $this->requestItem,
                'forAdmin' => $this->forAdmin,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}