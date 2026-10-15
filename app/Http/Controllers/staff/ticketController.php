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
use Illuminate\Validation\Rule;
use DB;
use App\Services\TicketAnalyzer;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ticketController extends Controller
{
    /**
     * Display a listing of the resource.
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

    public function getTicket()
    {
       $tickets = Ticket::with([
        'department.campus',
        'category.requestType.provider',
        'creator',
        'assignee',
        ])
       ->where('created_by', auth()->id())
       ->where('status','For Approval')
       ->orderByDesc('ticket_id')
       ->get();

        return response()->json([
            'data' => $tickets
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request ,TicketAnalyzer $analyzer)
{
       $validator = Validator::make($request->all(), [
        'requested_by' => 'required|string|max:255',

        'fk_provider_id' => 'required|exists:provider_table,provider_id',

        'fk_request_type_id' => 'required|exists:request_type_table,request_type_id',

        'fk_category_id' => 'required|exists:category_table,category_id',

        'remarks' => 'required|string|max:5000',
    ]);

       if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated.',
        ], 401);
    }

        // Get the department assigned to the authenticated user.
    $departmentId = $user->fk_department_id;

    if (!$departmentId) {
        return response()->json([
            'message' => 'No department is assigned to your account.',
        ], 422);
    }

        // Analyze the remarks using OpenAI.
        // Use Medium as a fallback if the analyzer is unavailable.
    $classification = 'Medium';

    try {


        $provider = Provider::where(
            'provider_id',
            $request->fk_provider_id
        )->firstOrFail();

        $serviceType = match (strtoupper($provider->provider_code)) {
            'MIS' => 'IT',
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

    } catch (Throwable $e) {
        Log::error('Ticket priority analysis failed.', [
            'user_id' => $user->id,
            'error' => $e->getMessage(),
        ]);
    }

        // Generate the ticket number.
    $ticketNumber = 'TKT-' . now()->format('YmdHis')
    . '-' . $user->id;

        // Save the ticket with its AI-generated classification.
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
        'is_walk_in' => 'No',
    ]);


    return response()->json(true);
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
 public function update(
    Request $request,
    string $id,
    TicketAnalyzer $analyzer
) {
    $ticket = Ticket::findOrFail($id);

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

    // Retrieve the selected service provider.
    $provider = Provider::where(
        'provider_id',
        $request->fk_provider_id
    )->firstOrFail();

    // Determine the correct AI analysis context.
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
            'errors' => [
                'fk_provider_id' => [
                    'Only MIS and BMGS providers are supported.'
                ],
            ],
        ], 422);
    }

    try {
        // Re-analyze the updated remarks using the provider context.
        $analysis = $analyzer->analyze(
            $request->remarks,
            $serviceType
        );

        DB::transaction(function () use (
            $ticket,
            $request,
            $analysis
        ) {
            $ticket->update([
                'requested_by' => $request->requested_by,
                'fk_category_id' => $request->fk_category_id,
                'remarks' => $request->remarks,
                'classification' => $analysis['classification'],
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully.',
            'data' => [
                'ticket_id' => $ticket->ticket_id,
                'requested_by' => $ticket->requested_by,
                'remarks' => $ticket->remarks,
                'fk_category_id' => $ticket->fk_category_id,
                'classification' => $analysis['classification'],
                'reason' => $analysis['reason'],
                'confidence' => $analysis['confidence'],
            ],
        ]);

    } catch (\Throwable $e) {
        report($e);

        
        return response()->json([
            'success' => $e,
            'message' => 'Unable to update the ticket. Please try again.',
        ], 500);

    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->delete();

        return response()->json(1);
    }
}
