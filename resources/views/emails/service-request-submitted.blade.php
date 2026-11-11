
<x-mail::message>
# New University Service Request

Hello,

A new service request has been submitted to your service provider and requires your attention.

### Request Information

| Field | Details |
|---|---|
| Requested By | {{ $requestedBy }} |
| Department | {{ $department }} |
| Campus | {{ $campus }} |
| Request Type | {{ $requestType }} |
| Category | {{ $category }} |
| Priority | {{ $classification }} |

### Request Remarks

{{ $remarks }}

Please log in to the NEUST Ticketing System to review and process this service request.

<x-mail::button :url="config('app.url')">
Open Ticketing System
</x-mail::button>

Thank you,

**NEUST Ticketing System**

</x-mail::message>
