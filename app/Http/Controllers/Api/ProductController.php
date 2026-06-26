<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Featured products
        if ($request->has('featured')) {
            $query->where('featured', true);
        }

        // Sort products
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate($request->per_page ?? 12);

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with('category', 'reviews')->findOrFail($id);

        // Add average rating
        $product->average_rating = $product->reviews->avg('rating') ?? 0;
        $product->reviews_count = $product->reviews->count();

        return response()->json($product);
    }
}
