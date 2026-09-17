<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RequestType;
use App\Models\Provider;
use Validator;
use Rules;
use Auth;
use DB;

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

    public function getRequestTypes()
    {
        $requestTypes = RequestType::with('provider')->get();

        return response()->json([
            'data' => $requestTypes
        ]);
    }


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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $requestType = new RequestType();

            $requestType->rt_name = $request->rt_name;
            $requestType->rt_code = $request->rt_code;
            $requestType->fk_provider_id = $request->fk_provider_id;

            $saved = $requestType->save();

            if ($saved) {
                return response()->json(true);
            }

            return response()->json(false);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
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

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $requestType = RequestType::where(
                'request_type_id',
                $id
            )->first();

            if (!$requestType) {
                return response()->json([
                    'error' => 'Request Type not found.'
                ], 404);
            }

            $requestType->rt_name = $request->rt_name;
            $requestType->rt_code = $request->rt_code;
            $requestType->fk_provider_id = $request->fk_provider_id;

            $updated = $requestType->save();

            if ($updated) {
                return response()->json(true);
            }

            return response()->json(false);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        try {
            $requestType = RequestType::where(
                'request_type_id',
                $id
            )->first();

            if (!$requestType) {
                return response()->json([
                    'error' => 'Request Type not found.'
                ], 404);
            }

            $deleted = $requestType->delete();

            if ($deleted) {
                return response()->json(true);
            }

            return response()->json(false);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
