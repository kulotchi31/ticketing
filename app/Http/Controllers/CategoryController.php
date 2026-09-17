<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;

use Auth;
use App\Models\Category;
use App\Models\RequestType;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


      public function validator(array $data)
    {
        return Validator::make($data, [

            'category_name' => [
                'required',
                'string',
                'max:255',
                'unique:category_table,category_name'
            ],

            'category_code' => [
                'required',
                'string',
                'max:255',
                'unique:category_table,category_code'
            ],

            'fk_request_type_id' => [
                'required',
                'exists:request_type_table,request_type_id'
            ],

        ], [

            'category_name.required' => 'Category Name is required.',
            'category_name.unique' => 'Category Name already exists.',

            'category_code.required' => 'Category Code is required.',
            'category_code.unique' => 'Category Code already exists.',

            'fk_request_type_id.required' => 'Request Type is required.',
            'fk_request_type_id.exists' => 'Selected Request Type is invalid.',

        ]);
    }

    public function index()
    {
    $requestTypes = RequestType::orderBy('rt_name')->get();

    return view('admin.category', compact('requestTypes'));
    }

    public function getCategories()
    {
        $categories = Category::with('requestType.provider')
        ->orderBy('category_name')
        ->get();

        return response()->json([
            'data' => $categories
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
                    "errors" => $validator->errors()
                ]);
            }

            $category = new Category;

            $category->category_name = $request->category_name;
            $category->category_code = $request->category_code;
            $category->fk_request_type_id = $request->fk_request_type_id;

            $category->save();

            if ($category) {

                // AuditLogs::create([
                //     'fk_user_id'       => Auth::id(),
                //     'target_id'        => $category->category_id,
                //     'action_type'      => 'Create Category',
                //     'payload'          => [
                //         'name' => $request->category_name,
                //         'code' => $request->category_code,
                //         'request_type_id' => $request->fk_request_type_id
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
        $category = Category::with('requestType')
            ->where('category_id', $id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.'
            ], 404);
        }

        return response()->json([
            'data' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('category_table')
            ->select('*')
            ->where('category_id', $id)
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

                'category_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('category_table', 'category_name')
                        ->ignore($id, 'category_id')
                ],

                'category_code' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('category_table', 'category_code')
                        ->ignore($id, 'category_id')
                ],

                'fk_request_type_id' => [
                    'required',
                    'exists:request_type_table,request_type_id'
                ],

            ], [

                'category_name.required' => 'Category Name is required.',
                'category_name.unique' => 'Category Name already exists.',

                'category_code.required' => 'Category Code is required.',
                'category_code.unique' => 'Category Code already exists.',

                'fk_request_type_id.required' => 'Request Type is required.',
                'fk_request_type_id.exists' => 'Selected Request Type is invalid.',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            // Capture OLD data
            $oldData = DB::table('category_table')
                ->where('category_id', $id)
                ->first();

            $update = DB::table('category_table')
                ->where('category_id', $id)
                ->update([

                    "category_name" => $request->category_name,
                    "category_code" => $request->category_code,
                    "fk_request_type_id" => $request->fk_request_type_id

                ]);

            if ($update) {

                // LOG THE UPDATE
                // AuditLogs::create([
                //     'fk_user_id'       => Auth::id(),
                //     'target_id'        => $id,
                //     'action_type'      => 'Update Category',
                //     'payload'          => [
                //         'old' => [
                //             'name' => $oldData->category_name,
                //             'code' => $oldData->category_code,
                //             'request_type_id' => $oldData->fk_request_type_id
                //         ],
                //         'new' => [
                //             'name' => $request->category_name,
                //             'code' => $request->category_code,
                //             'request_type_id' => $request->fk_request_type_id
                //         ]
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            // Get data before deletion
            $oldData = DB::table('category_table')
                ->where('category_id', $id)
                ->first();

            $delete = DB::table('category_table')
                ->where('category_id', $id)
                ->delete();

            if ($delete != 0) {

                // LOG THE DELETION
                // AuditLogs::create([
                //     'fk_user_id'       => Auth::id(),
                //     'target_id'        => $id,
                //     'action_type'      => 'Delete Category',
                //     'payload'          => [
                //         'deleted_category' => $oldData->category_name
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
}
