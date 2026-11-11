<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Request Status Update</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">

    <h2>Service Request Status Updated</h2>

    <p>Dear {{ $ticket->creator?->name ?? 'Requester' }},</p>

    <p>
        Your university service request has been updated
        by the assigned worker.
    </p>

    <table cellpadding="10"
           cellspacing="0"
           border="1"
           style="border-collapse: collapse; width: 100%;">

        <tr>
            <td><strong>Ticket Number</strong></td>
            <td>{{ $ticket->ticket_number ?? $ticket->ticket_id }}</td>
        </tr>

        <tr>
            <td><strong>Requested By</strong></td>
            <td>{{ $ticket->requested_by }}</td>
        </tr>

        <tr>
            <td><strong>Previous Status</strong></td>
            <td>{{ $oldStatus }}</td>
        </tr>

        <tr>
            <td><strong>Current Status</strong></td>
            <td>{{ $newStatus }}</td>
        </tr>

        <tr>
            <td><strong>Assigned Worker</strong></td>
            <td>{{ $ticket->assignee?->name ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Department</strong></td>
            <td>{{ $ticket->department?->department_name ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Category</strong></td>
            <td>{{ $ticket->category?->category_name ?? 'N/A' }}</td>
        </tr>

        @if($newStatus === 'Pending')
            <tr>
                <td><strong>Pending Remarks</strong></td>
                <td>{{ $ticket->pending_remarks }}</td>
            </tr>
        @elseif($newStatus === 'Completed')
            <tr>
                <td><strong>Action Taken</strong></td>
                <td>{{ $ticket->action_taken }}</td>
            </tr>
        @endif

    </table>

    <p>
        Thank you for using the NEUST Ticketing System.
    </p>

    <p>
        Best regards,<br>
        <strong>NEUST Ticketing System</strong>
    </p>

</body>
</html>
