<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    /**
     * Allowed ticket statuses for the filter dropdown.
     */
    private const ALLOWED_STATUSES = [
        'All',
        'For Approval',
        'Accepted',
        'Work In Progress',
        'Pending',
        'Completed',
        'Acknowledged',
    ];

    /**
     * Get workers belonging to the authenticated user's campus (without filtering by provider).
     */
    private function getCampusWorkers(int $campusId)
    {
        return User::where('type', 'worker') // Adjust if your role column/value differs
            ->whereHas('department', function ($q) use ($campusId) {
                $q->where('fk_campus_id', $campusId);
            })
            ->orderBy('name')
            ->get(['id', 'name']); // Change 'user_id' to 'id' if your users table primary key is 'id'
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $campusId = $user?->department?->fk_campus_id;

        $workers = $campusId
            ? $this->getCampusWorkers($campusId)
            : collect();

        return view('provider.report', [
            'statuses' => self::ALLOWED_STATUSES,
            'workers'  => $workers,
        ]);
    }

    /**
     * Validate filter inputs shared by getData() and exportPdf().
     */
    private function validateFilterRequest(Request $request, int $campusId)
    {
        $validWorkerIds = $this->getCampusWorkers($campusId)
            ->pluck('id') // Change 'user_id' to 'id' if your users table primary key is 'id'
            ->toArray();

        return Validator::make($request->all(), [
            'date_from' => ['nullable', 'date', 'before_or_equal:today'],
            'date_to'   => ['nullable', 'date', 'after_or_equal:date_from', 'before_or_equal:today'],
            'status'    => ['nullable', 'string', Rule::in(self::ALLOWED_STATUSES)],
            'worker_id' => ['nullable', Rule::in($validWorkerIds)],
        ], [
            'date_from.date'            => 'Please provide a valid start date.',
            'date_from.before_or_equal' => 'Start date cannot be in the future.',
            'date_to.date'              => 'Please provide a valid end date.',
            'date_to.after_or_equal'    => 'End date must be on or after the start date.',
            'date_to.before_or_equal'   => 'End date cannot be in the future.',
            'status.in'                 => 'Selected status is invalid.',
            'worker_id.in'              => 'Selected worker does not belong to your campus.',
        ]);
    }

    /**
     * Build the filtered base query shared by getData() and exportPdf().
     */
    private function buildFilteredQuery(Request $request, int $campusId, int $providerId)
    {
        $query = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->whereHas('department', function ($q) use ($campusId) {
            $q->where('fk_campus_id', $campusId);
        })
        ->whereHas('category.requestType', function ($q) use ($providerId) {
            $q->where('fk_provider_id', $providerId);
        });

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        // Filter by assigned worker (change 'assigned_to' if your foreign key column name differs)
        if ($request->filled('worker_id')) {
            $query->where('assign_to', $request->worker_id);
        }

        return $query;
    }

    /**
     * Server-side DataTables endpoint for filtered ticket report data.
     */
    public function getData(Request $request)
    {
        $user = auth()->user();
        $campusId = $user?->department?->fk_campus_id;

        if (!$campusId || !$user?->fk_provider_id) {
            return response()->json([
                'draw'            => (int) $request->input('draw', 1),
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'message'         => 'No campus or provider associated with the authenticated user.',
            ], 422);
        }

        $validator = $this->validateFilterRequest($request, $campusId);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $baseQuery = $this->buildFilteredQuery($request, $campusId, $user->fk_provider_id);

        // Total matching records before search box filtering
        $recordsTotal = (clone $baseQuery)->count();

        // Apply DataTables search filter on server
        $search = trim((string) $request->input('search.value', ''));
        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('requested_by', 'like', "%{$search}%")
                  ->orWhere('classification', 'like', "%{$search}%")
                  ->orWhere('remarks', 'like', "%{$search}%")
                  ->orWhere('action_taken', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('department_name', 'like', "%{$search}%")
                         ->orWhereHas('campus', function ($cq) use ($search) {
                             $cq->where('campus_name', 'like', "%{$search}%");
                         });
                  })
                  ->orWhereHas('category', function ($catQ) use ($search) {
                      $catQ->where('category_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('assignee', function ($assQ) use ($search) {
                      $assQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Total matching records after search box filtering
        $recordsFiltered = (clone $baseQuery)->count();

        // Server-side column sorting
        $sortableColumns = [
            0  => 'ticket_number',
            1  => 'created_at',
            4  => 'requested_by',
            6  => 'classification',
            7  => 'remarks',
            9  => 'action_taken',
            10 => 'status',
        ];

        $orderColIdx = (int) $request->input('order.0.column', -1);
        $orderDir    = strtolower($request->input('order.0.dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if (isset($sortableColumns[$orderColIdx])) {
            $baseQuery->orderBy($sortableColumns[$orderColIdx], $orderDir);
        } else {
            $baseQuery->orderByDesc('ticket_id');
        }

        // Server-side pagination
        $start  = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 15);
        if ($length <= 0 || $length > 500) {
            $length = 15;
        }

        $tickets = $baseQuery
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw'            => (int) $request->input('draw', 1),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $tickets,
        ]);
    }

    /**
     * Generate PDF matching NEUST-MIS-F011 Monthly Summary layout.
     */
    /**
     * Generate PDF matching NEUST-MIS-F011 Monthly Summary layout.
     */
    public function exportPdf(Request $request)
    {
        $user = auth()->user();
        $campusId = $user?->department?->fk_campus_id;

        if (!$campusId || !$user?->fk_provider_id) {
            abort(422, 'No campus or provider associated with the authenticated user.');
        }

        $validator = $this->validateFilterRequest($request, $campusId);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }

        $tickets = $this->buildFilteredQuery($request, $campusId, $user->fk_provider_id)
            ->orderBy('ticket_id')
            ->get();

        // Block PDF generation if there are no matching tickets
        if ($tickets->isEmpty()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No ticket records found for the selected filters. Cannot generate PDF.',
                ], 422);
            }

            return redirect()
                ->route('report-provider.index')
                ->with('error', 'No ticket records found for the selected filters. Cannot generate PDF.');
        }

        // Format month/period label for the header line
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $from = Carbon::parse($request->date_from);
            $to   = Carbon::parse($request->date_to);
            $monthLabel = $from->format('F Y') === $to->format('F Y')
                ? $from->format('F Y')
                : $from->format('M d, Y') . ' - ' . $to->format('M d, Y');
        } elseif ($request->filled('date_from')) {
            $monthLabel = Carbon::parse($request->date_from)->format('F Y');
        } elseif ($request->filled('date_to')) {
            $monthLabel = Carbon::parse($request->date_to)->format('F Y');
        } else {
            $monthLabel = now()->format('F Y');
        }

        // Split into pages of 37 rows each (matching NEUST-MIS-F011 grid)
        $rowsPerPage = 37;
        $pages = $tickets->chunk($rowsPerPage);

        $pdf = Pdf::loadView('provider.report_pdf', [
            'pages'       => $pages,
            'rowsPerPage' => $rowsPerPage,
            'monthLabel'  => $monthLabel,
            'preparedBy'  => $user->name ?? '',
            'preparedPos' => $user->position ?? 'MIS Staff',
            'dateToday'   => now()->format('m/d/Y'),
        ])->setPaper('letter', 'portrait');

        return $pdf->stream('NEUST-MIS-Service-Request-Summary.pdf');
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}