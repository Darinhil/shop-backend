@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Categories
        </a>
    </div>
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit Category</h1>
        <p class="text-slate-500">Update category information</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @if($category->image)
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Current Image</label>
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded-xl shadow-sm">
                </div>
            @endif
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Image URL</label>
                <input type="url" name="image" value="{{ old('image', $category->image) }}"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                @error('image')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Upload New Image</label>
                <input type="file" name="image_file" accept="image/*"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                @error('image_file')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                Update Category
            </button>
        </form>
    </div>
@endsection
