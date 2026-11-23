<?php

namespace App\Http\Controllers\worker;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $worker = Auth::user();
        $workerId = $worker->id;

        $worker->loadMissing('department.campus');
        $campusName = $worker->department?->campus?->campus_name ?? 'Campus';

        // Base query scoped strictly to tickets assigned to this worker
        $assignedQuery = Ticket::query()->where('assign_to', $workerId);

        $now = Carbon::now();

        $stats = [
            'total' => (clone $assignedQuery)->count(),
            'this_month' => (clone $assignedQuery)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count(),
            'accepted' => (clone $assignedQuery)->where('status', 'Accepted')->count(),
            'work_in_progress' => (clone $assignedQuery)->where('status', 'Work In Progress')->count(),
            'pending' => (clone $assignedQuery)->where('status', 'Pending')->count(),
            'completed' => (clone $assignedQuery)->where('status', 'Completed')->count(),
            'acknowledged' => (clone $assignedQuery)->where('status', 'Acknowledged')->count(),
        ];

        $stats['active'] = $stats['accepted'] + $stats['work_in_progress'] + $stats['pending'];
        $stats['done'] = $stats['completed'] + $stats['acknowledged'];

        // Last 6 months assigned vs. completed trend for this worker
        $labels = [];
        $totalSeries = [];
        $completedSeries = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');

            $totalSeries[] = (clone $assignedQuery)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $completedSeries[] = (clone $assignedQuery)
                ->whereIn('status', ['Completed', 'Acknowledged'])
                ->whereYear('updated_at', $month->year)
                ->whereMonth('updated_at', $month->month)
                ->count();
        }

        $monthlyTrend = [
            'labels' => $labels,
            'total' => $totalSeries,
            'completed' => $completedSeries,
        ];

        // Status breakdown for doughnut chart
        $statusBreakdown = collect([
            ['label' => 'Accepted', 'count' => $stats['accepted']],
            ['label' => 'Work In Progress', 'count' => $stats['work_in_progress']],
            ['label' => 'Pending', 'count' => $stats['pending']],
            ['label' => 'Completed', 'count' => $stats['completed']],
            ['label' => 'Acknowledged', 'count' => $stats['acknowledged']],
        ])->filter(fn ($item) => $item['count'] > 0)->values();

        // Active queue (Accepted, Work In Progress, Pending)
        $activeTickets = Ticket::query()
            ->with(['department', 'category', 'creator'])
            ->where('assign_to', $workerId)
            ->whereIn('status', ['Accepted', 'Work In Progress', 'Pending'])
            ->orderByRaw("FIELD(status, 'Work In Progress', 'Accepted', 'Pending')")
            ->latest('updated_at')
            ->limit(8)
            ->get();

        // All recent tickets assigned to this worker
        $recentAssignedTickets = Ticket::query()
            ->with(['department', 'category', 'creator'])
            ->where('assign_to', $workerId)
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('worker.dashboard', compact(
            'worker',
            'campusName',
            'stats',
            'monthlyTrend',
            'statusBreakdown',
            'activeTickets',
            'recentAssignedTickets'
        ));
    }
}