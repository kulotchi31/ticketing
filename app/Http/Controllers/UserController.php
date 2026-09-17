<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use auth;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Campus;
use App\Models\Provider;
use App\Models\Department;
use Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::all();

        $providers = Provider::all();

        return view('admin.user', compact('campuses'),compact('providers'));
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
            'username.unique' => 'Username already exists.',

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

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'type' => $request->type,

            'fk_department_id' => $request->fk_department_id,

            'is_active' => $request->is_active,

            'fk_provider_id' => $request->fk_provider_id

        ]);


        DB::commit();


        /*
        ========================================
        SUCCESS
        ========================================
        */

        return response()->json(true);

    }
    catch (\Exception $e) {

        DB::rollBack();


        /*
        Optional: Debug error
        */

        \Log::error($e->getMessage());


        return response()->json($e);

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
     * Update the specified resource in storage.
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
                        Rule::unique('users', 'email')
                        ->ignore($id)
                    ],

                    'type' => [
                        'required',
                        'in:admin,user,worker'
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




                $user = User::findOrFail($id);



                $user->name = $request->name;

                $user->email = $request->email;

                $user->type = $request->type;

                $user->is_active = $request->is_active;


                if ($request->type === 'admin') {

                    $user->fk_department_id= null;
                    $user->fk_provider_id= null;

                }





                else if ($request->type == 'user' ) {

                $user->fk_department_id = $request->department_id;
                 $user->fk_provider_id= null;
                }

                else
                {

                $user->fk_department_id = $request->department_id;
                 $user->fk_provider_id = $request->fk_provider_id;

                }




                $user->save();


                return response()->json(true);

            }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUsers(Request $request)
    {
       $users = User::with('department.campus')->get();

        return response()->json(['data' => $users]);
    }

    public function getDepartmentsByCampus($campus_id)
    {
        $departments = Department::where(
            'fk_campus_id',
            $campus_id
        )->get();

        return response()->json($departments);
    }
}
