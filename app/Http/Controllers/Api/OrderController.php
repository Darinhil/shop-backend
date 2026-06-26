<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:32',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:50',
            // totals can be computed server-side, but we accept them for now
            'subtotal' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'phone' => $request->phone,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'subtotal' => $request->subtotal ?? 0,
            'shipping_cost' => $request->shipping_cost ?? 0,
            'tax' => $request->tax ?? 0,
            'total_amount' => $request->total_amount ?? 0,
            'notes' => $request->notes,
        ]);

        // Create order items
        if (method_exists($order, 'items')) {
            foreach ($request->items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'product_name' => $product->name,
                    'price' => $product->price,
                ]);
            }
        }

        return response()->json(['message' => 'Order created', 'order_id' => $order->id], 201);
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['items.product'])
            ->orderByDesc('created_at')
            ->get();

        // Map to shape expected by OrderHistoryView.vue
        $mapped = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'created_at' => $order->created_at,
                'status' => $order->status,
                'subtotal' => $order->subtotal,
                'shipping_cost' => $order->shipping_cost,
                'tax' => $order->tax,
                'total_amount' => $order->total_amount,
                'full_name' => $order->full_name,
                'address' => $order->address,
                'city' => $order->city,
                'state' => $order->state,
                'postal_code' => $order->postal_code,
                'country' => $order->country,
                'phone' => $order->phone,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product?->name,
                        'product_image' => $item->product?->image,
                        'price' => $item->product?->price,
                        'quantity' => $item->quantity,
                    ];
                })->values(),
            ];
        });

        return response()->json($mapped);
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])->findOrFail($id);

        return response()->json([
            'id' => $order->id,
            'created_at' => $order->created_at,
            'status' => $order->status,
            'subtotal' => $order->subtotal,
            'shipping_cost' => $order->shipping_cost,
            'tax' => $order->tax,
            'total_amount' => $order->total_amount,
            'full_name' => $order->full_name,
            'address' => $order->address,
            'city' => $order->city,
            'state' => $order->state,
            'postal_code' => $order->postal_code,
            'country' => $order->country,
            'phone' => $order->phone,
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_name' => $item->product?->name,
                    'product_image' => $item->product?->image,
                    'price' => $item->product?->price,
                    'quantity' => $item->quantity,
                ];
            })->values(),
        ]);
    }
}

