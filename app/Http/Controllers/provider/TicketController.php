<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use App\Models\Campus;
use App\Models\RequestType;
use App\Models\Provider;
use App\Models\AuditLogs;
use App\Services\TicketAnalyzer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketApprovedMail;
use App\Mail\WalkInTicketCreatedMail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('provider.ticket');
    }

    /**
     * Return dropdown data needed to create walk-in tickets and assign workers.
     */
    public function createData()
    {
        $authUser = User::with('department.campus')->find(auth()->id());
        $campusId = $authUser?->department?->fk_campus_id;

        $users = User::with('department.campus')
            ->select([
                'id',
                'name',
                'fk_provider_id',
                'fk_department_id',
                'type',
                'is_active'
            ])
            ->where('type', 'worker')
            ->where('is_active', 1)
            ->whereNotNull('fk_provider_id')
            ->whereNotNull('fk_department_id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'campuses'           => Campus::orderBy('campus_name')->get(),
            'departments'        => Department::where('fk_campus_id', $campusId)
                ->orderBy('department_name')
                ->get(),
            'providers'          => Provider::orderBy('provider_name')->get(),
            'request_types'      => RequestType::orderBy('rt_name')->get(),
            'categories'         => Category::orderBy('category_name')->get(),
            'users'              => $users,
            'user_campus_id'     => $campusId,
            'user_department_id' => $authUser?->fk_department_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created walk-in ticket in storage.
     */
    public function store(Request $request, TicketAnalyzer $analyzer)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $userDepartment = Department::where(
            'department_id',
            $user->fk_department_id
        )->first();

        if (!$userDepartment) {
            return response()->json([
                'success' => false,
                'message' => 'Your account does not have a valid department assigned.',
            ], 422);
        }

        $userCampusId = $userDepartment->fk_campus_id;

        $validator = Validator::make($request->all(), [
            'requested_by' => [
                'required',
                'string',
                'max:255',
            ],
            'fk_campus_id' => [
                'required',
                'integer',
                'exists:campus_table,campus_id',
            ],
            'fk_department_id' => [
                'required',
                'integer',
                Rule::exists('department_table', 'department_id')
                    ->where(function ($query) use ($request) {
                        $query->where(
                            'fk_campus_id',
                            $request->fk_campus_id
                        );
                    }),
            ],
            'fk_provider_id' => [
                'required',
                'integer',
                'exists:provider_table,provider_id',
            ],
            'fk_request_type_id' => [
                'required',
                'integer',
                Rule::exists('request_type_table', 'request_type_id')
                    ->where(function ($query) use ($request) {
                        $query->where(
                            'fk_provider_id',
                            $request->fk_provider_id
                        );
                    }),
            ],
            'fk_category_id' => [
                'required',
                'integer',
                Rule::exists('category_table', 'category_id')
                    ->where(function ($query) use ($request) {
                        $query->where(
                            'fk_request_type_id',
                            $request->fk_request_type_id
                        );
                    }),
            ],
            'remarks' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if ((int) $request->fk_campus_id !== (int) $userCampusId) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to create tickets for this campus.',
            ], 403);
        }

        $departmentId = $request->fk_department_id;

        if (
            $user->fk_provider_id &&
            (int) $user->fk_provider_id !== (int) $request->fk_provider_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to create tickets for this provider.',
            ], 403);
        }

        $provider = Provider::where(
            'provider_id',
            $request->fk_provider_id
        )->first();

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Selected provider was not found.',
            ], 422);
        }

        $serviceType = match (
            strtoupper(trim($provider->provider_code))
        ) {
            'MIS'   => 'IT',
            'BMGS'  => 'General Services',
            default => null,
        };

        if ($serviceType === null) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported service provider.',
            ], 422);
        }

        $classification = 'Medium';

        try {
            $analysis = $analyzer->analyze(
                $request->remarks,
                $serviceType
            );

            if (in_array(
                $analysis['classification'] ?? null,
                ['High', 'Medium', 'Low'],
                true
            )) {
                $classification = $analysis['classification'];
            }
        } catch (\Throwable $e) {
            Log::error('Provider ticket priority analysis failed.', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }

        try {
            $ticket = DB::transaction(function () use (
                $request,
                $user,
                $departmentId,
                $classification
            ) {
                $ticket = Ticket::create([
                    'requested_by'       => $request->requested_by,
                    'fk_department_id'   => $departmentId,
                    'fk_provider_id'     => $request->fk_provider_id,
                    'fk_request_type_id' => $request->fk_request_type_id,
                    'fk_category_id'     => $request->fk_category_id,
                    'remarks'            => $request->remarks,
                    'created_by'         => $user->id,
                    'assign_to'          => null,
                    'status'             => 'For Approval',
                    'classification'     => $classification,
                    'is_walk_in'         => 'Yes',
                ]);

                AuditLogs::create([
                    'fk_user_id'       => $user->id,
                    'target_id'        => $ticket->ticket_id,
                    'action_type'      => 'Create Ticket',
                    'payload'          => [
                        'requested_by'       => $ticket->requested_by,
                        'fk_department_id'   => $ticket->fk_department_id,
                        'fk_provider_id'     => $ticket->fk_provider_id,
                        'fk_request_type_id' => $ticket->fk_request_type_id,
                        'fk_category_id'     => $ticket->fk_category_id,
                        'remarks'            => $ticket->remarks,
                        'created_by'         => $ticket->created_by,
                        'assign_to'          => $ticket->assign_to,
                        'status'             => $ticket->status,
                        'classification'     => $ticket->classification,
                        'is_walk_in'         => $ticket->is_walk_in,
                    ],
                    'transaction_date' => now(),
                ]);

                return $ticket;
            });

            $ticket->load([
                'department.campus',
                'category.requestType.provider',
            ]);

            DB::afterCommit(function () use ($ticket) {
                try {
                    $staffUsers = User::query()
                        ->where('type', 'staff')
                        ->where('is_active', 1)
                        ->whereNotNull('email')
                        ->where('email', '<>', '')
                        ->where(
                            'fk_department_id',
                            $ticket->fk_department_id
                        )
                        ->orderBy('name')
                        ->get([
                            'id',
                            'name',
                            'email',
                            'fk_department_id',
                        ]);

                    if ($staffUsers->isEmpty()) {
                        Log::warning(
                            'No active staff found in the ticket department.',
                            [
                                'ticket_id'     => $ticket->ticket_id,
                                'department_id' => $ticket->fk_department_id,
                            ]
                        );

                        return;
                    }

                    foreach ($staffUsers as $staff) {
                        Mail::to($staff->email)->queue(
                            new WalkInTicketCreatedMail($ticket)
                        );
                    }

                    Log::info(
                        'Walk-in ticket notification emails queued.',
                        [
                            'ticket_id'     => $ticket->ticket_id,
                            'department_id' => $ticket->fk_department_id,
                            'staff_count'   => $staffUsers->count(),
                            'staff_emails'  => $staffUsers->pluck('email')->all(),
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::error(
                        'Walk-in ticket email notification failed.',
                        [
                            'ticket_id'     => $ticket->ticket_id,
                            'department_id' => $ticket->fk_department_id,
                            'error'         => $e->getMessage(),
                        ]
                    );
                }
            });

            return response()->json([
                'success'   => true,
                'message'   => 'Ticket created successfully. Department staff have been notified.',
                'ticket_id' => $ticket->ticket_id,
            ]);

        } catch (\Throwable $e) {
            Log::error('Provider ticket creation failed.', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create ticket. Please try again.',
            ], 500);
        }
    }

    /**
     * Reusable query helper for fetching tickets by status scoped to the provider's campus & provider ID.
     */
    private function fetchTicketsByStatus(string $status)
    {
        $user = auth()->user();
        $campus_id = $user->department?->fk_campus_id;

        if (!$campus_id) {
            return response()->json([
                'data'    => [],
                'message' => 'No campus associated with the authenticated user.'
            ]);
        }

        $tickets = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->whereHas('department', function ($query) use ($campus_id) {
            $query->where('fk_campus_id', $campus_id);
        })
        ->whereHas('category.requestType', function ($query) use ($user) {
            $query->where('fk_provider_id', $user->fk_provider_id);
        })
        ->where('status', $status)
        ->orderByDesc('ticket_id')
        ->get();

        return response()->json([
            'data' => $tickets
        ]);
    }

    /**
     * Tab 1: Get tickets awaiting approval.
     */
    public function getTicket()
    {
        return $this->fetchTicketsByStatus('For Approval');
    }

    /**
     * Tab 2: Get accepted/assigned tickets.
     */
    public function getAcceptedTicket()
    {
        return $this->fetchTicketsByStatus('Accepted');
    }

    /**
     * Tab 3: Get work-in-progress tickets.
     */
    public function getWipTicket()
    {
        return $this->fetchTicketsByStatus('Work In Progress');
    }

    /**
     * Tab 4: Get pending tickets.
     */
    public function getPendingTicket()
    {
        return $this->fetchTicketsByStatus('Pending');
    }

    /**
     * Tab 5: Get completed tickets.
     */
    public function getCompletedTicket()
    {
        return $this->fetchTicketsByStatus('Completed');
    }

    /**
     * Tab 6: Get acknowledged tickets.
     */
    public function getAcknowledgedTicket()
    {
        return $this->fetchTicketsByStatus('Acknowledged');
    }

    /**
     * Print Service Order Slip (PDF) for acknowledged tickets.
     */
    public function printTicket($id)
    {
        $user = auth()->user();
        $campus_id = $user->department?->fk_campus_id;

        $ticket = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->whereHas('department', function ($query) use ($campus_id) {
            $query->where('fk_campus_id', $campus_id);
        })
        ->whereHas('category.requestType', function ($query) use ($user) {
            $query->where('fk_provider_id', $user->fk_provider_id);
        })
        ->findOrFail($id);

        
    $requestType = $ticket->category?->requestType;
    $providerName = strtoupper(trim($requestType?->provider?->provider_name ?? $requestType?->provider?->code ?? 'MIS'));
    $requestTypeName = trim($requestType?->rt_name ?? '');

    $ticketRef = $ticket->ticket_number ?? $ticket->ticket_id;

    // Route to ABMGS Service Order Slip
    if (in_array($providerName, ['BMGS', 'ABMGS']) && strcasecmp($requestTypeName, 'Service Order Slip') === 0) {
        $pdf = Pdf::loadView('worker.abmgs-service-order-pdf', compact('ticket'))
            ->setPaper('a5', 'portrait');

        return $pdf->stream("ABMGS-Service-Order-{$ticketRef}.pdf");
    }

    // Default: MIS Service Request
    $pdf = Pdf::loadView('worker.ticket-pdf', compact('ticket'))
        ->setPaper('letter', 'portrait');

    return $pdf->stream("MIS-Service-Request-{$ticketRef}.pdf");
    
        // Replace 'pdf.service_order_slip' with your exact PDF Blade view path
        // $pdf = Pdf::loadView('provider.service_order_slip', compact('ticket'));

        // return $pdf->stream('Service-Order-' . ($ticket->ticket_number ?? $ticket->ticket_id) . '.pdf');
    }

    /**
     * Approve ticket, generate ticket number, and assign to a worker.
     */
    public function approveAndAssign(Request $request, $id)
    {
        $request->validate([
            'assign_to' => [
                'required',
                'integer',
                'exists:users,id'
            ]
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $providerId = $user->fk_provider_id;

        if (!$providerId) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to approve tickets.'
            ], 403);
        }

        $ticket = Ticket::with([
            'category.requestType.provider',
            'creator',
            'department'
        ])->findOrFail($id);

        $ticketProviderId = $ticket->category?->requestType?->fk_provider_id;

        if ((int) $ticketProviderId !== (int) $providerId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot approve this ticket.'
            ], 403);
        }

        if ($ticket->status !== 'For Approval') {
            return response()->json([
                'success' => false,
                'message' => 'This ticket is no longer awaiting approval.'
            ], 422);
        }

        $worker = User::where('id', $request->assign_to)
            ->where('type', 'worker')
            ->where('fk_provider_id', $providerId)
            ->where('is_active', 1)
            ->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid worker. Select an active worker under your service provider.'
            ], 422);
        }

        $requester = $ticket->creator;

        try {
            DB::transaction(function () use (
                $ticket,
                $worker,
                $user,
                $requester
            ) {
                $oldStatus = $ticket->status;

                $ticketNumber = $ticket->ticket_number;

                if (empty($ticketNumber)) {
                    $providerCode = strtoupper(trim(
                        $ticket->category?->requestType?->provider?->provider_code ?? 'TKT'
                    ));
                    $year = now()->format('Y');
                    $prefix = "{$providerCode}-{$year}-";

                    $lastTicket = Ticket::where('ticket_number', 'like', "{$prefix}%")
                        ->lockForUpdate()
                        ->orderByDesc('ticket_number')
                        ->first();

                    $nextSequence = 1;
                    if ($lastTicket && preg_match('/(\d+)$/', $lastTicket->ticket_number, $matches)) {
                        $nextSequence = ((int) $matches[1]) + 1;
                    }

                    $ticketNumber = $prefix . str_pad($nextSequence, 5, '0', STR_PAD_LEFT);
                }

                $ticket->update([
                    'ticket_number' => $ticketNumber,
                    'assign_to'     => $worker->id,
                    'status'        => 'Accepted',
                    'approved_by'   => $user->id,
                ]);

                DB::table('status_history_table')->insert([
                    'ticket_id'  => $ticket->ticket_id,
                    'fk_user_id' => $user->id,
                    'status'     => 'Accepted',
                    'remarks'    => "Ticket ({$ticketNumber}) approved and assigned to {$worker->name}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                AuditLogs::create([
                    'fk_user_id'       => $user->id,
                    'target_id'        => $ticket->ticket_id,
                    'action_type'      => 'TICKET_APPROVED_AND_ASSIGNED',
                    'payload'          => [
                        'ticket_id'            => $ticket->ticket_id,
                        'ticket_number'        => $ticketNumber,
                        'old_status'           => $oldStatus,
                        'new_status'           => 'Accepted',
                        'assigned_worker_id'   => $worker->id,
                        'assigned_worker_name' => $worker->name,
                    ],
                    'transaction_date' => now(),
                ]);

                if ($requester && $requester->email) {
                    DB::afterCommit(function () use (
                        $ticket,
                        $worker,
                        $requester
                    ) {
                        try {
                            Mail::to($requester->email)
                                ->queue(new TicketApprovedMail(
                                    $ticket,
                                    $worker,
                                    'requester'
                                ));
                        } catch (\Throwable $e) {
                            Log::error('Requester notification email failed.', [
                                'ticket_id'       => $ticket->ticket_id,
                                'requester_email' => $requester->email,
                                'error'           => $e->getMessage(),
                            ]);
                        }
                    });
                } else {
                    Log::warning('Requester email not found.', [
                        'ticket_id'  => $ticket->ticket_id,
                        'created_by' => $ticket->created_by,
                    ]);
                }
            });

            return response()->json([
                'success'       => true,
                'ticket_number' => $ticket->ticket_number,
                'message'       => "Ticket {$ticket->ticket_number} approved and assigned successfully.",
            ]);

        } catch (\Throwable $e) {
            Log::error('Ticket approval and assignment failed.', [
                'ticket_id' => $id,
                'user_id'   => $user->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while approving the ticket.'
            ], 500);
        }
    }
}