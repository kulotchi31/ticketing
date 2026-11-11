<?php

namespace App\Http\Controllers\worker;

use App\Http\Controllers\Controller;

use App\Models\Ticket;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use App\Models\Campus;
use App\Models\RequestType;
use App\Models\Provider;
use App\Models\AuditLogs;
use App\Models\StatusHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\WorkerTicketStatusUpdated;

class TicketController extends Controller
{
    /**
     * Display worker tickets.
     */
    public function index()
    {
        return view('worker.ticket');
    }

    /**
     * Display pending tickets.
     */
    public function showPending()
    {
        return view('worker.pending');
    }

    /**
     * Display work-in-progress tickets.
     */
    public function showWip()
    {
        return view('worker.wip');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource.
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
     * Show ticket details for editing.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->where('ticket_id', $id)
        ->where('assign_to', auth()->id())
        ->firstOrFail();

        return response()->json([
            'data' => $ticket
        ]);
    }

    /**
     * Update ticket status and save history and audit logs.
     */
    
public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [

        'status' => [
            'required',
            'in:Work In Progress,Pending,Completed',
        ],

        'pending_remarks' => [
            'nullable',
            'required_if:status,Pending',
            'string',
            'max:5000',
        ],

        'action_taken' => [
            'nullable',
            'required_if:status,Completed',
            'string',
            'max:5000',
        ],

    ], [
        'status.required' =>
            'Please select a ticket status.',

        'status.in' =>
            'The selected status is invalid.',

        'pending_remarks.required_if' =>
            'Please provide remarks when the ticket is pending.',

        'pending_remarks.max' =>
            'Pending remarks must not exceed 5000 characters.',

        'action_taken.required_if' =>
            'Please provide the action taken when completing the ticket.',

        'action_taken.max' =>
            'Action taken must not exceed 5000 characters.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors(),
        ], 422);
    }

    try {

        // Find ticket assigned to authenticated worker
        $ticket = Ticket::where('ticket_id', $id)
            ->where('assign_to', auth()->id())
            ->firstOrFail();

        $oldStatus = $ticket->status;

        // Capture old values
        $oldValues = [
            'status' => $ticket->status,
            'pending_remarks' => $ticket->pending_remarks,
            'action_taken' => $ticket->action_taken,
        ];

        // Prepare new values
        $newValues = [
            'status' => $request->status,

            'pending_remarks' => $request->status === 'Pending'
                ? $request->pending_remarks
                : null,

            'action_taken' => $request->status === 'Completed'
                ? $request->action_taken
                : null,
        ];

        // Update database
        DB::transaction(function () use (
            $ticket,
            $newValues,
            $oldValues,
            $oldStatus,
            $request
        ) {

            // Lock ticket while updating
            $ticket = Ticket::where('ticket_id', $ticket->ticket_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Update ticket
            $ticket->update($newValues);

            /*
            |--------------------------------------------------------------------------
            | STATUS HISTORY
            |--------------------------------------------------------------------------
            */

            if ($oldStatus !== $request->status) {

                $remarks = match ($request->status) {
                    'Pending' => $request->pending_remarks,
                    'Completed' => $request->action_taken,
                    default => null,
                };

                StatusHistory::create([
                    'ticket_id' => $ticket->ticket_id,
                    'fk_user_id' => auth()->id(),
                    'status' => $request->status,
                    'remarks' => $remarks,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | AUDIT LOGS
            |--------------------------------------------------------------------------
            */

            AuditLogs::create([
                'fk_user_id' => auth()->id(),

                'target_id' => $ticket->ticket_id,

                'action_type' => 'Update Ticket',

                'payload' => [
                    'ticket_number' => $ticket->ticket_number,
                    'old_values' => $oldValues,
                    'new_values' => $newValues,
                    'updated_by' => auth()->user()->name,
                ],

                'transaction_date' => now(),
            ]);

        });

        /*
        |--------------------------------------------------------------------------
        | EMAIL NOTIFICATION TO REQUESTER
        |--------------------------------------------------------------------------
        | Send only when the ticket status actually changes.
        */

        if ($oldStatus !== $request->status) {

            try {

                // Reload ticket relationships
                $ticket->refresh();

                $ticket->load([
                    'creator',
                    'assignee',
                    'department',
                    'category',
                ]);

                // Get requester's email
                $requester = $ticket->creator;

                if ($requester && $requester->email) {

                    Mail::to($requester->email)
                        ->queue(new WorkerTicketStatusUpdated(
                            $ticket,
                            $oldStatus,
                            $request->status
                        ));

                    Log::info('Worker ticket status notification queued.', [
                        'ticket_id' => $ticket->ticket_id,
                        'requester_email' => $requester->email,
                        'old_status' => $oldStatus,
                        'new_status' => $request->status,
                    ]);

                } else {

                    Log::warning('Requester email not found.', [
                        'ticket_id' => $ticket->ticket_id,
                        'created_by' => $ticket->created_by,
                    ]);

                }

            } catch (\Throwable $e) {

                // Email failure should not undo a successful ticket update
                Log::error('Worker ticket notification failed.', [
                    'ticket_id' => $id,
                    'error' => $e->getMessage(),
                ]);

            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Ticket status updated successfully. Requester notification has been processed.',
            'data' => $ticket->fresh(),
        ]);

    } catch (\Throwable $e) {

        Log::error('Worker ticket update failed.', [
            'ticket_id' => $id,
            'user_id' => auth()->id(),
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Unable to update ticket status. Please try again.',
        ], 500);
    }
}


    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Get accepted tickets assigned to the worker.
     */
    public function getAcceptedTicket()
    {
        $tickets = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->where('status', 'Accepted')
        ->where('assign_to', auth()->id())
        ->orderByDesc('ticket_id')
        ->get();

        return response()->json([
            'data' => $tickets
        ]);
    }

    /**
     * Get pending tickets assigned to the worker.
     */
    public function getPendingTicket()
    {
        $tickets = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->where('status', 'Pending')
        ->where('assign_to', auth()->id())
        ->orderByDesc('ticket_id')
        ->get();

        return response()->json([
            'data' => $tickets
        ]);
    }

    /**
     * Get work-in-progress tickets assigned to the worker.
     */
    public function getWipTicket()
    {
        $tickets = Ticket::with([
            'department.campus',
            'category.requestType.provider',
            'creator',
            'assignee',
        ])
        ->where('status', 'Work In Progress')
        ->where('assign_to', auth()->id())
        ->orderByDesc('ticket_id')
        ->get();

        return response()->json([
            'data' => $tickets
        ]);
    }

    /**
     * Get status history of a ticket assigned to the worker.
     */
    public function getStatusHistory(string $id)
    {
        $ticket = Ticket::where('ticket_id', $id)
            ->where('assign_to', auth()->id())
            ->firstOrFail();

        $history = StatusHistory::with('worker')
            ->where('ticket_id', $ticket->ticket_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'data' => $history,
        ]);
    }
}
