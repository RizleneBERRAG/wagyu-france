<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LogisticsStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reference,
        public string $statusLabel,
        public ?string $scheduledLabel,
        public ?string $deliveryLabel,
        public ?string $carrier,
        public ?string $trackingNumber,
        public ?string $notes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre dossier — ' . $this->reference
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.logistics-status',
            with: [
                'reference' => $this->reference,
                'statusLabel' => $this->statusLabel,
                'scheduledLabel' => $this->scheduledLabel,
                'deliveryLabel' => $this->deliveryLabel,
                'carrier' => $this->carrier,
                'trackingNumber' => $this->trackingNumber,
                'notes' => $this->notes,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
