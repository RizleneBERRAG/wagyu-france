<?php

namespace App\Mail;

use App\Models\ProReservationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProReservationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProReservationRequest $reservation
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande pro — ' . $this->reservation->reference
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pro-reservations.admin',
            with: [
                'reservation' => $this->reservation,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
