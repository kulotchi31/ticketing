<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Campus;
use App\Models\AuditLogs;

class DeparmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::all();

        return view('admin.department', compact('campuses'));
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
        $departmentName = $request->department_name;
        $departmentCode = $request->department_code;
        $campusId = $request->campus_id;

        $exists = Department::where('department_name', $departmentName)
            ->where('fk_campus_id', $campusId)
            ->exists();

        if ($exists) {
            return response()->json(0);
        }

        $department = new Department();

        $department->department_name = $departmentName;
        $department->department_code = $departmentCode;
        $department->fk_campus_id = $campusId;

        $department->save();

        // AUDIT LOG: CREATE DEPARTMENT
        AuditLogs::create([
            'fk_user_id' => Auth::id(),
            'target_id' => $department->department_id,
            'action_type' => 'Create Department',
            'payload' => [
                'department_name' => $department->department_name,
                'department_code' => $department->department_code,
                'fk_campus_id' => $department->fk_campus_id,
            ],
            'transaction_date' => now(),
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
    public function edit($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(false);
        }

        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(3);
        }

        // Store old values before updating
        $oldValues = [
            'department_name' => $department->department_name,
            'department_code' => $department->department_code,
            'fk_campus_id' => $department->fk_campus_id,
        ];

        // Check if there are no changes
        if (
            $department->department_name == $request->department_name &&
            $department->department_code == $request->department_code &&
            $department->fk_campus_id == $request->campus_id
        ) {
            return response()->json(0);
        }

        $department->department_name = $request->department_name;
        $department->department_code = $request->department_code;
        $department->fk_campus_id = $request->campus_id;

        $department->save();

        // AUDIT LOG: UPDATE DEPARTMENT
        AuditLogs::create([
            'fk_user_id' => Auth::id(),
            'target_id' => $department->department_id,
            'action_type' => 'Update Department',
            'payload' => [
                'old' => $oldValues,
                'new' => [
                    'department_name' => $department->department_name,
                    'department_code' => $department->department_code,
                    'fk_campus_id' => $department->fk_campus_id,
                ],
            ],
            'transaction_date' => now(),
        ]);

        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(3);
        }

        // Capture department details before deleting
        $deletedDepartment = [
            'department_name' => $department->department_name,
            'department_code' => $department->department_code,
            'fk_campus_id' => $department->fk_campus_id,
        ];

        $departmentId = $department->department_id;

        $department->delete();

        // AUDIT LOG: DELETE DEPARTMENT
        AuditLogs::create([
            'fk_user_id' => Auth::id(),
            'target_id' => $departmentId,
            'action_type' => 'Delete Department',
            'payload' => [
                'deleted_department' => $deletedDepartment,
            ],
            'transaction_date' => now(),
        ]);

        return response()->json(true);
    }

    /**
     * Get all departments with campus relationship.
     */
    public function getDepartment()
    {
        $departments = Department::with('campus')->get();

        return response()->json([
            'data' => $departments
        ]);
    }
}