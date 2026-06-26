@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Products
        </a>
    </div>
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit Product</h1>
        <p class="text-slate-500">Update product information</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-6">
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Category</label>
                    <select name="category_id" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Image URL</label>
                    <input type="url" name="image" value="{{ $product->image }}"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Featured Product</label>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="featured" value="1" {{ $product->featured ? 'checked' : '' }}
                            class="w-5 h-5 border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span class="text-slate-600 text-sm">Mark as featured product</span>
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">{{ $product->description }}</textarea>
            </div>
            <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                Update Product
            </button>
        </form>
    </div>
@endsection
