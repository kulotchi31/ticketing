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
        // Counts use the actual status values defined in ticket_table.
        $statusCounts = Ticket::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalTickets = Ticket::count();

        $forApproval = (int) ($statusCounts['For Approval'] ?? 0);
        $accepted = (int) ($statusCounts['Accepted'] ?? 0);
        $workInProgress = (int) ($statusCounts['Work In Progress'] ?? 0);
        $pending = (int) ($statusCounts['Pending'] ?? 0);
        $completed = (int) ($statusCounts['Completed'] ?? 0);
        // Keep the spelling exactly as defined in the database ENUM.
        $acknowledged = (int) ($statusCounts['Aknowledged'] ?? 0);

        // Last 6 calendar months, including the current month.
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

        $departmentRows = DB::table('ticket_table')
            ->join('department_table', 'ticket_table.fk_department_id', '=', 'department_table.department_id')
            ->select('department_table.department_name', DB::raw('COUNT(ticket_table.ticket_id) as total'))
            ->groupBy('department_table.department_id', 'department_table.department_name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $categoryRows = DB::table('ticket_table')
            ->join('category_table', 'ticket_table.fk_category_id', '=', 'category_table.category_id')
            ->select('category_table.category_name', DB::raw('COUNT(ticket_table.ticket_id) as total'))
            ->groupBy('category_table.category_id', 'category_table.category_name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $priorityCounts = Ticket::query()
            ->select('classification', DB::raw('COUNT(*) as total'))
            ->whereNotNull('classification')
            ->groupBy('classification')
            ->pluck('total', 'classification');

        $latestTickets = Ticket::query()
            ->with(['department', 'category', 'assignee'])
            ->latest('created_at')
            ->limit(8)
            ->get();

        // Prepare plain arrays for safe serialization in the Blade view.
        $statusLabels = ['For Approval', 'Accepted', 'Work In Progress', 'Pending', 'Completed', 'Aknowledged'];
        $statusValues = [$forApproval, $accepted, $workInProgress, $pending, $completed, $acknowledged];
        $departmentLabels = $departmentRows->pluck('department_name')->values()->all();
        $departmentValues = $departmentRows->pluck('total')->map(fn($value) => (int) $value)->values()->all();
        $categoryLabels = $categoryRows->pluck('category_name')->values()->all();
        $categoryValues = $categoryRows->pluck('total')->map(fn($value) => (int) $value)->values()->all();
        $priorityLabels = ['High', 'Medium', 'Low'];
        $priorityValues = [
            (int) ($priorityCounts['High'] ?? 0),
            (int) ($priorityCounts['Medium'] ?? 0),
            (int) ($priorityCounts['Low'] ?? 0),
        ];

        return view('admin.index', compact(
            'totalTickets',
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
