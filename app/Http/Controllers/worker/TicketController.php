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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('worker.ticket');
    }

     public function showPending()
    {
        return view('worker.pending');
    }

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $ticket = Ticket::findOrFail($id);

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
        ], [
            'status.required' => 'Please select a ticket status.',
            'status.in' => 'The selected status is invalid.',
            'pending_remarks.required_if' =>
            'Please provide remarks when the ticket is pending.',
            'pending_remarks.max' =>
            'Pending remarks must not exceed 5000 characters.',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket->update([
            'status' => $request->status,

            'pending_remarks' => $request->status === 'Pending'
            ? $request->pending_remarks
            : null,

               
            'action_taken' => $request->status === 'Completed'
            ? $request->action_taken
            : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket status updated successfully.',
            'data' => $ticket->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


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


    


    
}
