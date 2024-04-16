<?php

namespace App\Http\Controllers\CategoryController;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CategoryController
{

    public function index(): JsonResponse
    {
        $categories = Category::all();

    return response()->json( [$categories], 200);
    }

    public function show($id): JsonResponse
    {
        $category = Category::findOrFail($id);

        return response()->json(['category' => $category]);
    }
    public function getCategoryByProduct(): JsonResponse
    {
        $categories = Category::withCount('products')->get();

        return response()->json(['categories' => $categories]);
    }

    public function showCategoryByProduct($id): JsonResponse
    {
        $category = Category::withCount('products')->findOrFail($id);

        return response()->json(['category' => $category]);
    }
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories',
            'slug' => 'required'
        ]);

        $category = Category::create($validatedData);
        return response()->json(['category' => $category], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $category->update($validatedData);

        return response()->json(['category' => $category]);
    }

    public function destroy($id): JsonResponse
    {
        // Retrieve the category by ID
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Return a success response
        return response()->json(null, 204);
    }
}
