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
use Illuminate\Validation\Rule;
use DB;
use App\Services\TicketAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\AuditLogs;




class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('provider.ticket');
    }


    public function createData()
{
    // Load active workers with their department and campus
    $users = User::with([
            'department.campus'
        ])
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

        'campuses' => Campus::orderBy('campus_name')->get(),

        'departments' => Department::orderBy('department_name')->get(),

        'providers' => Provider::orderBy('provider_name')->get(),

        'request_types' => RequestType::orderBy('rt_name')->get(),

        'categories' => Category::orderBy('category_name')->get(),

        'users' => $users,

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
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request, TicketAnalyzer $analyzer)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

    // Validate submitted data.
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
                'errors' => $validator->errors(),
            ], 422);
        }

    // Ensure the submitted provider matches the authenticated
    // provider account, when the account has a provider assigned.
        if (
            $user->fk_provider_id &&
            (int) $user->fk_provider_id !== (int) $request->fk_provider_id
        ) {
            return response()->json([
                'message' => 'You are not authorized to create tickets for this provider.',
            ], 403);
        }

    // Get the department of the authenticated user.
        $departmentId = $user->fk_department_id;

        if (!$departmentId) {
            return response()->json([
                'message' => 'No department is assigned to your account.',
            ], 422);
        }

    // Retrieve the selected provider.
        $provider = Provider::where(
            'provider_id',
            $request->fk_provider_id
        )->first();

        if (!$provider) {
            return response()->json([
                'message' => 'Selected provider was not found.',
            ], 422);
        }

    // Determine the AI analysis context.
        $serviceType = match (
            strtoupper(trim($provider->provider_code))
        ) {
            'MIS' => 'IT',
            'BMGS' => 'General Services',
            default => null,
        };

        if ($serviceType === null) {
            return response()->json([
                'message' => 'Unsupported service provider.',
            ], 422);
        }

    // Default classification if AI analysis fails.
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
                'error' => $e->getMessage(),
            ]);
        }


        try {

            DB::beginTransaction();

        // CREATE TICKET
            $ticket = Ticket::create([
                'requested_by' => $request->requested_by,
                'fk_department_id' => $departmentId,
                'fk_provider_id' => $request->fk_provider_id,
                'fk_request_type_id' => $request->fk_request_type_id,
                'fk_category_id' => $request->fk_category_id,
                'remarks' => $request->remarks,
                'created_by' => $user->id,
                'assign_to' => null,
                'status' => 'For Approval',
                'classification' => $classification,
                'is_walk_in' => 'Yes',

            ]);

        // CREATE AUDIT LOG
            AuditLogs::create([

                'fk_user_id' => $user->id,

                'target_id' => $ticket->ticket_id,

                'action_type' => 'Create Ticket',

                'payload' => [

                    'requested_by' => $ticket->requested_by,
                    'fk_department_id' => $ticket->fk_department_id,
                    'fk_provider_id' => $ticket->fk_provider_id,
                    'fk_request_type_id' => $ticket->fk_request_type_id,
                    'fk_category_id' => $ticket->fk_category_id,
                    'remarks' => $ticket->remarks,
                    'created_by' => $ticket->created_by,
                    'assign_to' => $ticket->assign_to,
                    'status' => $ticket->status,
                    'classification' => $ticket->classification,
                    'is_walk_in' => $ticket->is_walk_in,

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Provider ticket creation failed.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create ticket. Please try again.',
            ], 500);
        }
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


   public function getTicket()
{
    $user = auth()->user();

    $campus_id = $user->department?->fk_campus_id;

    if (!$campus_id) {
        return response()->json([
            'data' => [],
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
    ->where('status', 'For Approval')
    ->orderByDesc('ticket_id')
    ->get();

    return response()->json([
        'data' => $tickets
    ]);
}


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

    // Authenticated provider
    $providerId = $user->fk_provider_id;

    if (!$providerId) {
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to approve tickets.'
        ], 403);
    }

    // Retrieve ticket and its service provider
    $ticket = Ticket::with([
        'category.requestType'
    ])->findOrFail($id);

    $ticketProviderId = $ticket->category
        ? $ticket->category->requestType->fk_provider_id
        : null;

    // Verify ticket belongs to authenticated provider
    if ((int) $ticketProviderId !== (int) $providerId) {
        return response()->json([
            'success' => false,
            'message' => 'You cannot approve this ticket.'
        ], 403);
    }

    // Only tickets awaiting approval can be approved
    if ($ticket->status !== 'For Approval') {
        return response()->json([
            'success' => false,
            'message' => 'This ticket is no longer awaiting approval.'
        ], 422);
    }

    // Verify worker belongs to this provider
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

    try {

        DB::transaction(function () use (
            $ticket,
            $worker,
            $user
        ) {

            $oldStatus = $ticket->status;

            // Update ticket
            $ticket->update([
                'assign_to' => $worker->id,
                'status' => 'Accepted'
            ]);

            // Record status history
            DB::table('status_history_table')->insert([
                'ticket_id' => $ticket->ticket_id,
                'fk_user_id' => $user->id,
                'status' => 'Accepted',
                'remarks' => 'Ticket approved and assigned to ' . $worker->name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Record audit log
            AuditLogs::create([
                'fk_user_id' => $user->id,
                'target_id' => $ticket->ticket_id,
                'action_type' => 'TICKET_APPROVED_AND_ASSIGNED',
                'payload' => [
                    'ticket_id' => $ticket->ticket_id,
                    'old_status' => $oldStatus,
                    'new_status' => 'Accepted',
                    'assigned_worker_id' => $worker->id,
                    'assigned_worker_name' => $worker->name
                ],
                'transaction_date' => now()
            ]);

        });

        return response()->json([
            'success' => true,
            'message' => 'Ticket approved and worker assigned successfully.'
        ]);

    } catch (\Throwable $e) {

        report($e);

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong while approving the ticket.'
        ], 500);
    }
}
}
