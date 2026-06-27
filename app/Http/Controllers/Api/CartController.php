<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'product_name' => $item->product->name,
                    'product_image' => $item->product->image,
                ];
            });

        return response()->json($cartItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Always increment quantity (safe for existing rows), and for new rows it will be created then incremented.
        // With this controller, duplicate requests will still increase quantity twice.
        // Frontend should prevent duplicates.
        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id
            ],
            [
                // quantity logic will be handled safely below
                'quantity' => $request->quantity
            ]
        );

        // If the row already existed, increment quantity exactly once.
        // We always increment only when it was NOT created.
        if (!$cartItem->wasRecentlyCreated) {
            $cartItem->increment('quantity', $request->quantity);
        }

        $cartItem->refresh();



        return response()->json([
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $product->price,
            'product_name' => $product->name,
            'product_image' => $product->image,
        ]);
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cartItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->firstOrFail();

        if ($request->quantity == 0) {
            $cartItem->delete();
            return response()->json(['message' => 'Item removed']);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->product->price
        ]);
    }

    public function destroy(Request $request, $productId)
    {
        $cartItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->firstOrFail();

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Cart cleared']);
    }
}
