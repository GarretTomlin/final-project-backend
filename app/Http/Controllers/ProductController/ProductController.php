<?php

namespace App\Http\Controllers\ProductController;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json($product);
    }


    public function store(Request $request, $storeId, $categoryId): \Illuminate\Http\JsonResponse
    {
        // Optional: You can still validate other fields if needed
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'images' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $productData = array_merge($request->all(), ['storeId' => $storeId, 'categoryId' => $categoryId]);
        $product = Product::create($productData);

        return response()->json(['product' => $product], 201);
    }
    public function getProductsByCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        $categoryName = $request->query('categoryName');

        $products = Product::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->get();

        return response()->json($products);
    }
    public function update(Request $request, Product $product): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'images' => 'string',
            'storeId' => 'exists:stores,id',
            'categoryId' => 'exists:categories,id',
        ]);

        $product->update($validatedData);

        return response()->json($product);
    }

    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
