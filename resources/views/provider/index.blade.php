<x-provider>

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
                <i class="bi bi-speedometer2"></i>
            </div>
            <div>
                <h4 class="dash-title">Service Provider Dashboard</h4>
                <p class="dash-subtitle">{{ $campusName }} • Overview of service requests & worker performance</p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('report-provider.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Generate Reports
            </a>
        </div>
    </div>

    <!-- KPI ROW -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Total Tickets</span>
                    <div class="kpi-icon bg-primary-subtle text-primary">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['total']) }}</div>
                <div class="kpi-meta">{{ number_format($stats['this_month']) }} created this month</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">For Approval</span>
                    <div class="kpi-icon bg-warning-subtle text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="kpi-value">{{ number_format($stats['for_approval']) }}</div>
                <div class="kpi-meta">{{ number_format($stats['unassigned']) }} currently unassigned</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">In Progress / Active</span>
                    <div class="kpi-icon bg-info-subtle text-info">
                        <i class="bi bi-tools"></i>
                    </div>
                </div>
                <div class="kpi-value">
                    {{ number_format($stats['accepted'] + $stats['work_in_progress'] + $stats['pending']) }}
                </div>
                <div class="kpi-meta">
                    {{ $stats['accepted'] }} accepted • {{ $stats['work_in_progress'] }} working • {{ $stats['pending'] }} pending
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Completed</span>
                    <div class="kpi-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                @php
                    $completedCount = (int) ($stats['completed'] ?? 0);
                    $totalCount = (int) ($stats['total'] ?? 0);
                    $completionRate = $stats['completion_rate']
                        ?? ($totalCount > 0 ? round(($completedCount / $totalCount) * 100, 1) : 0);
                @endphp
                <div class="kpi-value">{{ number_format($completedCount) }}</div>
                <div class="kpi-meta">
                   completed • {{ $stats['acknowledged'] ?? 0 }} acknowledged
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
                        <h6 class="dash-card-title">Monthly Ticket Volume</h6>
                        <p class="dash-card-subtitle">Created vs. completed (including acknowledged) tickets over the last 6 months</p>
                    </div>
                </div>
                <div class="dash-card-body">
                    <canvas id="monthlyTicketsChart" height="115"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">Top Request Categories</h6>
                        <p class="dash-card-subtitle">Most frequent service categories</p>
                    </div>
                </div>
                <div class="dash-card-body d-flex align-items-center justify-content-center">
                    @if ($categoryBreakdown->isEmpty())
                        <p class="text-muted small my-5">No category data available yet.</p>
                    @else
                        <canvas id="categoryDoughnutChart" height="220"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- WORKER WORKLOAD + RECENT TICKETS -->
    <div class="row g-3">
        <div class="col-lg-5">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div>
                        <h6 class="dash-card-title">Worker Workload</h6>
                        <p class="dash-card-subtitle">Assigned tickets per campus worker</p>
                    </div>
                    <span class="badge bg-light text-secondary border">{{ $workerPerformance->count() }} workers</span>
                </div>

                <div class="table-responsive">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Worker</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Done</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($workerPerformance as $worker)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $worker['name'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info-subtle text-info">{{ $worker['active'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success">{{ $worker['completed'] }}</span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $worker['total'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No workers found in this campus.</td>
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
                        <h6 class="dash-card-title">Recent Service Requests</h6>
                        <p class="dash-card-subtitle">Latest tickets submitted in {{ $campusName }}</p>
                    </div>
                    <a href="{{ route('report-provider.index') }}" class="btn btn-light btn-sm border">View All</a>
                </div>

                <div class="table-responsive">
                    <table class="dash-table">
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
                            @forelse ($recentTickets as $ticket)
                                @php
                                    $normalizedStatus = strtolower(trim($ticket->status ?? ''));
                                    $badgeClass = match ($normalizedStatus) {
                                        'for approval'     => 'bg-warning-subtle text-warning',
                                        'accepted'         => 'bg-primary-subtle text-primary',
                                        'work in progress' => 'bg-info-subtle text-info',
                                        'pending'          => 'bg-secondary-subtle text-secondary',
                                        'completed',
                                        'acknowledged'     => 'bg-success-subtle text-success',
                                        default            => 'bg-light text-dark',
                                    };
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        {{ $ticket->ticket_number ?? ('#' . $ticket->ticket_id) }}
                                        <div class="small text-muted fw-normal">
                                            {{ $ticket->created_at ? \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') : '-' }}
                                        </div>
                                    </td>
                                    <td>{{ $ticket->department->department_name ?? '-' }}</td>
                                    <td>{{ $ticket->category->category_name ?? '-' }}</td>
                                    <td>{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="status-pill {{ $badgeClass }}">{{ $ticket->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No tickets recorded yet.</td>
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
    const trendCtx = document.getElementById('monthlyTicketsChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyTrend['labels']),
                datasets: [
                    {
                        label: 'Total Requests',
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

    const catCtx = document.getElementById('categoryDoughnutChart');
    if (catCtx) {
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryBreakdown->pluck('category_name')),
                datasets: [{
                    data: @json($categoryBreakdown->pluck('total')),
                    backgroundColor: [
                        '#2563eb',
                        '#4f46e5',
                        '#0ea5e9',
                        '#10b981',
                        '#f59e0b',
                        '#64748b'
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

</x-provider>