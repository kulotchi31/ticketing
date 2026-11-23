<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $staff = Auth::user();

        if ($staff->type !== 'staff') {
            abort(403, 'Access denied. Staff accounts only.');
        }

        $staff->loadMissing('department.campus');

        if (!$staff->fk_department_id || !$staff->department) {
            abort(403, 'Your account is not assigned to a department.');
        }

        $departmentId = (int) $staff->fk_department_id;
        $campusId = $staff->department->fk_campus_id ?? $staff->department->campus?->campus_id;

        $departmentName = $staff->department->department_name ?? 'Department';
        $campusName = $staff->department->campus?->campus_name ?? 'Campus';

        // Outer where() wraps the OR branches so chained where() clauses always apply cleanly
        $deptTicketsQuery = Ticket::query()
            ->where(function ($outer) use ($departmentId, $campusId, $staff) {
                $outer->where(function ($query) use ($departmentId, $campusId) {
                    $query->where('fk_department_id', $departmentId)
                        ->whereHas('department', function ($deptQuery) use ($campusId) {
                            if ($campusId !== null) {
                                $deptQuery->where('fk_campus_id', $campusId);
                            }
                        });
                })->orWhere(function ($query) use ($departmentId, $staff) {
                    $query->where('fk_department_id', $departmentId)
                        ->where(function ($sub) use ($staff) {
                            $sub->where('created_by', $staff->id)
                                ->orWhere('requested_by', $staff->id);
                        });
                });
            });

        $now = Carbon::now();

        $stats = [
            'total' => (clone $deptTicketsQuery)->count(),
            'walk_in' => (clone $deptTicketsQuery)->where('is_walk_in', true)->count(),
            'this_month' => (clone $deptTicketsQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count(),
            'for_approval' => (clone $deptTicketsQuery)->where('status', 'For Approval')->count(),
            'accepted' => (clone $deptTicketsQuery)->where('status', 'Accepted')->count(),
            'work_in_progress' => (clone $deptTicketsQuery)->where('status', 'Work In Progress')->count(),
            'pending' => (clone $deptTicketsQuery)->where('status', 'Pending')->count(),
            'completed' => (clone $deptTicketsQuery)->where('status', 'Completed')->count(),
            'acknowledged' => (clone $deptTicketsQuery)->where('status', 'Acknowledged')->count(),
        ];

        $stats['in_progress_total'] = $stats['accepted'] + $stats['work_in_progress'] + $stats['pending'];
        $stats['resolved_total'] = $stats['completed'] + $stats['acknowledged'];

        // Last 6 months bar chart broken down by every status
        $statuses = [
            'For Approval',
            'Accepted',
            'Work In Progress',
            'Pending',
            'Completed',
            'Acknowledged',
        ];

        $labels = [];
        $seriesByStatus = [];
        foreach ($statuses as $status) {
            $seriesByStatus[$status] = [];
        }

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');

            foreach ($statuses as $status) {
                $seriesByStatus[$status][] = (clone $deptTicketsQuery)
                    ->where('status', $status)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        $monthlyStatusTrend = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'For Approval',
                    'data' => $seriesByStatus['For Approval'],
                    'backgroundColor' => 'rgba(245, 158, 11, 0.85)',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Accepted',
                    'data' => $seriesByStatus['Accepted'],
                    'backgroundColor' => 'rgba(37, 99, 235, 0.85)',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Work In Progress',
                    'data' => $seriesByStatus['Work In Progress'],
                    'backgroundColor' => 'rgba(14, 165, 233, 0.85)',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Pending',
                    'data' => $seriesByStatus['Pending'],
                    'backgroundColor' => 'rgba(100, 116, 139, 0.85)',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Completed',
                    'data' => $seriesByStatus['Completed'],
                    'backgroundColor' => 'rgba(16, 185, 129, 0.85)',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Acknowledged',
                    'data' => $seriesByStatus['Acknowledged'],
                    'backgroundColor' => 'rgba(99, 102, 241, 0.85)',
                    'borderRadius' => 6,
                ],
            ],
        ];

        // Status breakdown for doughnut chart
        $statusBreakdown = collect([
            ['label' => 'For Approval', 'count' => $stats['for_approval']],
            ['label' => 'Accepted', 'count' => $stats['accepted']],
            ['label' => 'Work In Progress', 'count' => $stats['work_in_progress']],
            ['label' => 'Pending', 'count' => $stats['pending']],
            ['label' => 'Completed', 'count' => $stats['completed']],
            ['label' => 'Acknowledged', 'count' => $stats['acknowledged']],
        ])->filter(fn ($item) => $item['count'] > 0)->values();

        // Completed tickets in this department/campus awaiting acknowledgment
        $toAcknowledgeTickets = (clone $deptTicketsQuery)
            ->with(['category', 'assignee', 'department'])
            ->where('status', 'Completed')
            ->latest('updated_at')
            ->limit(8)
            ->get();

        // Recent tickets in this department/campus (including walk-ins)
        $recentTickets = (clone $deptTicketsQuery)
            ->with(['category', 'assignee', 'department'])
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('staff.index', compact(
            'staff',
            'departmentName',
            'campusName',
            'stats',
            'monthlyStatusTrend',
            'statusBreakdown',
            'toAcknowledgeTickets',
            'recentTickets'
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
