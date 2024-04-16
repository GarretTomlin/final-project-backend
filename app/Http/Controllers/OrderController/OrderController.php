<?php

namespace App\Http\Controllers\OrderController;

use App\Models\Order;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class OrderController
{

    public function index(): JsonResponse
    {
        $orders = Order::all();
        return response()->json(['orders' => $orders]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'total_price' => 'required|numeric',
            'token' => 'required|string',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $order = Order::create($data);

        return response()->json(['message' => 'Order created', 'order' => $order], 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json(['order' => $order]);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate([
            'total_price' => 'numeric',
            'token' => 'string',
            'status' => 'string',
            'user_id' => 'exists:users,id',
        ]);

        $order->update($data);

        return response()->json(['message' => 'Order updated', 'order' => $order]);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
