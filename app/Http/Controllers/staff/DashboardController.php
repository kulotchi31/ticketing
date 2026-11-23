    <?php

    namespace App\Http\Controllers\staff;

    use App\Http\Controllers\Controller;
    use App\Models\Ticket;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class DashboardController extends Controller
    {
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

            // Include ALL tickets for this staff user's department & campus
            // (online requests, walk-ins without requested_by, or tickets created by/requested by the staff user)
            $deptTicketsQuery = Ticket::query()
                ->where(function ($query) use ($departmentId, $campusId, $staff) {
                    $query->where('fk_department_id', $departmentId)
                        ->whereHas('department', function ($deptQuery) use ($campusId) {
                            if ($campusId !== null) {
                                $deptQuery->where('fk_campus_id', $campusId);
                            }
                        });
                })
                ->orWhere(function ($query) use ($staff, $departmentId) {
                    $query->where('fk_department_id', $departmentId)
                        ->where(function ($sub) use ($staff) {
                            $sub->where('created_by', $staff->id)
                                ->orWhere('requested_by', $staff->id);
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

            // Last 6 months department/campus trend
            $labels = [];
            $submittedSeries = [];
            $resolvedSeries = [];

            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $labels[] = $month->format('M Y');

                $submittedSeries[] = (clone $deptTicketsQuery)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();

                $resolvedSeries[] = (clone $deptTicketsQuery)
                    ->whereIn('status', ['Completed', 'Acknowledged'])
                    ->whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month)
                    ->count();
            }

            $monthlyTrend = [
                'labels' => $labels,
                'submitted' => $submittedSeries,
                'resolved' => $resolvedSeries,
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

            return view('staff.dashboard', compact(
                'staff',
                'departmentName',
                'campusName',
                'stats',
                'monthlyTrend',
                'statusBreakdown',
                'toAcknowledgeTickets',
                'recentTickets'
            ));
        }
    }