<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Provider;
use App\Models\AuditLogs;

class ProviderController extends Controller
{
    /**
     * Validation rules.
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.provider');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created provider.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {

            /*
            ========================================
            CREATE PROVIDER
            ========================================
            */

            DB::table('provider_table')->insert([

                'provider_name' => $request->provider_name,

                'provider_code' => $request->provider_code,

            ]);

            // Retrieve the actual inserted ID
            $providerId = DB::getPdo()->lastInsertId();

            if (!$providerId) {
                throw new \Exception('Unable to retrieve the new provider ID.');
            }

            /*
            ========================================
            AUDIT LOG: CREATE PROVIDER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $providerId,

                'action_type' => 'Create Provider',

                'payload' => [

                    'provider_name' => $request->provider_name,

                    'provider_code' => $request->provider_code,

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Provider creation failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Provider creation failed.',
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
        $data = DB::table('provider_table')
            ->where('provider_id', $id)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified provider.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [

            'provider_name' => [
                'required',
                'string',
                'max:255',
                'unique:provider_table,provider_name,' . $id . ',provider_id'
            ],

            'provider_code' => [
                'required',
                'string',
                'max:255',
                'unique:provider_table,provider_code,' . $id . ',provider_id'
            ],

        ], [

            'provider_name.unique' => 'Provider Name already exists.',
            'provider_code.unique' => 'Provider Code already exists.'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {

            /*
            ========================================
            GET PROVIDER
            ========================================
            */

            $provider = DB::table('provider_table')
                ->where('provider_id', $id)
                ->first();

            if (!$provider) {

                DB::rollBack();

                return response()->json(false);
            }

            /*
            ========================================
            CAPTURE OLD VALUES
            ========================================
            */

            $oldData = [

                'provider_name' => $provider->provider_name,

                'provider_code' => $provider->provider_code,

            ];

            /*
            ========================================
            UPDATE PROVIDER
            ========================================
            */

            DB::table('provider_table')
                ->where('provider_id', $id)
                ->update([

                    'provider_name' => $request->provider_name,

                    'provider_code' => $request->provider_code,

                ]);

            /*
            ========================================
            AUDIT LOG: UPDATE PROVIDER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $id,

                'action_type' => 'Update Provider',

                'payload' => [

                    'old' => $oldData,

                    'new' => [

                        'provider_name' => $request->provider_name,

                        'provider_code' => $request->provider_code,

                    ]

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Provider update failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Provider update failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified provider.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {

            /*
            ========================================
            GET PROVIDER BEFORE DELETION
            ========================================
            */

            $provider = DB::table('provider_table')
                ->where('provider_id', $id)
                ->first();

            if (!$provider) {

                DB::rollBack();

                return response()->json(false);
            }

            /*
            ========================================
            CAPTURE DELETED PROVIDER DETAILS
            ========================================
            */

            $deletedProvider = [

                'provider_name' => $provider->provider_name,

                'provider_code' => $provider->provider_code,

            ];

            $providerId = $provider->provider_id;

            /*
            ========================================
            DELETE PROVIDER
            ========================================
            */

            DB::table('provider_table')
                ->where('provider_id', $providerId)
                ->delete();

            /*
            ========================================
            AUDIT LOG: DELETE PROVIDER
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $providerId,

                'action_type' => 'Delete Provider',

                'payload' => [

                    'deleted_provider' => $deletedProvider

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Provider deletion failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Provider deletion failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all providers.
     */
    public function getProvider(Request $request)
    {
        $provider = Provider::get();

        return response()->json([
            'data' => $provider
        ]);
    }
}
