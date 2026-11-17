<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $campusId   = $user?->department?->fk_campus_id;
        $providerId = $user?->fk_provider_id;

        if (!$campusId || !$providerId) {
            abort(403, 'No campus or provider associated with your account.');
        }

        // Base query scoped to authenticated provider & campus
        $baseQuery = Ticket::whereHas('department', function ($q) use ($campusId) {
                $q->where('fk_campus_id', $campusId);
            })
            ->whereHas('category.requestType', function ($q) use ($providerId) {
                $q->where('fk_provider_id', $providerId);
            });

        // 1. KPI Summary Counts
        $statusCounts = (clone $baseQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total'            => (clone $baseQuery)->count(),
            'for_approval'     => $statusCounts['For Approval'] ?? 0,
            'accepted'         => $statusCounts['Accepted'] ?? 0,
            'work_in_progress' => $statusCounts['Work In Progress'] ?? 0,
            'pending'          => $statusCounts['Pending'] ?? 0,
            'completed'        => $statusCounts['Completed'] ?? 0,
            'acknowledged'     => $statusCounts['Acknowledged'] ?? 0,
            'unassigned'       => (clone $baseQuery)
                ->whereNull('assign_to')
                ->whereNotIn('status', ['Completed', 'Acknowledged'])
                ->count(),
            'this_month'       => (clone $baseQuery)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // 2. Last 6 Months Ticket Trend (for Chart.js)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'key'   => $date->format('Y-m'),
                'label' => $date->format('M Y'),
            ]);
        }

        $monthlyRaw = (clone $baseQuery)
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status IN ('Completed', 'Acknowledged') THEN 1 ELSE 0 END) as completed")
            )
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $monthlyTrend = [
            'labels'    => $months->pluck('label')->values(),
            'total'     => $months->map(fn ($m) => (int) ($monthlyRaw[$m['key']]->total ?? 0))->values(),
            'completed' => $months->map(fn ($m) => (int) ($monthlyRaw[$m['key']]->completed ?? 0))->values(),
        ];

        // 3. Tickets by Category (Top 6)
        $categoryBreakdown = (clone $baseQuery)
            ->join('category_table', 'ticket_table.fk_category_id', '=', 'category_table.category_id')
            ->select('category_table.category_name', DB::raw('COUNT(*) as total'))
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
                DB::raw("SUM(CASE WHEN status IN ('Accepted', 'Work In Progress', 'Pending') THEN 1 ELSE 0 END) as active"),
                DB::raw("SUM(CASE WHEN status IN ('Completed', 'Acknowledged') THEN 1 ELSE 0 END) as completed")
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

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}