<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NEUST MIS Service Request Form - {{ $ticket->ticket_number ?? '' }}</title>
    <style>
        @page {
            size: Letter portrait;
            margin: 0.18in;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111111;
            background: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Individual Half-Letter Form Box */
        .form-box {
            border: 1px solid #222222;
            font-size: 6.6pt;
            line-height: 1.08;
            position: relative;
        }

        /* Navy Masthead */
        .masthead {
            background-color: #003366;
            color: #ffffff;
        }

        .masthead td {
            vertical-align: middle;
            padding: 4px 6px;
        }

        .logo-left {
            width: 0.68in;
            text-align: center;
         
        }

        .logo-left img {
            width: 0.56in;
            height: 0.56in;
            padding-right: 50px;
        }

        .logo-right {
            width: 0.68in;
            text-align: center;
        }

        .logo-right img {
            width: 0.52in;
            height: 0.52in;
            padding-left: 50px;
        }

        .masthead-center {
            text-align: center;
        }

        .republic {
            font-size: 9.5pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
        }

        .school {
            font-size: 13pt;
            font-weight: bold;
            line-height: 1.1;
            color: #ffb000;
            white-space: nowrap;
            letter-spacing: -0.3px;
        }

        /* Gold System Band */
        .system-band {
            background-color: #ffc400;
            color: #111111;
            padding: 4px 10px;
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            border-top: 1px solid #222222;
            border-bottom: 1px solid #222222;
        }

        .form-title {
            text-align: center;
            font-size: 7.2pt;
            font-weight: bold;
            padding: 3px 0;
            border-bottom: 1px solid #222222;
        }

        /* Top 2-Column Fields */
        .fields-table td {
            border-bottom: 1px solid #555555;
            padding: 3.5px 5px;
            vertical-align: middle;
        }

        .border-right {
            border-right: 1px solid #222222;
        }

        .field-val {
            font-weight: bold;
        }

        /* Kind of Request */
        .kind-row td {
            border-bottom: 1px solid #555555;
            padding: 4px 5px;
            height: 0.28in;
            vertical-align: top;
        }

        /* Remarks Box */
        .remarks-box {
            height: 1.18in;
            border-bottom: 1px solid #222222;
            padding: 4px 5px;
            vertical-align: top;
        }

        /* Estimated Time */
        .estimated-row td {
            border-bottom: 1px solid #222222;
            padding: 3.5px 5px;
            vertical-align: middle;
        }

        /* Priority Row */
        .priority-table td {
            border-bottom: 1px solid #222222;
            border-right: 1px solid #555555;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
        }

        .priority-table td:first-child {
            text-align: left;
            padding-left: 5px;
        }

        .priority-table td:last-child {
            border-right: 0;
        }

        .check-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #111111;
            text-align: center;
            line-height: 9px;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 7.5pt;
            font-weight: bold;
            vertical-align: middle;
        }

        /* Approval Signatories Table */
        .approval-table th,
        .approval-table td {
            border-bottom: 1px solid #222222;
            border-right: 1px solid #222222;
            padding: 3px 4px;
            vertical-align: middle;
        }

        .approval-table th:last-child,
        .approval-table td:last-child {
            border-right: 0;
        }

        .approval-table th {
            text-align: center;
            font-size: 6.3pt;
            font-weight: bold;
            height: 0.21in;
        }

        .approval-table td {
            height: 0.22in;
        }

        .text-center {
            text-align: center;
        }

        .form-footer {
            padding: 2px 5px;
            font-size: 5pt;
            color: #333333;
        }

        /* Scissors Cut Divider Between Top and Bottom Copies */
        .cut-divider {
            width: 100%;
            margin: 0.11in 0;
            text-align: center;
            border-bottom: 1px dashed #666666;
            line-height: 0.1em;
        }

        .cut-divider span {
            background: #ffffff;
            padding: 0 6px;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 9pt;
            color: #333333;
        }
    </style>
