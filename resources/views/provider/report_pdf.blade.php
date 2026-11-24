<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @php
        $code = strtoupper(trim($providerCode ?? 'MIS'));
        $isBmgsProvider = !empty($isBmgs) || in_array($code, ['BMGS', 'ABMGS']);
        $activeCode = $isBmgsProvider ? 'BMGS' : 'MIS';
        $activeHeading = $providerTitle ?? ($isBmgsProvider
            ? 'BUILDING MAINTENANCE AND GENERAL SERVICES'
            : 'MANAGEMENT INFORMATION SYSTEM');
        $activePrefix = $docNoPrefix ?? $activeCode;
    @endphp
    <title>NEUST {{ $activeCode }} Service Request Monthly Summary</title>
    <style>
        @page {
            size: letter portrait;
            margin: 0.25in 0.25in 0.25in 0.25in;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            color: #111;
            font-size: 9pt;
        }

        .page {
            position: relative;
            width: 100%;
            height: 10.45in;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.05in;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo-cell {
            width: 1.8in;
            text-align: right;
            padding-right: 10px;
        }

        .logo-cell img {
            width: 0.65in;
            height: 0.55in;
            object-fit: contain;
        }

        .title-cell {
            text-align: center;
            width: 4.4in;
        }

        .spacer-cell {
            width: 1.8in;
            text-align: left;
            padding-left: 10px;
        }

        .spacer-cell img {
            width: 0.65in;
            height: 0.55in;
            object-fit: contain;
        }

        .republic {
            font-size: 9pt;
            line-height: 1.05;
        }

        .school {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.1;
        }

        .location {
            font-size: 9pt;
            margin-top: 2px;
        }

        .department {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 0.16in;
            line-height: 1.25;
        }

        .subtitle {
            text-align: center;
            font-size: 10pt;
            margin-top: 2px;
        }

        .month {
            text-align: center;
            margin-top: 4px;
            font-size: 10pt;
        }

        .month-line {
            display: inline-block;
            min-width: 1.5in;
            border-bottom: 1px solid #222;
            padding: 0 6px 1px;
            text-align: center;
            font-weight: bold;
        }

        table.grid-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        .main-table {
            margin-top: 0.09in;
            font-size: 8pt;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #222;
            overflow: hidden;
            word-wrap: break-word;
        }

        .main-table th {
            height: 0.38in;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            padding: 2px;
        }

        .main-table td {
            height: 0.185in;
            padding: 1px 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .action-table {
            margin-top: 0.16in;
            font-size: 8pt;
        }

        .action-table th,
        .action-table td {
            border: 1px solid #222;
            padding: 2px 4px;
        }

        .action-table th {
            height: 0.36in;
            text-align: center;
            vertical-align: middle;
        }

        .action-table td {
            height: 0.23in;
            vertical-align: middle;
        }

        .footer {
            position: absolute;
            left: 0;
            bottom: 0;
            font-size: 7pt;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    @foreach ($pages as $pageTickets)
        <div class="page">
            <!-- HEADER -->
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if (file_exists(public_path('img/neust.png')))
                            <img src="{{ public_path('img/neust.png') }}" alt="NEUST Logo">
                        @elseif (file_exists(public_path('neust.png')))
                            <img src="{{ public_path('neust.png') }}" alt="NEUST Logo">
                        @endif
                    </td>
                    <td class="title-cell">
                        <div class="republic">Republic of the Philippines</div>
                        <div class="school">NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY</div>
                        <div class="location">Nueva Ecija, Philippines</div>
                    </td>
                    <td class="spacer-cell">
                        @if ($isBmgsProvider && file_exists(public_path('images/abmgs.png')))
                            <img src="{{ public_path('images/abmgs.png') }}" alt="BMGS Logo">
                        @elseif ($isBmgsProvider && file_exists(public_path('abmgs.png')))
                            <img src="{{ public_path('abmgs.png') }}" alt="BMGS Logo">
                        @endif
                    </td>
                </tr>
            </table>

            <div class="department">{{ $activeHeading }}</div>
            <div class="subtitle">Monthly Summary of {{ $activeCode }} Service Request</div>
            <div class="month">
                For the month of <span class="month-line">{{ $monthLabel }}</span>
            </div>

            <!-- MAIN TICKETS TABLE (37 ROWS PER PAGE) -->
            <table class="grid-table main-table">
                <colgroup>
                    <col style="width:18%">
                    <col style="width:18%">
                    <col style="width:18%">
                    <col style="width:18%">
                    <col style="width:9%">
                    <col style="width:19%">
                </colgroup>
                <thead>
                    <tr>
                        <th>{{ $activePrefix }}SR NO.</th>
                        <th>REQUESTED</th>
                        <th>APPROVED</th>
                        <th>WORK ASSIGNED<br>TO</th>
                        <th>DATE<br>GIVEN</th>
                        <th>DATE ACQUIRED</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pageTickets as $ticket)
                        <tr>
                            <td class="text-center">{{ $ticket->ticket_number ?? ('#' . $ticket->ticket_id) }}</td>
                            <td>{{ $ticket->requested_by ?? ($ticket->creator?->name ?? '-') }}</td>
                            <td>
                                {{ $ticket->approver?->name
                                    ?? (is_string($ticket->approved_by) && !is_numeric($ticket->approved_by)
                                        ? $ticket->approved_by
                                        : ($ticket->status !== 'For Approval' ? 'Approved' : '')) }}
                            </td>
                            <td>{{ $ticket->assignee?->name ?? '' }}</td>
                            <td class="text-center">
                                {{ $ticket->created_at ? $ticket->created_at->format('m/d/y') : '' }}
                            </td>
                            <td class="text-center">
                                {{ $ticket->updated_at && in_array($ticket->status, ['Completed', 'Acknowledged']) ? $ticket->updated_at->format('m/d/y') : '' }}
                            </td>
                        </tr>
                    @endforeach

                    {{-- Pad remaining blank rows up to 37 rows to preserve exact form height --}}
                    @for ($i = $pageTickets->count(); $i < $rowsPerPage; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <!-- SIGNATORY / ACTION TABLE -->
            <table class="grid-table action-table">
                <colgroup>
                    <col style="width:18%">
                    <col style="width:28%">
                    <col style="width:27%">
                    <col style="width:18%">
                    <col style="width:9%">
                </colgroup>
                <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>BY: (EMPLOYEE NAME)</th>
                        <th>POSITION/DESIGNATION</th>
                        <th>SIGNATURE</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PREPARED</td>
                        <td>{{ $preparedBy }}</td>
                        <td>{{ $preparedPos }}</td>
                        <td></td>
                        <td class="text-center">{{ $dateToday }}</td>
                    </tr>
                    <tr>
                        <td>VERIFIED</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- DOCUMENT CONTROL FOOTER -->
            <div class="footer">
                NEUST-{{ $activePrefix }}-F011<br>Rev. 00 (09.12.18)
            </div>
        </div>
    @endforeach
</body>

</html>