<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|url|max:2048',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        Category::create($this->categoryData($request));
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|url|max:2048',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $oldImage = $category->image;
        $data = $this->categoryData($request);

        if (($data['image'] ?? null) !== $oldImage) {
            $this->deleteUploadedImage($oldImage);
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->deleteUploadedImage($category->image);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    private function categoryData(Request $request): array
    {
        $data = $request->only(['name', 'image']);
        $data['image'] = $data['image'] ?: null;

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
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

        if (str_starts_with($path, '/storage/categories/')) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }
    }
}
