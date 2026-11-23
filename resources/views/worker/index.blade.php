<x-worker>

@push('styles')
<style>
    .dash-page { padding: 8px; }

    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .dash-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .dash-header-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .18);
    }

    .dash-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.3px;
    }

    .dash-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    /* KPI Cards */
    .kpi-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .02), 0 6px 18px rgba(16, 24, 40, .03);
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(16, 24, 40, .06);
    }

    .kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .kpi-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
    }

    .kpi-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .kpi-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 6px;
    }

    .kpi-meta {
        font-size: 12px;
        color: #94a3b8;
    }

    /* Section Cards */
    .dash-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .02), 0 8px 24px rgba(16, 24, 40, .04);
        height: 100%;
    }

    .dash-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef1f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .dash-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .dash-card-subtitle {
        font-size: 12px;
        color: #9ca3af;
        margin: 2px 0 0;
    }

    .dash-card-body {
        padding: 20px 22px;
    }

    /* Tables */
    .dash-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .dash-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 12px 18px;
        border-bottom: 1px solid #e9edf3;
        white-space: nowrap;
    }

    .dash-table tbody td {
        padding: 13px 18px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .dash-table tbody tr:hover { background: #f8fbff; }
    .dash-table tbody tr:last-child td { border-bottom: none; }

    .status-pill {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }
</style>
@endpush

<div class="dash-page">
    <!-- HEADER -->
    <div class="dash-header">
        <div class="dash-header-left">
            <div class="dash-header-icon">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div>
                <h4 class="dash-title">My Assigned Tickets Dashboard</h4>
                <p class="dash-subtitle">{{ $worker->name }} • {{ $campusName }} • Personal workload & task progress</p>
            </div>
        </div>
    </div>

    <!-- KPI ROW -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Assigned to Me</span>
                    <div class="kpi-icon bg-primary-subtle text-primary">
                        <i class="bi bi-inbox"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['total']) }}</div>
                <div class="kpi-meta">{{ number_format($stats['this_month']) }} assigned this month</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Active Tasks</span>
                    <div class="kpi-icon bg-info-subtle text-info">
                        <i class="bi bi-tools"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['active']) }}</div>
                <div class="kpi-meta">
                    {{ $stats['work_in_progress'] }} working • {{ $stats['accepted'] }} accepted
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Pending</span>
                    <div class="kpi-icon bg-warning-subtle text-warning">
                        <i class="bi bi-pause-circle"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['pending']) }}</div>
                <div class="kpi-meta">Waiting on follow-up or parts</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Completed</span>
                    <div class="kpi-icon bg-success-subtle text-success">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['done']) }}</div>
                <div class="kpi-meta">
                    @php
                        $rate = $stats['total'] > 0 ? round(($stats['done'] / $stats['total']) * 100, 1) : 0;
                    @endphp
                    {{ $rate }}% completion rate ({{ $stats['acknowledged'] }} acknowledged)
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">My Monthly Ticket Activity</h6>
                        <p class="dash-card-subtitle">Assigned vs. completed tickets over the last 6 months</p>
                    </div>
                </div>
                <div class="dash-card-body">
                    <canvas id="workerMonthlyChart" height="115"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">Status Breakdown</h6>
                        <p class="dash-card-subtitle">Distribution of your assigned tickets</p>
                    </div>
                </div>
                <div class="dash-card-body d-flex align-items-center justify-content-center">
                    @if ($statusBreakdown->isEmpty())
                        <p class="text-muted small my-5">No assigned tickets yet.</p>
                    @else
                        <canvas id="workerStatusChart" height="220"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIVE TASKS + RECENT ASSIGNED TICKETS -->
    <div class="row g-3">
        <div class="col-lg-5">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">My Active Queue</h6>
                        <p class="dash-card-subtitle">In-progress, accepted, and pending items</p>
                    </div>
                    <span class="badge bg-info-subtle text-info">{{ $activeTickets->count() }} shown</span>
                </div>

                <div class="table-responsive">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activeTickets as $ticket)
                                @php
                                    $badgeClass = match ($ticket->status) {
                                        'Accepted'         => 'bg-primary-subtle text-primary',
                                        'Work In Progress' => 'bg-info-subtle text-info',
                                        'Pending'          => 'bg-warning-subtle text-warning',
                                        default            => 'bg-light text-dark',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ $ticket->ticket_number ?? ('#' . $ticket->ticket_id) }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ $ticket->department->department_name ?? '-' }}
                                        </div>
                                    </td>
                                    <td>{{ $ticket->category->category_name ?? '-' }}</td>
                                    <td>
                                        <span class="status-pill {{ $badgeClass }}">{{ $ticket->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No active tickets assigned to you.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">Recent Assigned Tickets</h6>
                        <p class="dash-card-subtitle">Latest tickets assigned to {{ $worker->name }}</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAssignedTickets as $ticket)
                                @php
                                    $badgeClass = match ($ticket->status) {
                                        'Accepted'         => 'bg-primary-subtle text-primary',
                                        'Work In Progress' => 'bg-info-subtle text-info',
                                        'Pending'          => 'bg-warning-subtle text-warning',
                                        'Completed',
                                        'Acknowledged'     => 'bg-success-subtle text-success',
                                        default            => 'bg-light text-dark',
                                    };
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        {{ $ticket->ticket_number ?? ('#' . $ticket->ticket_id) }}
                                        <div class="small text-muted fw-normal">
                                            {{ $ticket->created_at ? $ticket->created_at->format('M d, Y') : '-' }}
                                        </div>
                                    </td>
                                    <td>{{ $ticket->department->department_name ?? '-' }}</td>
                                    <td>{{ $ticket->category->category_name ?? '-' }}</td>
                                    <td class="text-truncate" style="max-width: 180px;" title="{{ $ticket->remarks }}">
                                        {{ $ticket->remarks ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $badgeClass }}">{{ $ticket->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No tickets assigned to you yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthlyCtx = document.getElementById('workerMonthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyTrend['labels']),
                datasets: [
                    {
                        label: 'Assigned to Me',
                        data: @json($monthlyTrend['total']),
                        backgroundColor: 'rgba(37, 99, 235, 0.85)',
                        borderRadius: 6,
                        barPercentage: 0.55
                    },
                    {
                        label: 'Completed / Acknowledged',
                        data: @json($monthlyTrend['completed']),
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderRadius: 6,
                        barPercentage: 0.55
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
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

    const statusCtx = document.getElementById('workerStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($statusBreakdown->pluck('label')),
                datasets: [{
                    data: @json($statusBreakdown->pluck('count')),
                    backgroundColor: [
                        '#2563eb',
                        '#0ea5e9',
                        '#f59e0b',
                        '#10b981',
                        '#6366f1'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
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
@endpush

</x-worker>