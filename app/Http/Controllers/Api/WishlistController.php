<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->price,
                    'product_image' => $item->product->image,
                    'category_name' => $item->product->category->name ?? null,
                ];
            });

        return response()->json($wishlistItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlistItem = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id
        ]);

        $product = Product::findOrFail($request->product_id);

        return response()->json([
            'id' => $wishlistItem->id,
            'product_id' => $wishlistItem->product_id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'product_image' => $product->image,
        ]);
    }

    public function destroy(Request $request, $productId)
    {
        $wishlistItem = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->firstOrFail();

        $wishlistItem->delete();

        return response()->json(['message' => 'Item removed from wishlist']);
    }

    public function clear(Request $request)
    {
        Wishlist::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Wishlist cleared']);
    }
}
