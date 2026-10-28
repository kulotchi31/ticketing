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
}
