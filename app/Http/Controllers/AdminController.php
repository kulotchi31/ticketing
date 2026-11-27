<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Count across ALL tickets (all campuses) using normalized status values.
    $statusCounts = Ticket::query()
        ->select(DB::raw('LOWER(TRIM(status)) as norm_status'), DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('LOWER(TRIM(status))'))
        ->pluck('total', 'norm_status');

    $totalTickets = (int) Ticket::count();

    $forApproval    = (int) ($statusCounts['for approval'] ?? 0);
    $accepted       = (int) ($statusCounts['accepted'] ?? 0);
    $workInProgress = (int) ($statusCounts['work in progress'] ?? 0);
    $pending        = (int) ($statusCounts['pending'] ?? 0);
    $completed      = (int) ($statusCounts['completed'] ?? 0);
    // Support both 'aknowledged' (DB ENUM spelling) and 'acknowledged' just in case.
    $acknowledged   = (int) (($statusCounts['aknowledged'] ?? 0) + ($statusCounts['acknowledged'] ?? 0));

    $ticketsThisMonth = (int) Ticket::query()
        ->whereNotNull('created_at')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();

    // Last 6 calendar months, including the current month (all campuses).
    $startMonth = now()->startOfMonth()->subMonths(5);
    $monthlyRows = Ticket::query()
        ->whereNotNull('created_at')
        ->where('created_at', '>=', $startMonth)
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key")
        ->selectRaw("COUNT(*) as total")
        ->groupBy('month_key')
        ->orderBy('month_key')
        ->pluck('total', 'month_key');

    $monthlyLabels = [];
    $monthlyData = [];
    for ($i = 0; $i < 6; $i++) {
        $month = $startMonth->copy()->addMonths($i);
        $key = $month->format('Y-m');
        $monthlyLabels[] = $month->format('M Y');
        $monthlyData[] = (int) ($monthlyRows[$key] ?? 0);
    }

    // All departments across all campuses (top 8).
    $departmentRows = DB::table('ticket_table')
        ->join('department_table', 'ticket_table.fk_department_id', '=', 'department_table.department_id')
        ->select('department_table.department_name', DB::raw('COUNT(ticket_table.ticket_id) as total'))
        ->groupBy('department_table.department_id', 'department_table.department_name')
        ->orderByDesc('total')
        ->limit(8)
        ->get();

    // All categories across all campuses (top 8).
    $categoryRows = DB::table('ticket_table')
        ->join('category_table', 'ticket_table.fk_category_id', '=', 'category_table.category_id')
        ->select('category_table.category_name', DB::raw('COUNT(ticket_table.ticket_id) as total'))
        ->groupBy('category_table.category_id', 'category_table.category_name')
        ->orderByDesc('total')
        ->limit(8)
        ->get();

    // Normalized priority counts across all campuses.
    $priorityCounts = Ticket::query()
        ->select(DB::raw('LOWER(TRIM(classification)) as norm_priority'), DB::raw('COUNT(*) as total'))
        ->whereNotNull('classification')
        ->groupBy(DB::raw('LOWER(TRIM(classification))'))
        ->pluck('total', 'norm_priority');

    // Latest 8 tickets across all campuses (order by ticket_id desc avoids tie issues on identical created_at).
    $latestTickets = Ticket::query()
        ->with(['department', 'category', 'assignee'])
        ->orderByDesc('ticket_id')
        ->limit(8)
        ->get();

    // Plain arrays for Chart.js & Status Summary table.
    $statusLabels = ['For Approval', 'Accepted', 'Work In Progress', 'Pending', 'Completed', 'Aknowledged'];
    $statusValues = [$forApproval, $accepted, $workInProgress, $pending, $completed, $acknowledged];

    $departmentLabels = $departmentRows->pluck('department_name')->values()->all();
    $departmentValues = $departmentRows->pluck('total')->map(fn ($value) => (int) $value)->values()->all();

    $categoryLabels = $categoryRows->pluck('category_name')->values()->all();
    $categoryValues = $categoryRows->pluck('total')->map(fn ($value) => (int) $value)->values()->all();

    $priorityLabels = ['High', 'Medium', 'Low'];
    $priorityValues = [
        (int) ($priorityCounts['high'] ?? 0),
        (int) ($priorityCounts['medium'] ?? 0),
        (int) ($priorityCounts['low'] ?? 0),
    ];

    return view('admin.index', compact(
        'totalTickets',
        'ticketsThisMonth',
        'forApproval',
        'accepted',
        'workInProgress',
        'pending',
        'completed',
        'acknowledged',
        'monthlyLabels',
        'monthlyData',
        'departmentRows',
        'categoryRows',
        'priorityCounts',
        'latestTickets',
        'statusLabels',
        'statusValues',
        'departmentLabels',
        'departmentValues',
        'categoryLabels',
        'categoryValues',
        'priorityLabels',
        'priorityValues'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
