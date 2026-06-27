<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'image' => 'required_without:image_file|nullable|url|max:2048',
            'image_file' => 'required_without:image|nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($this->productData($request));
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'image' => 'required_without:image_file|nullable|url|max:2048',
            'image_file' => 'required_without:image|nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $oldImage = $product->image;
        $data = $this->productData($request);

        if (($data['image'] ?? null) !== $oldImage) {
            $this->deleteUploadedImage($oldImage);
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->deleteUploadedImage($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    private function productData(Request $request): array
    {
        $data = $request->only([
            'name',
            'price',
            'discount',
            'description',
            'stock',
            'image',
            'category_id',
        ]);

        $data['featured'] = $request->boolean('featured');
        $data['discount'] = $request->filled('discount') ? $request->input('discount') : 0;

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $data['image'] = $request->getSchemeAndHttpHost() . '/storage/' . ltrim($path, '/');
        }

        return $data;
    }

    private function deleteUploadedImage(?string $image): void
    {
        if (!$image) {
            return;
        }

        $path = parse_url($image, PHP_URL_PATH) ?: $image;

        if (str_starts_with($path, '/storage/products/')) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }
    }
}
