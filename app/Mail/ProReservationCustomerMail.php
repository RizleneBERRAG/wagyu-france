<?php

namespace App\Mail;

use App\Models\ProReservationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProReservationCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProReservationRequest $reservation
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande de pré-réservation Wagyu France'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pro-reservations.customer',
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
