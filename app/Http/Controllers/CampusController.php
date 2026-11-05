<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Campus;
use App\Models\AuditLogs;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function validator(array $data)
    {
        return Validator::make($data, [

            'campus_name' => ['required', 'string', 'max:255', 'unique:campus_table,campus_name'],
            'campus_code' => ['required', 'string', 'max:255', 'unique:campus_table,campus_code'],

        ], [

            'campus_name.unique' => 'Campus Name already exist.',
            'campus_code.unique' => 'Campus Code already exist.'

        ]);
    }

    public function index()
    {
        return view('admin.campus');
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
        try {

            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
            }

            $campus = new Campus;
            $campus->campus_name = $request->campus_name;
            $campus->campus_code = $request->campus_code;
            $campus->save();

            if ($campus) {

                // AUDIT LOG - CREATE
                AuditLogs::create([
                    'fk_user_id' => Auth::id(),
                    'target_id' => $campus->campus_id,
                    'action_type' => 'Create Campus',
                    'payload' => [
                        'campus_name' => $request->campus_name,
                        'campus_code' => $request->campus_code
                    ],
                    'transaction_date' => now(),
                ]);

                return true;
            }

            return false;

        } catch (\Throwable $e) {

            report($e);

            return 3;
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
        $data = DB::table("campus_table")
            ->select("*")
            ->where('campus_id', $id)
            ->get();

        return response()->json(["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validator = Validator::make($request->all(), [

                'campus_name' => 'required|string|max:255|unique:campus_table,campus_name,' . $id . ',campus_id',
                'campus_code' => 'required|string|max:255|unique:campus_table,campus_code,' . $id . ',campus_id',

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            // Capture OLD data
            $oldData = DB::table('campus_table')
                ->where('campus_id', $id)
                ->first();

            $update = DB::table('campus_table')
                ->where('campus_id', $id)
                ->update([
                    "campus_name" => $request->campus_name,
                    "campus_code" => $request->campus_code
                ]);

            if ($update) {

                // AUDIT LOG - UPDATE
                AuditLogs::create([
                    'fk_user_id' => Auth::id(),
                    'target_id' => $id,
                    'action_type' => 'Update Campus',
                    'payload' => [
                        'old' => [
                            'campus_name' => $oldData->campus_name,
                            'campus_code' => $oldData->campus_code
                        ],
                        'new' => [
                            'campus_name' => $request->campus_name,
                            'campus_code' => $request->campus_code
                        ]
                    ],
                    'transaction_date' => now(),
                ]);

                return true;
            }

            return false;

        } catch (\Throwable $e) {

            report($e);

            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            // Get data before deletion
            $oldData = DB::table('campus_table')
                ->where('campus_id', $id)
                ->first();

            $delete = DB::table('campus_table')
                ->where('campus_id', $id)
                ->delete();

            if ($delete != 0) {

                // AUDIT LOG - DELETE
                AuditLogs::create([
                    'fk_user_id' => Auth::id(),
                    'target_id' => $id,
                    'action_type' => 'Delete Campus',
                    'payload' => [
                        'deleted_campus' => [
                            'campus_name' => $oldData->campus_name,
                            'campus_code' => $oldData->campus_code
                        ]
                    ],
                    'transaction_date' => now(),
                ]);

                return true;
            }

            return false;

        } catch (\Throwable $e) {

            report($e);

            return false;
        }
    }

    public function getCampus()
    {
        $campus = Campus::all();

        return response()->json([
            'data' => $campus
        ]);
    }
}
