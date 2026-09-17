<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Auth;
use Rules;
use Validator;
use DB;


class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function validator(array $data)
        {
            return Validator::make($data, [

                'provider_name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:provider_table,provider_name'
                ],

                'provider_code' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:provider_table,provider_code'
                ],

            ], [

                'provider_name.unique' => 'Provider Name already exists.',
                'provider_code.unique' => 'Provider Code already exists.'

            ]);
        }

    public function index()
    {
           return view('admin.provider');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $provider = new Provider;

        $provider->provider_name = $request->provider_name;
        $provider->provider_code = $request->provider_code;

        $provider->save();

        if ($provider) {

            // AuditLogs::create([
            //     'fk_user_id'       => Auth::id(),
            //     'target_id'        => $provider->provider_id,
            //     'action_type'      => 'Create Provider',
            //     'payload'          => [
            //         'name' => $request->provider_name,
            //         'code' => $request->provider_code
            //     ],
            //     'transaction_date' => now(),
            // ]);

            return true;
        }

        return false;

    } catch (\Throwable $e) {

        return $e;

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
            $data = DB::table("provider_table")
            ->select("*")
            ->where('provider_id', $id)
            ->get();

            return response()->json([
                "data" => $data
            ]);
        }


        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            try {

                $validator = Validator::make($request->all(), [

                    'provider_name' =>
                    'required|string|max:255|unique:provider_table,provider_name,' . $id . ',provider_id',

                    'provider_code' =>
                    'required|string|max:255|unique:provprovider_tableiders,provider_code,' . $id . ',provider_id',

                ], [

                    'provider_name.unique' => 'Provider Name already exists.',
                    'provider_code.unique' => 'Provider Code already exists.'

                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ]);
                }


                // Capture OLD data
                $oldData = DB::table('provider_table')
                ->where('provider_id', $id)
                ->first();


                $update = DB::table('providers')
                ->where('provider_id', $id)
                ->update([

                    "provider_name" => $request->provider_name,
                    "provider_code" => $request->provider_code

                ]);


                if ($update) {

                    // LOG THE UPDATE
                    // AuditLogs::create([
                    //     'fk_user_id'       => Auth::id(),
                    //     'target_id'        => $id,
                    //     'action_type'      => 'Update Provider',
                    //     'payload'          => [
                    //         'old' => [
                    //             'name' => $oldData->provider_name,
                    //             'code' => $oldData->provider_code
                    //         ],
                    //         'new' => [
                    //             'name' => $request->provider_name,
                    //             'code' => $request->provider_code
                    //         ]
                    //     ],
                    //     'transaction_date' => now(),
                    // ]);

                    return true;
                }

                return false;

            } catch (\Throwable $e) {

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
                $oldData = DB::table('provider_table')
                ->where('provider_id', $id)
                ->first();


                $delete = DB::table('provider_table')
                ->where('provider_id', $id)
                ->delete();


                if ($delete != 0) {

                    // LOG THE DELETION
                    // AuditLogs::create([
                    //     'fk_user_id'       => Auth::id(),
                    //     'target_id'        => $id,
                    //     'action_type'      => 'Delete Provider',
                    //     'payload'          => [
                    //         'deleted_provider' => $oldData->provider_name
                    //     ],
                    //     'transaction_date' => now(),
                    // ]);

                    return true;
                }

                return false;

            } catch (\Throwable $e) {

                return false;

            }
        }


      public function getProvider(Request $request)
    {
       $provider = Provider::get();

        return response()->json(['data' => $provider]);
    }

}
