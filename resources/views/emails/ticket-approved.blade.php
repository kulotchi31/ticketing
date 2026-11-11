<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Request Approved</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">

    <h2>Service Request Approved</h2>

    <p>Hello,</p>

    <p>
        Your service request has been approved and assigned
        to a worker.
    </p>

    <table cellpadding="8" cellspacing="0" border="1"
           style="border-collapse: collapse; width: 100%;">
        <tr>
            <td><strong>Ticket ID</strong></td>
            <td>{{ $ticket->ticket_id }}</td>
        </tr>
        <tr>
            <td><strong>Requested By</strong></td>
            <td>{{ $ticket->requested_by }}</td>
        </tr>
        <tr>
            <td><strong>Category</strong></td>
            <td>{{ $ticket->category->category_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Remarks</strong></td>
            <td>{{ $ticket->remarks }}</td>
        </tr>
        <tr>
            <td><strong>Assigned Worker</strong></td>
            <td>{{ $worker->name }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>Accepted</td>
        </tr>
    </table>

    <p>
        Please wait for the assigned worker to process your request.
    </p>

    <p>
        Thank you,<br>
        <strong>NEUST Ticketing System</strong>
    </p>

</body>
</html>
