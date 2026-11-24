<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NEUST Service Order Slip</title>
    <style>
        @page {
            size: A5 portrait;
            margin: 0.16in 0.20in 0.36in 0.20in;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            font-size: 6pt;
            line-height: 1.15;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Masthead */
        .masthead {
            width: 94%;
            margin: 0 auto;
        }

        .masthead td {
            vertical-align: middle;
            text-align: center;
        }

        .seal {
            width: 0.54in;
        }

        .seal img {
            width: 0.50in;
            height: 0.50in;
            display: inline-block;
        }

        .republic {
            font-size: 5.2pt;
        }

        .school {
            font-size: 7pt;
            font-weight: bold;
            line-height: 1.1;
        }

        .campus {
            font-size: 5pt;
        }

        .unit {
            text-align: center;
            font-size: 6.1pt;
            font-weight: bold;
            margin-top: 3px;
        }

        .title {
            margin-top: 2px;
            text-align: center;
            background-color: #b9e7f5;
            border: 1px solid #9ed9e9;
            font-size: 7.8pt;
            font-weight: bold;
            padding: 2px 0;
        }

        /* Form Sections */
        .box {
            border: 1px solid #222;
            margin-top: 3px;
        }

        .top-row {
            border: 1px solid #222;
            border-top: 0;
            padding: 2px 4px;
            line-height: 1.2;
        }

        .band {
            background-color: #ffd900;
            border-bottom: 1px solid #222;
            text-align: center;
            font-size: 6.3pt;
            font-weight: bold;
            padding: 2px;
            line-height: 1.1;
        }

        .hint {
            display: block;
            font-size: 4.8pt;
            font-style: italic;
            font-weight: normal;
            margin-top: 1px;
        }

        .grid-table > tbody > tr > td {
            border-bottom: 1px solid #555;
            padding: 2px 4px;
            vertical-align: middle;
            line-height: 1.2;
        }

        .grid-table > tbody > tr:last-child > td {
            border-bottom: 0;
        }

        .border-right {
            border-right: 1px solid #555;
        }

        .val {
            font-weight: bold;
            color: #000;
        }

        /* Checkboxes */
        .check {
            display: inline-block;
            width: 7.5px;
            height: 7.5px;
            border: 1px solid #222;
            text-align: center;
            line-height: 7px;
            font-size: 6px;
            font-weight: bold;
            font-family: DejaVu Sans, Arial, sans-serif;
            vertical-align: middle;
            margin-right: 2px;
        }

        .scope-table td {
            width: 25%;
            padding: 2px 3px;
            font-size: 5.4pt;
            line-height: 1.15;
            vertical-align: middle;
        }

        .purpose-box {
            min-height: 0.36in;
            padding: 2.5px 4px;
            vertical-align: top;
            line-height: 1.2;
        }

        /* Signatures */
        .sig-table td {
            width: 50%;
            padding: 2px 6px 2px;
            text-align: center;
            font-size: 5.3pt;
            font-style: italic;
            vertical-align: bottom;
        }

        .sig-line {
            border-bottom: 1px solid #444;
            min-height: 0.15in;
            margin: 2px 6px 2px;
            padding-top: 2px;
            font-style: normal;
            font-weight: bold;
            font-size: 5.5pt;
            line-height: 1.1;
        }

        .sig-caption {
            font-size: 4.8pt;
            line-height: 1.1;
        }

        /* Materials */
        .materials-lines td {
            height: 0.12in;
            border-bottom: 1px solid #888;
            padding: 0;
        }

        .materials-lines td.col-line {
            width: 31%;
        }

        .materials-lines td.spacer {
            width: 3.5%;
            border-bottom: 0;
        }

        /* Completion Sub-tables */
        .status-table td {
            border-bottom: 1px solid #555;
            font-weight: bold;
            font-size: 5.3pt;
            padding: 2px 3px;
            line-height: 1.15;
        }

        .status-table tr:last-child td {
            border-bottom: 0;
        }

        .sat-table td {
            padding: 2px 3px;
            line-height: 1.2;
        }

        .sat-table tr:first-child td {
            border-bottom: 1px solid #555;
            font-size: 5.1pt;
            font-weight: bold;
        }

        .sat-table tr:last-child td {
            border-bottom: 0;
            font-style: italic;
            font-size: 5.3pt;
            min-height: 0.18in;
            vertical-align: top;
        }

        .footer {
            position: fixed;
            bottom: -0.24in;
            left: 0;
            font-size: 4.8pt;
            line-height: 1.2;
        }
    </style>
</head>
<body>
@php
    $rawCategory = trim($ticket->category?->category_name ?? $ticket->category?->name ?? '');
    $categoryUpper = strtoupper($rawCategory);
    $categoryNorm = preg_replace('/[^A-Z0-9]+/', ' ', $categoryUpper);
    $categoryNorm = trim(preg_replace('/\s+/', ' ', $categoryNorm));

    $scopes = [
        [
            'label'    => 'ELECTRICAL',
            'keywords' => ['ELECTRICAL', 'ELECTRIC', 'WIRING', 'OUTLET', 'BREAKER', 'LIGHTING', 'LIGHT'],
            'checked'  => false,
        ],
        [
            'label'    => 'PLUMBING',
            'keywords' => ['PLUMBING', 'PLUMBER', 'FAUCET', 'PIPE', 'DRAIN', 'TOILET', 'SINK', 'WATER LINE'],
            'checked'  => false,
        ],
        [
            'label'    => 'IRON WORKS',
            'keywords' => ['IRON WORKS', 'IRONWORKS', 'IRON', 'WELDING', 'STEEL', 'METAL', 'GRILL', 'GATE'],
            'checked'  => false,
        ],
        [
            'label'    => 'CLEANING/SANITATION',
            'keywords' => ['CLEANING/SANITATION', 'CLEANING', 'SANITATION', 'SANITIZE', 'JANITORIAL', 'DISINFECT'],
            'checked'  => false,
        ],
        [
            'label'    => 'CARPENTRY',
            'keywords' => ['CARPENTRY', 'CARPENTER', 'WOOD', 'DOOR', 'WINDOW', 'CABINET', 'TABLE', 'CHAIR'],
            'checked'  => false,
        ],
        [
            'label'    => 'PAINTING',
            'keywords' => ['PAINTING', 'PAINT', 'REPAINT', 'COATING'],
            'checked'  => false,
        ],
        [
            'label'    => 'AIR CONDITIONING',
            'keywords' => ['AIR CONDITIONING', 'AIRCONDITIONING', 'AIRCON', 'AIR CON', 'HVAC', 'SPLIT TYPE', 'WINDOW TYPE'],
            'checked'  => false,
        ],
        [
            'label'    => 'OTHERS',
            'keywords' => ['OTHERS', 'OTHER', 'MISC', 'MISCELLANEOUS'],
            'checked'  => false,
        ],
    ];

    $matchedFixedScope = false;

    if ($categoryNorm !== '') {
        foreach ($scopes as &$scope) {
            if ($scope['label'] === 'OTHERS') {
                continue;
            }

            foreach ($scope['keywords'] as $kw) {
                $kwNorm = trim(preg_replace('/\s+/', ' ', preg_replace('/[^A-Z0-9]+/', ' ', $kw)));
                if ($kwNorm !== '' && (
                    $categoryNorm === $kwNorm ||
                    str_contains(" {$categoryNorm} ", " {$kwNorm} ") ||
                    str_contains($categoryNorm, $kwNorm)
                )) {
                    $scope['checked'] = true;
                    $matchedFixedScope = true;
                    break;
                }
            }
        }
        unset($scope);

        if (!$matchedFixedScope) {
            $scopes[7]['checked'] = true;
        }
    }

    // Status handling
    $rawStatus = strtoupper(trim($ticket->status ?? ''));
    $isCompleted = in_array($rawStatus, ['COMPLETED', 'COMPLETE', 'RESOLVED', 'CLOSED', 'DONE']);
    $isPending   = in_array($rawStatus, ['PENDING', 'ON HOLD', 'ON_HOLD']);
    $isCancelled = in_array($rawStatus, ['CANCELLED', 'CANCELED']);

    $pendingRemarks = trim($ticket->pending_remarks ?? '');
    $inspectionDate = '';
    if ($isPending) {
        $dateSource = $ticket->inspection_date
            ?? $ticket->pending_at
            ?? $ticket->updated_at
            ?? $ticket->created_at;
        $inspectionDate = $dateSource ? \Carbon\Carbon::parse($dateSource)->format('M d, Y') : '';
    }
    $findingsText = $isPending ? $pendingRemarks : '';
    $remarksText  = $isPending ? $pendingRemarks : '';

    // Request & personnel details
    $requesterName = trim($ticket->creator?->full_name ?? $ticket->creator?->name ?? '');
    $assigneeName  = trim($ticket->assignee?->full_name ?? $ticket->assignee?->name ?? '');
    $campusName    = trim($ticket->department?->campus?->campus_name ?? $ticket->department?->campus?->name ?? $ticket->campus?->name ?? '');
    $deptName      = trim(
        $ticket->department?->department_name
        ?? $ticket->department?->name
        ?? $ticket->office_name
        ?? $ticket->office
        ?? ''
    );
    $designation   = trim($ticket->creator?->position ?? $ticket->creator?->designation ?? '');
    $contactNo     = trim($ticket->contact_number ?? $ticket->creator?->contact_number ?? $ticket->creator?->phone ?? '');
    $details       = trim($ticket->description ?? $ticket->details ?? $ticket->subject ?? '');
    $orderNo       = $ticket->ticket_number ?? $ticket->ticket_id;
@endphp

    <!-- Header -->
    <table class="masthead">
        <tr>
            <td class="seal" style="text-align: right;">
                <img src="{{ public_path('img/neust.png') }}" alt="NEUST Logo">
            </td>
            <td>
                <div class="republic">Republic of the Philippines</div>
                <div class="school">NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY</div>
                <div class="campus">Cabanatuan City, Nueva Ecija</div>
            </td>
            <td class="seal" style="text-align: left;">
                <img src="{{ public_path('img/abmgs.png') }}" alt="ABMGS Logo">
            </td>
        </tr>
    </table>

    <div class="unit">AUXILIARY-BUILDING MAINTENANCE AND GENERAL SERVICES</div>
    <div class="title">SERVICE ORDER SLIP</div>

    <div class="top-row">
        <b>Service Order No.:</b> <span class="val">{{ $orderNo }}</span>
    </div>

    <!-- Section 1: Request Details -->
    <div class="box">
        <div class="band">
            REQUEST DETAILS
            <span class="hint">(To be filled out by requesting personnel)</span>
        </div>
        <table class="grid-table">
            <tr>
                <td class="border-right" style="width: 55%;">
                    Date of Request: <span class="val">{{ optional($ticket->created_at)->format('M d, Y') }}</span>
                </td>
                <td style="width: 45%;">
                    Campus: <span class="val">{{ $campusName }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Office/Department: <span class="val">{{ $deptName }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Name of Requesting Personnel: <span class="val">{{ $requesterName }}</span>
                </td>
            </tr>
            <tr>
                <td class="border-right">
                    Position/Designation: <span class="val">{{ $designation }}</span>
                </td>
                <td>
                    Contact Number: <span class="val">{{ $contactNo }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; padding: 1.5px 4px;">
                    SCOPE OF WORK
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 1.5px 3px;">
                    <table class="scope-table">
                        @foreach(array_chunk($scopes, 4) as $row)
                            <tr>
                                @foreach($row as $item)
                                    <td>
                                        <span class="check">{!! $item['checked'] ? '&#10003;' : '&nbsp;' !!}</span><span>{{ $item['label'] }}</span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="purpose-box">
                    <b><i>DETAILS/PURPOSE:</i></b>
                    @if(!$matchedFixedScope && $rawCategory !== '')
                        <span class="val">[{{ $rawCategory }}]</span>
                    @endif
                    <span class="val" style="font-style: normal;">{{ $details }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 0;">
                    <table class="sig-table">
                        <tr>
                            <td class="border-right">
                                <b>Requested by:</b>
                                <div class="sig-line">{{ $requesterName !== '' ? strtoupper($requesterName) : '&nbsp;' }}</div>
                                <div class="sig-caption">Signature of Requesting Personnel</div>
                            </td>
                            <td>
                                <b>Approved by:</b>
                                <div class="sig-line">&nbsp;</div>
                                <div class="sig-caption">Director, ABMGS/Authorized Personnel</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Section 2: Pre-Inspection -->
    <div class="box">
        <div class="band">
            PRE-INSPECTION AND REPAIR DETAILS
            <span class="hint">(To be filled out by ABMGS Personnel)</span>
        </div>
        <table class="grid-table">
            <tr>
                <td class="border-right" style="width: 55%;">
                    Inspection Date: <span class="val">{{ $inspectionDate }}</span>
                </td>
                <td style="width: 45%;">Mode of Repair:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 0.20in; vertical-align: top;">
                    <b>Findings:</b> <span class="val">{{ $findingsText }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 2px 4px 3px;">
                    <div style="font-weight: bold; margin-bottom: 1px;">Materials Needed:</div>
                    <table class="materials-lines">
                        <tr>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                        </tr>
                        <tr>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                        </tr>
                        <tr>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                            <td class="spacer"></td>
                            <td class="col-line"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 0.18in; vertical-align: top;">
                    <b>Recommendation:</b>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 2px 4px;">
                    <i>Inspected by:</i>
                    <div style="width: 50%; margin: 1px auto 0; text-align: center;">
                        <div style="border-bottom: 1px solid #555; min-height: 0.12in; font-weight: bold; font-size: 5.4pt;">
                            {{ $assigneeName !== '' ? strtoupper($assigneeName) : '&nbsp;' }}
                        </div>
                        <div style="font-size: 4.8pt; font-style: italic; padding-top: 1px;">
                            Name and Signature of Assigned Technician
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Section 3: Completion -->
    <div class="box">
        <div class="band">SERVICE ORDER COMPLETION</div>
        <table class="grid-table">
            <tr>
                <td class="border-right" style="width: 20%; padding: 0; vertical-align: top;">
                    <table class="status-table">
                        <tr>
                            <td><span class="check">{!! $isCompleted ? '&#10003;' : '&nbsp;' !!}</span>COMPLETED</td>
                        </tr>
                        <tr>
                            <td><span class="check">{!! $isPending ? '&#10003;' : '&nbsp;' !!}</span>PENDING</td>
                        </tr>
                        <tr>
                            <td><span class="check">{!! $isCancelled ? '&#10003;' : '&nbsp;' !!}</span>CANCELLED</td>
                        </tr>
                    </table>
                </td>
                <td class="border-right" style="width: 23%; vertical-align: top;">
                    Remarks: @if($remarksText !== '')<span class="val">{{ $remarksText }}</span>@endif
                </td>
                <td style="width: 57%; padding: 0; vertical-align: top;">
                    <table class="sat-table">
                        <tr>
                            <td>
                                Client Satisfactory:<br>
                                <span style="font-weight: normal; font-size: 4.8pt;">
                                    <span class="check">&nbsp;</span>VERY SATISFIED&nbsp;
                                    <span class="check">&nbsp;</span>SATISFIED&nbsp;
                                    <span class="check">&nbsp;</span>UNSATISFIED
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Comments:</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Bottom Signatures -->
    <table style="margin-top: 4px;">
        <tr>
            <td style="width: 47%; vertical-align: top; font-size: 5.2pt; font-style: italic;">
                <div style="font-weight: bold; margin-bottom: 1px;">Serviced by:</div>
                <div class="sig-line" style="text-align: center;">
                    {{ $assigneeName !== '' ? strtoupper($assigneeName) : '&nbsp;' }}
                </div>
                <div class="sig-caption" style="text-align: center;">Name and Signature of Assigned Technician</div>
                <div style="margin-top: 3px;">
                    Date: <span style="display: inline-block; width: 78%; border-bottom: 1px solid #555;">&nbsp;</span>
                </div>
            </td>
            <td style="width: 6%;"></td>
            <td style="width: 47%; vertical-align: top; font-size: 5.2pt; font-style: italic;">
                <div style="font-weight: bold; margin-bottom: 1px;">Certified by:</div>
                <div class="sig-line" style="text-align: center;">
                    {{ $requesterName !== '' ? strtoupper($requesterName) : '&nbsp;' }}
                </div>
                <div class="sig-caption" style="text-align: center;">Name and Signature of Requesting Personnel</div>
                <div style="margin-top: 3px;">
                    Date: <span style="display: inline-block; width: 78%; border-bottom: 1px solid #555;">&nbsp;</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        NEUST-ABG-P007.F001<br>
        Rev. 00 (06.15.2026)
    </div>
</body>
</html>