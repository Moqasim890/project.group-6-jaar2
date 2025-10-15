<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $naam;
    public $evenementNaam;
    public $totalTickets;
    public $purchasedTickets;
    public $totalBedrag;

    /**
     * Create a new message instance.
     */
    public function __construct($naam, $evenementNaam, $totalTickets, $purchasedTickets, $totalBedrag)
    {
        $this->naam = $naam;
        $this->evenementNaam = $evenementNaam;
        $this->totalTickets = $totalTickets;
        $this->purchasedTickets = $purchasedTickets;
        $this->totalBedrag = $totalBedrag;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bevestiging Ticketaankoop - ' . $this->evenementNaam,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
