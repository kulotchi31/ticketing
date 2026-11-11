<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class TicketApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public User $worker;
    public string $recipientType;

    /**
     * Create a new message instance.
     */
    public function __construct(
        Ticket $ticket,
        User $worker,
        string $recipientType
    ) {
        $this->ticket = $ticket;
        $this->worker = $worker;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'requester'
            ? 'Your Service Request Has Been Approved'
            : 'New Service Request Assigned to You';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-approved',
            with: [
                'ticket' => $this->ticket,
                'worker' => $this->worker,
                'recipientType' => $this->recipientType,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