</head>
<body>

    @php
        $rawClassification = strtoupper(trim((string) ($ticket->classification ?? '')));

        $priority = match ($rawClassification) {
            'HIGH', 'H', '3'          => 'HIGH',
            'MEDIUM', 'MED', 'M', '2' => 'MEDIUM',
            'LOW', 'L', '1'           => 'LOW',
            default                   => '',
        };

        $kindOfRequest = trim(
            ($ticket->category?->requestType?->request_type_name ?? '') .
            ($ticket->category?->category_name ? ' - ' . $ticket->category->category_name : '')
        );

        $requestedBy = $ticket->requested_by ?? $ticket->creator->name ?? '';
    @endphp

    @for ($copy = 0; $copy < 2; $copy++)
        <div class="form-box">
            <!-- MASTHEAD -->
            <table class="masthead">
                <tr>
                    <td class="logo-left">
                        @if(file_exists(public_path('img/neust.png')))
                            <img src="{{ public_path('img/neust.png') }}" alt="NEUST Logo">
                        @endif
                    </td>
                    <td class="masthead-center">
                        <div class="republic">Republic of the Philippines</div>
                        <div class="school">NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY</div>
                    </td>
                    <td class="logo-right">
                        @if(file_exists(public_path('img/mis.png')))
                            <img src="{{ public_path('img/mis.png') }}" alt="NEUST MIS Logo">
                        @endif
                    </td>
                </tr>
            </table>

            <div class="system-band">Management Information System</div>
            <div class="form-title">SERVICE REQUEST FORM</div>

            <!-- TOP FIELDS -->
            <table class="fields-table">
                <tr>
                    <td class="border-right" style="width: 63%;">
                        DEPARTMENT: <span class="field-val">{{ $ticket->department->department_name ?? '' }}</span>
                    </td>
                    <td style="width: 37%;">
                        CTRL NO.: <span class="field-val">{{ $ticket->ticket_number ?? '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="border-right">
                        REQUESTED BY: <span class="field-val">{{ $requestedBy }}</span>
                    </td>
                    <td>
                        CAMPUS: <span class="field-val">{{ $ticket->department->campus->campus_name ?? '' }}</span>
                    </td>
                </tr>
            </table>

            <!-- KIND OF REQUEST -->
            <table class="kind-row">
                <tr>
                    <td>
                        KIND OF REQUEST: <span class="field-val">{{ $kindOfRequest }}</span>
                    </td>
                </tr>
            </table>

            <!-- REMARKS -->
            <div class="remarks-box">
                <b>REMARKS:</b> {{ $ticket->remarks ?? '' }}
                @if(!empty($ticket->action_taken))
                    <div style="margin-top: 4px;">
                        <b>ACTION TAKEN:</b> {{ $ticket->action_taken }}
                    </div>
                @endif
            </div>

            <!-- ESTIMATED TIME -->
            <table class="estimated-row">
                <tr>
                    <td>
                        ESTIMATED TIME: <span class="field-val">{{ $ticket->estimated_time ?? '' }}</span>
                    </td>
                </tr>
            </table>

            <!-- PRIORITY (BASED ON CLASSIFICATION) -->
            <table class="priority-table">
                <colgroup>
                    <col style="width: 24%;">
                    <col style="width: 6%;">
                    <col style="width: 19%;">
                    <col style="width: 6%;">
                    <col style="width: 20%;">
                    <col style="width: 6%;">
                    <col style="width: 19%;">
                </colgroup>
                <tr>
                    <td>PRIORITY</td>
                    <td><span class="check-box">{{ $priority === 'HIGH' ? '✓' : '' }}</span></td>
                    <td>HIGH</td>
                    <td><span class="check-box">{{ $priority === 'MEDIUM' ? '✓' : '' }}</span></td>
                    <td>MEDIUM</td>
                    <td><span class="check-box">{{ $priority === 'LOW' ? '✓' : '' }}</span></td>
                    <td>LOW</td>
                </tr>
            </table>

            <!-- APPROVAL & ASSIGNMENT TABLE -->
            <table class="approval-table">
                <colgroup>
                    <col style="width: 19%;">
                    <col style="width: 28%;">
                    <col style="width: 27%;">
                    <col style="width: 18%;">
                    <col style="width: 8%;">
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th>BY: (EMPLOYEE NAME)</th>
                        <th>DESIGNATION</th>
                        <th>SIGNATURE</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>APPROVED</td>
                        <td>KATHLEEN ANNE R. ESBIETO</td>
                        <td>Asst. Director, MIS</td>
                        <td></td>
                        <td class="text-center">{{ optional($ticket->created_at)->format('m/d/y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>WORK ASSIGNED TO</td>
                        <td>{{ $ticket->assignee->name ?? '' }}</td>
                        <td>{{ $ticket->assignee->position ?? '' }}</td>
                        <td></td>
                        <td class="text-center">{{ optional($ticket->created_at)->format('m/d/y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>ACKNOWLEDGED</td>
                        <td>{{ $requestedBy }}</td>
                        <td>{{ $ticket->creator->position ?? '' }}</td>
                        <td></td>
                        <td class="text-center">{{ optional($ticket->updated_at)->format('m/d/y') ?? '' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="form-footer">NEUST-MIS-F001</div>
        </div>

        @if ($copy === 0)
            <div class="cut-divider"><span>✂</span></div>
        @endif
    @endfor

</body>
</html>