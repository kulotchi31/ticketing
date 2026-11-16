<?php

namespace App\Http\Controllers\staff;

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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use App\Mail\ServiceRequestSubmitted;
use Illuminate\Support\Facades\Mail;

class ticketController extends Controller
{
    /**
     * Display the staff ticket management page.
     */
    public function index()
    {
        return view('staff.ticket');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Return data needed by the Add/Edit Ticket modal.
     */
    public function createData()
    {
        $users = User::select(
            'id',
            'name',
            'fk_provider_id'
        )
        ->where('type', 'worker')
        ->whereNotNull('fk_provider_id')
        ->orderBy('name')
        ->get();

        return response()->json([
            'campuses'      => Campus::orderBy('campus_name')->get(),
            'departments'   => Department::orderBy('department_name')->get(),
            'providers'     => Provider::orderBy('provider_name')->get(),
            'request_types' => RequestType::orderBy('rt_name')->get(),
            'categories'    => Category::orderBy('category_name')->get(),
            'users'         => $users,
        ]);
    }

    /**
     * Get tickets created by the authenticated staff member (Server-Side DataTables).
     */
    public function getTicket(Request $request)
    {
        $baseQuery = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])->where('created_by', auth()->id());

        // Filter by selected status tab (empty string = "All")
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }

        // Total records for this staff member under the selected status tab
        $recordsTotal = (clone $baseQuery)->count();

        // Global search across ticket fields and relationships
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('ticket_number', 'like', "%{$searchValue}%")
                  ->orWhere('classification', 'like', "%{$searchValue}%")
                  ->orWhere('remarks', 'like', "%{$searchValue}%")
                  ->orWhere('requested_by', 'like', "%{$searchValue}%")
                  ->orWhere('pending_remarks', 'like', "%{$searchValue}%")
                  ->orWhere('status', 'like', "%{$searchValue}%")
                  ->orWhereHas('category', function ($catQ) use ($searchValue) {
                      $catQ->where('category_name', 'like', "%{$searchValue}%")
                           ->orWhereHas('requestType.provider', function ($provQ) use ($searchValue) {
                               $provQ->where('provider_name', 'like', "%{$searchValue}%");
                           });
                  })
                  ->orWhereHas('assignee', function ($userQ) use ($searchValue) {
                      $userQ->where('name', 'like', "%{$searchValue}%");
                  });
            });
        }

        // Total records matching search + status filter
        $recordsFiltered = (clone $baseQuery)->count();

        // Column sorting
        $orderColumnIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $columns = [
            0 => 'classification',
            2 => 'remarks',
            3 => 'requested_by',
            6 => 'pending_remarks',
            7 => 'status',
        ];

        if (isset($columns[$orderColumnIndex])) {
            $baseQuery->orderBy($columns[$orderColumnIndex], $orderDir);
        } else {
            $baseQuery->orderByDesc('ticket_id');
        }

        // Pagination (LIMIT & OFFSET)
        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length > 0) {
            $baseQuery->skip($start)->take($length);
        }

        $tickets = $baseQuery->get();

        return response()->json([
            'draw'            => (int) $request->input('draw', 1),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $tickets,
        ]);
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request, TicketAnalyzer $analyzer)
    {
        $validator = Validator::make($request->all(), [
            'requested_by'       => 'required|string|max:255',
            'fk_provider_id'     => 'required|exists:provider_table,provider_id',
            'fk_request_type_id' => 'required|exists:request_type_table,request_type_id',
            'fk_category_id'     => 'required|exists:category_table,category_id',
            'remarks'            => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Get authenticated staff department.
        $departmentId = $user->fk_department_id;

        if (!$departmentId) {
            return response()->json([
                'message' => 'No department is assigned to your account.',
            ], 422);
        }

        // Default priority classification.
        $classification = 'Medium';

        // AI PRIORITY ANALYSIS
        try {
            $provider = Provider::where(
                'provider_id',
                $request->fk_provider_id
            )->firstOrFail();

            $serviceType = match (strtoupper(trim($provider->provider_code))) {
                'MIS'  => 'IT',
                'BMGS' => 'General Services',
                default => throw \Illuminate\Validation\ValidationException::withMessages([
                    'fk_provider_id' => 'Unsupported service provider.',
                ]),
            };

            $analysis = $analyzer->analyze(
                $request->remarks,
                $serviceType
            );

            $classification = $analysis['classification'];

        } catch (\Throwable $e) {
            Log::error('Ticket priority analysis failed.', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }

        try {
            DB::beginTransaction();

            // CREATE TICKET
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
                'is_walk_in'         => 'No',
            ]);

            // CREATE AUDIT LOG
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

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Ticket creation failed.', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unable to create ticket.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL TO CONCERNED SERVICE PROVIDERS
        |--------------------------------------------------------------------------
        */

        try {
            // Get the staff campus.
            $staffDepartment = Department::with('campus')
                ->find($departmentId);

            $campusId = $staffDepartment?->fk_campus_id;

            if (!$campusId) {
                Log::warning('Staff campus not found. Email notification skipped.', [
                    'ticket_id' => $ticket->ticket_id,
                    'user_id'   => $user->id,
                ]);
            } else {
                // Find all matching service provider accounts.
                $recipients = User::where('type', 'service_provider')
                    ->where('fk_provider_id', $request->fk_provider_id)
                    ->where('is_active', 1)
                    ->where('email', '!=', '')
                    ->whereHas('department', function ($query) use ($campusId) {
                        $query->where('fk_campus_id', $campusId);
                    })
                    ->get();

                $ticket->load([
                    'department.campus',
                    'category.requestType',
                ]);

                if ($recipients->isEmpty()) {
                    Log::warning('No matching service providers found.', [
                        'ticket_id'   => $ticket->ticket_id,
                        'campus_id'   => $campusId,
                        'provider_id' => $ticket->fk_provider_id,
                    ]);
                } else {
                    foreach ($recipients as $recipient) {
                        try {
                            Mail::to($recipient->email)
                                ->queue(new ServiceRequestSubmitted($ticket));

                            Log::info('Service request email sent.', [
                                'ticket_id'    => $ticket->ticket_id,
                                'recipient_id' => $recipient->id,
                                'email'        => $recipient->email,
                            ]);
                        } catch (\Throwable $mailException) {
                            Log::error('Failed to send service request email.', [
                                'ticket_id'    => $ticket->ticket_id,
                                'recipient_id' => $recipient->id,
                                'email'        => $recipient->email,
                                'error'        => $mailException->getMessage(),
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $mailException) {
            Log::error('Service request notification process failed.', [
                'ticket_id' => $ticket->ticket_id,
                'error'     => $mailException->getMessage(),
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Service request submitted successfully.',
            'ticket_id' => $ticket->ticket_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->where('created_by', auth()->id())
        ->findOrFail($id);

        return response()->json([
            'data' => $ticket
        ]);
    }

    /**
     * Update the specified ticket.
     */
    public function update(
        Request $request,
        string $id,
        TicketAnalyzer $analyzer
    ) {
        $ticket = Ticket::where('created_by', auth()->id())->findOrFail($id);

        if ($ticket->status !== 'For Approval') {
            return response()->json([
                'success' => false,
                'message' => 'Only tickets with "For Approval" status can be edited.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'requested_by' => [
                'required',
                'string',
                'max:255',
            ],
            'fk_provider_id' => [
                'required',
                'integer',
                'exists:provider_table,provider_id',
            ],
            'fk_request_type_id' => [
                'required',
                'integer',
                Rule::exists(
                    'request_type_table',
                    'request_type_id'
                )->where(function ($query) use ($request) {
                    $query->where(
                        'fk_provider_id',
                        $request->fk_provider_id
                    );
                }),
            ],
            'fk_category_id' => [
                'required',
                'integer',
                Rule::exists(
                    'category_table',
                    'category_id'
                )->where(function ($query) use ($request) {
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
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Retrieve selected service provider.
        $provider = Provider::where(
            'provider_id',
            $request->fk_provider_id
        )->firstOrFail();

        // Determine AI analysis context.
        $serviceType = match (
            strtoupper(trim($provider->provider_code))
        ) {
            'MIS'   => 'IT',
            'BMGS'  => 'General Services',
            default => null,
        };

        if ($serviceType === null) {
            return response()->json([
                'message' => 'Unsupported service provider.',
                'errors'  => [
                    'fk_provider_id' => [
                        'Only MIS and BMGS providers are supported.'
                    ],
                ],
            ], 422);
        }

        try {
            // Re-analyze updated remarks.
            $analysis = $analyzer->analyze(
                $request->remarks,
                $serviceType
            );

            DB::transaction(function () use (
                $ticket,
                $request,
                $analysis
            ) {
                // CAPTURE OLD DATA BEFORE UPDATE
                $oldData = [
                    'requested_by'   => $ticket->requested_by,
                    'fk_category_id' => $ticket->fk_category_id,
                    'remarks'        => $ticket->remarks,
                    'classification' => $ticket->classification,
                ];

                // UPDATE TICKET
                $ticket->update([
                    'requested_by'       => $request->requested_by,
                    'fk_provider_id'     => $request->fk_provider_id,
                    'fk_request_type_id' => $request->fk_request_type_id,
                    'fk_category_id'     => $request->fk_category_id,
                    'remarks'            => $request->remarks,
                    'classification'     => $analysis['classification'],
                ]);

                // CREATE AUDIT LOG
                AuditLogs::create([
                    'fk_user_id'  => auth()->id(),
                    'target_id'   => $ticket->ticket_id,
                    'action_type' => 'Update Ticket',
                    'payload'     => [
                        'old' => $oldData,
                        'new' => [
                            'requested_by'   => $ticket->requested_by,
                            'fk_category_id' => $ticket->fk_category_id,
                            'remarks'        => $ticket->remarks,
                            'classification' => $ticket->classification,
                        ],
                        'ai_analysis' => [
                            'reason'     => $analysis['reason'] ?? null,
                            'confidence' => $analysis['confidence'] ?? null,
                        ],
                    ],
                    'transaction_date' => now(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Ticket updated successfully.',
                'data'    => [
                    'ticket_id'      => $ticket->ticket_id,
                    'requested_by'   => $ticket->requested_by,
                    'remarks'        => $ticket->remarks,
                    'fk_category_id' => $ticket->fk_category_id,
                    'classification' => $analysis['classification'],
                    'reason'         => $analysis['reason'],
                    'confidence'     => $analysis['confidence'],
                ],
            ]);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the ticket. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $ticket = Ticket::where('created_by', auth()->id())->findOrFail($id);

            if ($ticket->status !== 'For Approval') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Only tickets with "For Approval" status can be deleted.',
                ], 403);
            }

            // CAPTURE TICKET DATA BEFORE DELETION
            $oldData = [
                'ticket_number'      => $ticket->ticket_number,
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
            ];

            $ticketId = $ticket->ticket_id;

            // DELETE TICKET
            $ticket->delete();

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id'       => auth()->id(),
                'target_id'        => $ticketId,
                'action_type'      => 'Delete Ticket',
                'payload'          => [
                    'deleted_ticket' => $oldData
                ],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return response()->json(1);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Ticket deletion failed.', [
                'ticket_id' => $id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete ticket.',
            ], 500);
        }
    }

/**
     * Acknowledge a completed ticket.
     */
    public function acknowledge(string $id)
    {
        try {
            DB::beginTransaction();

            $ticket = Ticket::where('created_by', auth()->id())->findOrFail($id);

            if ($ticket->status !== 'Completed') {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Only completed tickets can be acknowledged.',
                ], 422);
            }

            $oldStatus = $ticket->status;

            $ticket->update([
                'status' => 'Acknowledged',
            ]);

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id'       => auth()->id(),
                'target_id'        => $ticket->ticket_id,
                'action_type'      => 'Acknowledge Ticket',
                'payload'          => [
                    'ticket_number' => $ticket->ticket_number,
                    'old'           => [
                        'status' => $oldStatus,
                    ],
                    'new'           => [
                        'status' => $ticket->status,
                    ],
                ],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ticket acknowledged successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Ticket acknowledgment failed.', [
                'ticket_id' => $id,
                'user_id'   => auth()->id(),
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to acknowledge ticket. Please try again.',
            ], 500);
        }
    }
}