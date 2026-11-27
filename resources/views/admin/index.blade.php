<x-admin-layout>
    <style>
        .admin-dash-wrap {
            padding: 24px 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .admin-dash-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .admin-dash-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-dash-icon {
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.18);
        }

        .admin-dash-title {
            margin: 0;
            font-size: 21px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.3px;
        }

        .admin-dash-subtitle {
            margin: 4px 0 0;
            font-size: 13px;
            color: #6b7280;
        }

        .admin-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);
        }

        .admin-btn-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .admin-btn-light {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .admin-btn-light:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* 4-Column Horizontal KPI Row */
        .admin-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        @media (max-width: 1199px) {
            .admin-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .admin-kpi-grid {
                grid-template-columns: 1fr;
            }
        }

        .admin-kpi-card {
            background: #ffffff;
            border: 1px solid #e9edf3;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.02), 0 6px 18px rgba(16, 24, 40, 0.03);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .admin-kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(16, 24, 40, 0.06);
        }

        .admin-kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .admin-kpi-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .admin-kpi-badge {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-kpi-badge svg {
            width: 18px;
            height: 18px;
        }

        .tone-blue { background: #eff6ff; color: #2563eb; }
        .tone-amber { background: #fffbeb; color: #d97706; }
        .tone-sky { background: #f0f9ff; color: #0284c7; }
        .tone-emerald { background: #ecfdf5; color: #059669; }
        .tone-slate { background: #f1f5f9; color: #475569; }

        .admin-kpi-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .admin-kpi-meta {
            font-size: 12px;
            color: #94a3b8;
        }

        /* Two-column grids */
        .admin-split-8-4 {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: 16px;
        }

        .admin-split-5-7 {
            display: grid;
            grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
            gap: 16px;
        }

        @media (max-width: 991px) {
            .admin-split-8-4,
            .admin-split-5-7 {
                grid-template-columns: 1fr;
            }
        }

        .admin-card {
            background: #ffffff;
            border: 1px solid #e9edf3;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.02), 0 8px 24px rgba(16, 24, 40, 0.04);
            height: 100%;
        }

        .admin-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid #eef1f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .admin-card-title {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }

        .admin-card-subtitle {
            margin: 2px 0 0;
            font-size: 12px;
            color: #9ca3af;
        }

        .admin-card-body {
            padding: 20px 22px;
        }

        .admin-chart-box {
            position: relative;
            height: 270px;
            width: 100%;
        }

        .admin-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .admin-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 18px;
            border-bottom: 1px solid #e9edf3;
            white-space: nowrap;
            text-align: left;
        }

        .admin-table thead th.text-right {
            text-align: right;
        }

        .admin-table tbody td {
            padding: 13px 18px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .admin-table tbody td.text-right {
            text-align: right;
        }

        .admin-table tbody tr:hover {
            background: #f8fbff;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .pill-approval { background: #fffbeb; color: #b45309; }
        .pill-accepted { background: #eff6ff; color: #1d4ed8; }
        .pill-progress { background: #f0f9ff; color: #0369a1; }
        .pill-pending { background: #f1f5f9; color: #334155; }
        .pill-done { background: #ecfdf5; color: #047857; }
        .pill-default { background: #f3f4f6; color: #374151; }

        .admin-badge-count {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #ecfdf5;
            color: #047857;
        }
    </style>

    <div class="admin-dash-wrap">
        <!-- HEADER -->
        <div class="admin-dash-header">
            <div class="admin-dash-header-left">
                <div class="admin-dash-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 12l3 -2" />
                        <path d="M12 7v5" />
                    </svg>
                </div>
                <div>
                    <h1 class="admin-dash-title">IT Service Desk Dashboard</h1>
                    <p class="admin-dash-subtitle">
                        NEUST Ticketing System &bull; Overview of service requests &amp; ticket statuses
                    </p>
                </div>
            </div>

            @if (Route::has('admin.ticket.index'))
                <a href="{{ route('admin.ticket.index') }}" class="admin-btn-primary">
                    <span>View All Tickets</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            @endif
        </div>

        @php
            $activeTotal = (int) $accepted + (int) $workInProgress + (int) $pending;
            $resolvedTotal = (int) $completed + (int) $acknowledged;

            $kpis = [
                [
                    'label' => 'For Approval',
                    'value' => number_format((int) $forApproval),
                    'meta'  => number_format((int) $totalTickets) . ' total requests',
                    'icon'  => 'hourglass',
                    'tone'  => 'tone-amber',
                ],
                [
                    'label' => 'Accepted & In Progress',
                    'value' => number_format((int) $accepted + (int) $workInProgress),
                    'meta'  => number_format((int) $accepted) . ' accepted &bull; ' . number_format((int) $workInProgress) . ' working',
                    'icon'  => 'tools',
                    'tone'  => 'tone-blue',
                ],
                [
                    'label' => 'Pending',
                    'value' => number_format((int) $pending),
                    'meta'  => 'On hold / awaiting action',
                    'icon'  => 'pause',
                    'tone'  => 'tone-sky',
                ],
                [
                    'label' => 'Completed & Acknowledged',
                    'value' => number_format($resolvedTotal),
                    'meta'  => number_format((int) $completed) . ' completed &bull; ' . number_format((int) $acknowledged) . ' aknowledged',
                    'icon'  => 'check',
                    'tone'  => 'tone-emerald',
                ],
            ];
        @endphp

        <!-- HORIZONTAL 4-CARD KPI ROW -->
        <section class="admin-kpi-grid">
            @foreach ($kpis as $kpi)
                <div class="admin-kpi-card">
                    <div class="admin-kpi-top">
                        <span class="admin-kpi-label">{{ $kpi['label'] }}</span>
                        <div class="admin-kpi-badge {{ $kpi['tone'] }}">
                            @switch($kpi['icon'])
                                @case('hourglass')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M5 22h14M5 2h14M17 2v4a5 5 0 0 1-5 5 5 5 0 0 1-5-5V2M17 22v-4a5 5 0 0 0-5-5 5 5 0 0 0-5 5v4" />
                                    </svg>
                                    @break
                                @case('tools')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                                    </svg>
                                    @break
                                @case('pause')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M10 9v6M14 9v6" />
                                    </svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="m8 12 2.5 2.5L16 9" />
                                    </svg>
                            @endswitch
                        </div>
                    </div>
                    <div class="admin-kpi-value">{{ $kpi['value'] }}</div>
                    <div class="admin-kpi-meta">{!! $kpi['meta'] !!}</div>
                </div>
            @endforeach
        </section>

        <!-- CHARTS ROW -->
        <section class="admin-split-8-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Monthly Requests</h2>
                        <p class="admin-card-subtitle">Ticket counts over the last 6 months</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    <div class="admin-chart-box">
                        <canvas id="adminMonthlyChart" aria-label="Monthly requests chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Ticket Status Breakdown</h2>
                        <p class="admin-card-subtitle">Current state of requests in NEUST</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    @if ((int) $totalTickets === 0)
                        <p class="admin-dash-subtitle" style="text-align:center; padding: 60px 0;">No service requests recorded yet.</p>
                    @else
                        <div class="admin-chart-box">
                            <canvas id="adminStatusChart" aria-label="Ticket status breakdown chart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- STATUS SUMMARY + RECENT TICKETS -->
        <section class="admin-split-5-7">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Status Summary</h2>
                        <p class="admin-card-subtitle">Counts across all ticket statuses</p>
                    </div>
                    <span class="admin-badge-count">{{ number_format((int) $totalTickets) }}</span>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statusLabels as $idx => $statusName)
                                @php
                                    $pillClass = match ($statusName) {
                                        'For Approval'     => 'pill-approval',
                                        'Accepted'         => 'pill-accepted',
                                        'Work In Progress' => 'pill-progress',
                                        'Pending'          => 'pill-pending',
                                        'Completed',
                                        'Aknowledged'      => 'pill-done',
                                        default            => 'pill-default',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="admin-pill {{ $pillClass }}">{{ $statusName }}</span>
                                    </td>
                                    <td class="text-right" style="font-weight: 700; color: #111827;">
                                        {{ number_format((int) ($statusValues[$idx] ?? 0)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Recent Service Requests</h2>
                        <p class="admin-card-subtitle">Latest tickets submitted in NEUST Ticketing System</p>
                    </div>
                    @if (Route::has('admin.ticket.index'))
                        <a href="{{ route('admin.ticket.index') }}" class="admin-btn-light">View All</a>
                    @endif
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestTickets as $ticket)
                                @php
                                    $badgeClass = match ($ticket->status) {
                                        'For Approval'     => 'pill-approval',
                                        'Accepted'         => 'pill-accepted',
                                        'Work In Progress' => 'pill-progress',
                                        'Pending'          => 'pill-pending',
                                        'Completed',
                                        'Aknowledged'      => 'pill-done',
                                        default            => 'pill-default',
                                    };
                                @endphp
                                <tr>
                                    <td style="font-weight: 600; color: #111827; white-space: nowrap;">
                                        {{ $ticket->ticket_number ?? ('#' . $ticket->ticket_id) }}
                                        <div style="font-size: 12px; font-weight: 400; color: #94a3b8;">
                                            {{ $ticket->created_at ? \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') : '-' }}
                                        </div>
                                    </td>
                                    <td>{{ $ticket->department->department_name ?? '-' }}</td>
                                    <td>{{ $ticket->category->category_name ?? '-' }}</td>
                                    <td>{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="admin-pill {{ $badgeClass }}">{{ $ticket->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 32px 18px;">
                                        No tickets recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                return;
            }

            const monthlyCtx = document.getElementById('adminMonthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($monthlyLabels),
                        datasets: [{
                            label: 'Total Requests',
                            data: @json($monthlyData),
                            backgroundColor: 'rgba(37, 99, 235, 0.85)',
                            borderRadius: 6,
                            barPercentage: 0.55
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { boxWidth: 12, font: { size: 11 } }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            const statusCtx = document.getElementById('adminStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($statusLabels),
                        datasets: [{
                            data: @json($statusValues),
                            backgroundColor: [
                                '#f59e0b',
                                '#2563eb',
                                '#0ea5e9',
                                '#64748b',
                                '#10b981',
                                '#6366f1'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '64%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, font: { size: 11 } }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-admin-layout>