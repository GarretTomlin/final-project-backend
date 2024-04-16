<?php

namespace App\Http\Controllers\StoreController;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController
{

    public function index(Request $request, $userId)
    {

        // Retrieve all stores associated with the user ID
        $stores = Store::where('userId', $userId)->get();

        // Return the stores as a JSON response
        return response()->json($stores);
    }

    public function show(Store $store)
    {
        return response()->json($store);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'userId' => 'required|numeric|exists:users,id',
        ]);

        // Check if the provided userId matches the ID of the currently authenticated user
//        if ($validatedData['userId'] !== Auth::id()) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }

        // Create the store
        $store = Store::create($validatedData);

        // Return JSON response with the created store data
        return response()->json([$store], 200);
    }

    public function update(Request $request, Store $store): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'userId' => 'numeric|exists:users,id',
        ]);

        $store->update($validatedData);

        return response()->json($store);
    }

    public function destroy(Store $store): \Illuminate\Http\JsonResponse
    {
        $store->delete();

        return response()->json(['message' => 'Store deleted successfully']);
    }
}
