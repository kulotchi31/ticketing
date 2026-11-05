<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Campus;
use App\Models\Provider;
use App\Models\Department;
use App\Models\AuditLogs;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::all();
        $providers = Provider::all();

        return view('admin.user', compact('campuses', 'providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            /*
            ========================================
            VALIDATION
            ========================================
            */

            $validator = Validator::make($request->all(), [

                'name' => 'required|string|max:255',

                'email' => 'required|email|max:255|unique:users,email',

                'password' => 'required|string|min:6',

                'type' => 'required',

                'fk_department_id' => 'nullable',

                'is_active' => 'required'

            ], [

                'name.required' => 'Full Name is required.',

                'email.required' => 'Email Address is required.',

                'email.email' => 'Please enter a valid email address.',

                'email.unique' => 'Email Address already exists.',

                'password.required' => 'Password is required.',

                'password.min' => 'Password must be at least 6 characters.',

                'type.required' => 'User Role is required.',

                'is_active.required' => 'Account Status is required.'

            ]);

            /*
            ========================================
            VALIDATION ERROR
            ========================================
            */

            if ($validator->fails()) {

                DB::rollBack();

                return response()->json([
                    'errors' => $validator->errors()
                ]);

            }

            /*
            ========================================
            CREATE USER
            ========================================
            */

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

                'type' => $request->type,

                'fk_department_id' => $request->department_id,

                'is_active' => $request->is_active,

                'fk_provider_id' => $request->fk_provider_id

            ]);

            /*
            ========================================
            AUDIT LOG: CREATE USER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $user->id,

                'action_type' => 'Create User',

                'payload' => [

                    'name' => $user->name,

                    'email' => $user->email,

                    'type' => $user->type,

                    'fk_department_id' => $user->fk_department_id,

                    'fk_provider_id' => $user->fk_provider_id,

                    'is_active' => $user->is_active,

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            /*
            ========================================
            SUCCESS
            ========================================
            */

            return response()->json(true);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Unable to create user.',
                'message' => $e->getMessage()
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
        $user = User::with('department.campus')
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],

            'type' => [
                'required',
                'in:admin,user,worker,staff,service_provider'
            ],

            'department_id' => [
                'nullable',
                'required_unless:type,admin'
            ],

            'is_active' => [
                'required',
                'boolean'
            ]

        ]);

        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            /*
            ========================================
            STORE OLD VALUES
            ========================================
            */

            $oldValues = [

                'name' => $user->name,

                'email' => $user->email,

                'type' => $user->type,

                'is_active' => $user->is_active,

                'fk_department_id' => $user->fk_department_id,

                'fk_provider_id' => $user->fk_provider_id,

            ];

            /*
            ========================================
            UPDATE USER
            ========================================
            */

            $user->name = $request->name;

            $user->email = $request->email;

            $user->type = $request->type;

            $user->is_active = $request->is_active;

            if ($request->type === 'admin') {

                $user->fk_department_id = null;

                $user->fk_provider_id = null;

            } else if ($request->type == 'user') {

                $user->fk_department_id = $request->department_id;

                $user->fk_provider_id = null;

            } else {

                $user->fk_department_id = $request->department_id;

                $user->fk_provider_id = $request->fk_provider_id;

            }

            $user->save();

            /*
            ========================================
            AUDIT LOG: UPDATE USER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $user->id,

                'action_type' => 'Update User',

                'payload' => [

                    'old' => $oldValues,

                    'new' => [

                        'name' => $user->name,

                        'email' => $user->email,

                        'type' => $user->type,

                        'is_active' => $user->is_active,

                        'fk_department_id' => $user->fk_department_id,

                        'fk_provider_id' => $user->fk_provider_id,

                    ]

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Unable to update user.',
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            /*
            ========================================
            STORE USER DETAILS BEFORE DELETING
            ========================================
            */

            $deletedUser = [

                'name' => $user->name,

                'email' => $user->email,

                'type' => $user->type,

                'is_active' => $user->is_active,

                'fk_department_id' => $user->fk_department_id,

                'fk_provider_id' => $user->fk_provider_id,

            ];

            $userId = $user->id;

            /*
            ========================================
            DELETE USER
            ========================================
            */

            $user->delete();

            /*
            ========================================
            AUDIT LOG: DELETE USER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $userId,

                'action_type' => 'Delete User',

                'payload' => [

                    'deleted_user' => $deletedUser

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json([
                'error' => 'Unable to delete user.',
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Get all users with department and campus relationship.
     */
    public function getUsers(Request $request)
    {
        $users = User::with('department.campus')->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Get departments by campus.
     */
    public function getDepartmentsByCampus($campus_id)
    {
        $departments = Department::where(
            'fk_campus_id',
            $campus_id
        )->get();

        return response()->json($departments);
    }
}
