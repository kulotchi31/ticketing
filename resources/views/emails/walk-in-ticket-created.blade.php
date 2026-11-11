
<x-mail::message>
# New Walk-in Service Request

A new walk-in service request has been submitted.

**Ticket Information**

- **Ticket ID:** {{ $ticket->ticket_id }}
- **Requested By:** {{ $ticket->requested_by }}
- **Department:** {{ $ticket->department?->department_name ?? 'N/A' }}
- **Campus:** {{ $ticket->department?->campus?->campus_name ?? 'N/A' }}
- **Service Provider:** {{ $ticket->category?->requestType?->provider?->provider_name ?? 'N/A' }}
- **Request Type:** {{ $ticket->category?->requestType?->rt_name ?? 'N/A' }}
- **Category:** {{ $ticket->category?->category_name ?? 'N/A' }}
- **Priority:** {{ $ticket->classification }}
- **Status:** {{ $ticket->status }}

<x-mail::panel>
**Remarks**

{{ $ticket->remarks }}
</x-mail::panel>

Please log in to the NEUST Ticketing System to review this request.

Thanks,

**NEUST Ticketing System**
</x-mail::message>
