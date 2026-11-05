<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use App\Models\Campus;
use App\Models\RequestType;
use App\Models\Provider;
use App\Models\AuditLogs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display the ticket management page.
     */
    public function index()
    {
        return view('admin.ticket');
    }

    /**
     * Return ticket data for DataTables.
     */
    public function getTicket()
    {
        $tickets = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->orderByDesc('ticket_id')
        ->get();

        return response()->json([
            'data' => $tickets
        ]);
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
            'campuses' => Campus::orderBy('campus_name')->get(),
            'departments' => Department::orderBy('department_name')->get(),
            'providers' => Provider::orderBy('provider_name')->get(),
            'request_types' => RequestType::orderBy('rt_name')->get(),
            'categories' => Category::orderBy('category_name')->get(),
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'ticket_number' => [
                'required',
                'string',
                'max:255',
                'unique:ticket_table,ticket_number',
            ],

            'remarks' => 'required|string',

            'fk_department_id' => [
                'required',
                'exists:department_table,department_id',
            ],

            'fk_category_id' => [
                'required',
                'exists:category_table,category_id',
            ],

            'created_by' => 'nullable|exists:users,id',

            'assign_to' => 'nullable|exists:users,id',

            'classification' => [
                'nullable',
                'in:High,Medium',
            ],

            'is_walk_in' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            DB::beginTransaction();

            // CREATE TICKET
            $ticket = Ticket::create([
                'ticket_number' => $request->ticket_number,
                'remarks' => $request->remarks,
                'fk_department_id' => $request->fk_department_id,
                'fk_category_id' => $request->fk_category_id,
                'created_by' => $request->created_by,
                'assign_to' => $request->assign_to,
                'status' => 'Accepted',
                'is_walk_in' => $request->is_walk_in,
                'classification' => $request->classification,
            ]);

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id' => Auth::id(),
                'target_id' => $ticket->ticket_id,
                'action_type' => 'Create Ticket',
                'payload' => [
                    'ticket_number' => $ticket->ticket_number,
                    'remarks' => $ticket->remarks,
                    'fk_department_id' => $ticket->fk_department_id,
                    'fk_category_id' => $ticket->fk_category_id,
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

            Log::error('Ticket creation failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Unable to create ticket.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified ticket.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])->findOrFail($id);

        return response()->json([
            'data' => $ticket
        ]);
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
        ])->findOrFail($id);

        return response()->json([
            'data' => $ticket
        ]);
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validator = Validator::make($request->all(), [

            'ticket_number' => [
                'required',
                'string',
                'max:255',
                'unique:ticket_table,ticket_number,' . $id . ',ticket_id',
            ],

            'remarks' => 'required|string',

            'fk_department_id' => [
                'required',
                'exists:department_table,department_id',
            ],

            'fk_category_id' => [
                'required',
                'exists:category_table,category_id',
            ],

            'created_by' => 'nullable|exists:users,id',

            'assign_to' => 'nullable|exists:users,id',

            'classification' => [
                'nullable',
                'in:High,Medium',
            ],

            'is_walk_in' => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            DB::beginTransaction();

            // CAPTURE OLD DATA BEFORE UPDATE
            $oldData = [
                'ticket_number' => $ticket->ticket_number,
                'remarks' => $ticket->remarks,
                'fk_department_id' => $ticket->fk_department_id,
                'fk_category_id' => $ticket->fk_category_id,
                'created_by' => $ticket->created_by,
                'assign_to' => $ticket->assign_to,
                'status' => $ticket->status,
                'classification' => $ticket->classification,
                'is_walk_in' => $ticket->is_walk_in,
            ];

            // UPDATE TICKET
            $ticket->update([
                'ticket_number' => $request->ticket_number,
                'remarks' => $request->remarks,
                'fk_department_id' => $request->fk_department_id,
                'fk_category_id' => $request->fk_category_id,
                'created_by' => $request->created_by,
                'assign_to' => $request->assign_to,
                // 'status' => $request->status,
                'classification' => $request->classification,
                'is_walk_in' => $request->is_walk_in,
            ]);

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id' => Auth::id(),
                'target_id' => $ticket->ticket_id,
                'action_type' => 'Update Ticket',
                'payload' => [
                    'old' => $oldData,
                    'new' => [
                        'ticket_number' => $ticket->ticket_number,
                        'remarks' => $ticket->remarks,
                        'fk_department_id' => $ticket->fk_department_id,
                        'fk_category_id' => $ticket->fk_category_id,
                        'created_by' => $ticket->created_by,
                        'assign_to' => $ticket->assign_to,
                        'status' => $ticket->status,
                        'classification' => $ticket->classification,
                        'is_walk_in' => $ticket->is_walk_in,
                    ]
                ],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Ticket update failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Unable to update ticket.',
                'message' => $e->getMessage()
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

            $ticket = Ticket::findOrFail($id);

            // CAPTURE TICKET DATA BEFORE DELETION
            $oldData = [
                'ticket_number' => $ticket->ticket_number,
                'remarks' => $ticket->remarks,
                'fk_department_id' => $ticket->fk_department_id,
                'fk_category_id' => $ticket->fk_category_id,
                'created_by' => $ticket->created_by,
                'assign_to' => $ticket->assign_to,
                'status' => $ticket->status,
                'classification' => $ticket->classification,
                'is_walk_in' => $ticket->is_walk_in,
            ];

            $ticketId = $ticket->ticket_id;

            // DELETE TICKET
            $ticket->delete();

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id' => Auth::id(),
                'target_id' => $ticketId,
                'action_type' => 'Delete Ticket',
                'payload' => [
                    'deleted_ticket' => $oldData
                ],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return response()->json(1);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Ticket deletion failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Unable to delete ticket.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
