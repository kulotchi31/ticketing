<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use App\Models\Category;
use App\Models\RequestType;
use App\Models\AuditLogs;

class CategoryController extends Controller
{
    /**
     * Validation rules
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

    /**
     * Display the category page.
     */
    public function index()
    {
        $requestTypes = RequestType::orderBy('rt_name')->get();

        return view('admin.category', compact('requestTypes'));
    }

    /**
     * Get all categories.
     */
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
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        try {

            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }

            DB::beginTransaction();

            $category = new Category;

            $category->category_name = $request->category_name;
            $category->category_code = $request->category_code;
            $category->fk_request_type_id = $request->fk_request_type_id;

            $category->save();

            // CREATE AUDIT LOG
            AuditLogs::create([
                'fk_user_id' => Auth::id(),
                'target_id' => $category->category_id,
                'action_type' => 'Create Category',
                'payload' => [
                    'category_name' => $category->category_name,
                    'category_code' => $category->category_code,
                    'fk_request_type_id' => $category->fk_request_type_id
                ],
                'transaction_date' => now(),
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Category creation failed: ' . $e->getMessage());

            return $e;
        }
    }

    /**
     * Display the specified category.
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
     * Show the form for editing the specified category.
     */
    public function edit(string $id)
    {
        $data = DB::table('category_table')
            ->select('*')
            ->where('category_id', $id)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Update the specified category.
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

            DB::beginTransaction();

            // GET OLD DATA BEFORE UPDATE
            $oldData = DB::table('category_table')
                ->where('category_id', $id)
                ->first();

            if (!$oldData) {
                DB::rollBack();
                return false;
            }

            // UPDATE CATEGORY
            $update = DB::table('category_table')
                ->where('category_id', $id)
                ->update([

                    'category_name' => $request->category_name,
                    'category_code' => $request->category_code,
                    'fk_request_type_id' => $request->fk_request_type_id

                ]);

            if ($update) {

                // CREATE AUDIT LOG
                AuditLogs::create([
                    'fk_user_id' => Auth::id(),
                    'target_id' => $id,
                    'action_type' => 'Update Category',
                    'payload' => [
                        'old' => [
                            'category_name' => $oldData->category_name,
                            'category_code' => $oldData->category_code,
                            'fk_request_type_id' => $oldData->fk_request_type_id
                        ],
                        'new' => [
                            'category_name' => $request->category_name,
                            'category_code' => $request->category_code,
                            'fk_request_type_id' => $request->fk_request_type_id
                        ]
                    ],
                    'transaction_date' => now(),
                ]);

                DB::commit();

                return true;
            }

            DB::rollBack();

            return false;

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Category update failed: ' . $e->getMessage());

            return $e;
        }
    }

    /**
     * Remove the specified category.
     */
    public function destroy(string $id)
    {
        try {

            DB::beginTransaction();

            // GET CATEGORY DATA BEFORE DELETION
            $oldData = DB::table('category_table')
                ->where('category_id', $id)
                ->first();

            if (!$oldData) {
                DB::rollBack();
                return false;
            }

            // DELETE CATEGORY
            $delete = DB::table('category_table')
                ->where('category_id', $id)
                ->delete();

            if ($delete != 0) {

                // CREATE AUDIT LOG
                AuditLogs::create([
                    'fk_user_id' => Auth::id(),
                    'target_id' => $id,
                    'action_type' => 'Delete Category',
                    'payload' => [
                        'deleted_category' => [
                            'category_name' => $oldData->category_name,
                            'category_code' => $oldData->category_code,
                            'fk_request_type_id' => $oldData->fk_request_type_id
                        ]
                    ],
                    'transaction_date' => now(),
                ]);

                DB::commit();

                return true;
            }

            DB::rollBack();

            return false;

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Category deletion failed: ' . $e->getMessage());

            return false;
        }
    }
}
