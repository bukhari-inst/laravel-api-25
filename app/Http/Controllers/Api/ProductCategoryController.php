<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productCategories = ProductCategory::with('products')->get();
            return response()->json($productCategories);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $productCategory = ProductCategory::create($validatedData);

            $productCategory->products()->create($request->all());

            DB::commit();
            return response()->json($productCategory, 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);

            if (!$productCategory) {
                return response()->json(['message' => 'Product category not found'], 404);
            }
            return response()->json($productCategory);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
