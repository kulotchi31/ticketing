<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\RequestType;
use App\Models\Provider;
use App\Models\AuditLogs;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::orderBy('provider_name')->get();

        return view('admin.request', compact('providers'));
    }

    /**
     * Get all request types with provider relationship.
     */
    public function getRequestTypes()
    {
        $requestTypes = RequestType::with('provider')->get();

        return response()->json([
            'data' => $requestTypes
        ]);
    }

    /**
     * Validation rules.
     */
    public function validator(array $data)
    {
        return Validator::make($data, [

            'rt_name' => [
                'required',
                'string',
                'max:255',
            ],

            'rt_code' => [
                'required',
                'string',
                'max:255',
            ],

            'fk_provider_id' => [
                'required',
                'exists:provider_table,provider_id',
            ],

        ], [

            'rt_name.required' => 'Request Type Name is required.',
            'rt_name.string' => 'Request Type Name must be a valid string.',
            'rt_name.max' => 'Request Type Name must not exceed 255 characters.',

            'rt_code.required' => 'Request Type Code is required.',
            'rt_code.string' => 'Request Type Code must be a valid string.',
            'rt_code.max' => 'Request Type Code must not exceed 255 characters.',

            'fk_provider_id.required' => 'Please select a provider.',
            'fk_provider_id.exists' => 'Selected provider does not exist.',

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created request type.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
            ========================================
            CREATE REQUEST TYPE
            ========================================
            */

            $requestType = new RequestType();

            $requestType->rt_name = $request->rt_name;
            $requestType->rt_code = $request->rt_code;
            $requestType->fk_provider_id = $request->fk_provider_id;

            $requestType->save();

            $requestTypeId = $requestType->request_type_id;

            if (!$requestTypeId) {
                throw new \Exception('Unable to retrieve the Request Type ID.');
            }

            /*
            ========================================
            AUDIT LOG: CREATE REQUEST TYPE
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $requestTypeId,

                'action_type' => 'Create Request Type',

                'payload' => [

                    'rt_name' => $requestType->rt_name,

                    'rt_code' => $requestType->rt_code,

                    'fk_provider_id' => $requestType->fk_provider_id,

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Request Type creation failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Request Type creation failed.',
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
        $requestType = RequestType::with('provider')
            ->where('request_type_id', $id)
            ->first();

        if (!$requestType) {
            return response()->json(false);
        }

        return response()->json($requestType);
    }

    /**
     * Update the specified request type.
     */
    public function update(Request $request, string $id)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
            ========================================
            GET REQUEST TYPE
            ========================================
            */

            $requestType = RequestType::where(
                'request_type_id',
                $id
            )->first();

            if (!$requestType) {

                DB::rollBack();

                return response()->json([
                    'error' => 'Request Type not found.'
                ], 404);
            }

            /*
            ========================================
            CAPTURE OLD VALUES
            ========================================
            */

            $oldData = [

                'rt_name' => $requestType->rt_name,

                'rt_code' => $requestType->rt_code,

                'fk_provider_id' => $requestType->fk_provider_id,

            ];

            /*
            ========================================
            UPDATE REQUEST TYPE
            ========================================
            */

            $requestType->rt_name = $request->rt_name;

            $requestType->rt_code = $request->rt_code;

            $requestType->fk_provider_id = $request->fk_provider_id;

            $requestType->save();

            /*
            ========================================
            AUDIT LOG: UPDATE REQUEST TYPE
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $id,

                'action_type' => 'Update Request Type',

                'payload' => [

                    'old' => $oldData,

                    'new' => [

                        'rt_name' => $requestType->rt_name,

                        'rt_code' => $requestType->rt_code,

                        'fk_provider_id' => $requestType->fk_provider_id,

                    ]

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Request Type update failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Request Type update failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {

            /*
            ========================================
            GET REQUEST TYPE BEFORE DELETION
            ========================================
            */

            $requestType = RequestType::where(
                'request_type_id',
                $id
            )->first();

            if (!$requestType) {

                DB::rollBack();

                return response()->json([
                    'error' => 'Request Type not found.'
                ], 404);
            }

            /*
            ========================================
            CAPTURE DELETED DATA
            ========================================
            */

            $deletedRequestType = [

                'rt_name' => $requestType->rt_name,

                'rt_code' => $requestType->rt_code,

                'fk_provider_id' => $requestType->fk_provider_id,

            ];

            $requestTypeId = $requestType->request_type_id;

            /*
            ========================================
            DELETE REQUEST TYPE
            ========================================
            */

            $requestType->delete();

            /*
            ========================================
            AUDIT LOG: DELETE REQUEST TYPE
            ========================================
            */

            AuditLogs::create([

                'fk_user_id' => Auth::id(),

                'target_id' => $requestTypeId,

                'action_type' => 'Delete Request Type',

                'payload' => [

                    'deleted_request_type' => $deletedRequestType

                ],

                'transaction_date' => now(),

            ]);

            DB::commit();

            return response()->json(true);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Request Type deletion failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Request Type deletion failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
