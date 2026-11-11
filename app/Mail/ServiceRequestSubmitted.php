<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceRequestSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $requestedBy;
    public $department;
    public $campus;
    public $requestType;
    public $category;
    public $classification;
    public $remarks;

    public function __construct($ticket)
    {
        $this->requestedBy = $ticket->requested_by;

        $this->department = $ticket->department?->department_name ?? 'N/A';

        $this->campus = $ticket->department?->campus?->campus_name ?? 'N/A';

        $this->requestType = $ticket->category?->requestType?->rt_name ?? 'N/A';

        $this->category = $ticket->category?->category_name ?? 'N/A';

        $this->classification = $ticket->classification;

        $this->remarks = $ticket->remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New University Service Request'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.service-request-submitted'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
