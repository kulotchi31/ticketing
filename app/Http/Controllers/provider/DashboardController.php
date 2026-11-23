<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index()
{
    $user = auth()->user();
    $campusId   = $user?->department?->fk_campus_id;
    $providerId = $user?->fk_provider_id;

    if (!$campusId || !$providerId) {
        abort(403, 'No campus or provider associated with your account.');
    }

    // Base query scoped to authenticated provider & campus
    $baseQuery = Ticket::query()
        ->whereHas('department', function ($q) use ($campusId) {
            $q->where('fk_campus_id', $campusId);
        })
        ->whereHas('category.requestType', function ($q) use ($providerId) {
            $q->where('fk_provider_id', $providerId);
        });

    // 1. KPI Summary Counts (Acknowledged is treated as completed)
    $rawStatusCounts = (clone $baseQuery)
        ->select(DB::raw('LOWER(TRIM(status)) as normalized_status'), DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('LOWER(TRIM(status))'))
        ->pluck('total', 'normalized_status');

    $forApproval    = (int) ($rawStatusCounts['for approval'] ?? 0);
    $accepted       = (int) ($rawStatusCounts['accepted'] ?? 0);
    $workInProgress = (int) ($rawStatusCounts['work in progress'] ?? 0);
    $pending        = (int) ($rawStatusCounts['pending'] ?? 0);
    $completedOnly  = (int) ($rawStatusCounts['completed'] ?? 0);
    $acknowledged   = (int) ($rawStatusCounts['acknowledged'] ?? 0);
    $completedTotal = $completedOnly + $acknowledged;
    $totalTickets   = (int) (clone $baseQuery)->count();

    $completionRate = $totalTickets > 0
        ? round(($completedTotal / $totalTickets) * 100, 1)
        : 0;

    $stats = [
        'total'            => $totalTickets,
        'for_approval'     => $forApproval,
        'accepted'         => $accepted,
        'work_in_progress' => $workInProgress,
        'pending'          => $pending,
        'completed_only'   => $completedOnly,
        'acknowledged'     => $acknowledged,
        'completed'        => $completedTotal,
        'completion_rate'  => $completionRate,
        'unassigned'       => (clone $baseQuery)
            ->whereNull('assign_to')
            ->whereNotIn(DB::raw('LOWER(TRIM(status))'), ['completed', 'acknowledged'])
            ->count(),
        'this_month'       => (clone $baseQuery)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count(),
    ];

    // 2. Last 6 Months Ticket Trend (for Chart.js)
    $labels = [];
    $totalSeries = [];
    $completedSeries = [];

    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $labels[] = $date->format('M Y');

        $totalSeries[] = (int) (clone $baseQuery)
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        $completedSeries[] = (int) (clone $baseQuery)
            ->whereIn(DB::raw('LOWER(TRIM(status))'), ['completed', 'acknowledged'])
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
    }

    $monthlyTrend = [
        'labels'    => $labels,
        'total'     => $totalSeries,
        'completed' => $completedSeries,
    ];

    // 3. Tickets by Category (Top 6)
    $categoryBreakdown = (clone $baseQuery)
        ->join('category_table', 'ticket_table.fk_category_id', '=', 'category_table.category_id')
        ->select('category_table.category_name', DB::raw('COUNT(ticket_table.ticket_id) as total'))
        ->groupBy('category_table.category_id', 'category_table.category_name')
        ->orderByDesc('total')
        ->limit(6)
        ->get();

    // 4. Worker Workload Breakdown (Campus Workers)
    $workers = User::where('type', 'worker')
        ->whereHas('department', function ($q) use ($campusId) {
            $q->where('fk_campus_id', $campusId);
        })
        ->orderBy('name')
        ->get(['id', 'name']);

    $workerTicketCounts = (clone $baseQuery)
        ->whereNotNull('assign_to')
        ->select(
            'assign_to',
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN LOWER(TRIM(status)) IN ('accepted', 'work in progress', 'pending') THEN 1 ELSE 0 END) as active"),
            DB::raw("SUM(CASE WHEN LOWER(TRIM(status)) IN ('completed', 'acknowledged') THEN 1 ELSE 0 END) as completed")
        )
        ->groupBy('assign_to')
        ->get()
        ->keyBy('assign_to');

    $workerPerformance = $workers->map(function ($worker) use ($workerTicketCounts) {
        $row = $workerTicketCounts[$worker->id] ?? null;
        return [
            'name'      => $worker->name,
            'total'     => (int) ($row->total ?? 0),
            'active'    => (int) ($row->active ?? 0),
            'completed' => (int) ($row->completed ?? 0),
        ];
    })->sortByDesc('total')->values();

    // 5. Recent Tickets (Latest 8)
    $recentTickets = (clone $baseQuery)
        ->with(['department', 'category', 'assignee'])
        ->orderByDesc('ticket_id')
        ->limit(8)
        ->get();

    return view('provider.index', [
        'stats'             => $stats,
        'monthlyTrend'      => $monthlyTrend,
        'categoryBreakdown' => $categoryBreakdown,
        'workerPerformance' => $workerPerformance,
        'recentTickets'     => $recentTickets,
        'campusName'        => $user?->department?->campus?->campus_name ?? 'Campus',
    ]);
}
}