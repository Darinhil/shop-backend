<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:32',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            // totals can be computed server-side, but we accept them for now
            'subtotal' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($request, $validated) {
            $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))
                ->get()
                ->keyBy('id');

            $subtotal = collect($validated['items'])->sum(function ($item) use ($products) {
                return $products[$item['product_id']]->price * $item['quantity'];
            });
            $shippingCost = $validated['shipping_cost'] ?? 0;
            $tax = $validated['tax'] ?? 0;

            $order = Order::create([
                'user_id' => $request->user()->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'] ?? '',
                'postal_code' => $validated['postal_code'] ?? '',
                'country' => $validated['country'],
                'phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'] ?? null,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total_amount' => $subtotal + $shippingCost + $tax,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products[$item['product_id']];
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'product_name' => $product->name,
                    'price' => $product->price,
                ]);
            }

            Cart::where('user_id', $request->user()->id)->delete();

            return $order;
        });

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
                        'product_name' => $item->product_name ?? $item->product?->name,
                        'product_image' => $item->product?->image,
                        'price' => $item->price ?? $item->product?->price,
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
                    'product_name' => $item->product_name ?? $item->product?->name,
                    'product_image' => $item->product?->image,
                    'price' => $item->price ?? $item->product?->price,
                    'quantity' => $item->quantity,
                ];
            })->values(),
        ]);
    }
}

