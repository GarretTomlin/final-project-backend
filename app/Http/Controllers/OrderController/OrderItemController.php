<?php

namespace App\Http\Controllers\OrderController;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class OrderItemController
{

    public function index(Order $order): JsonResponse
    {
        $orderItems = $order->orderItems;
        return response()->json(['order_items' => $orderItems]);
    }

    public function store(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
        ]);

        $orderItem = $order->orderItems()->create($data);

        return response()->json(['message' => 'Order item created', 'order_item' => $orderItem], 201);
    }

    public function destroy(OrderItem $orderItem): JsonResponse
    {
        $orderItem->delete();
        return response()->json(['message' => 'Order item deleted']);
    }
}
