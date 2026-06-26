@extends('admin.layout')

@section('title', 'Products')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Products</h1>
            <p class="text-slate-500">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Product
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
        <div class="p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-slate-500 text-sm border-b border-slate-100">
                        <th class="pb-4 font-medium">ID</th>
                        <th class="pb-4 font-medium">Image</th>
                        <th class="pb-4 font-medium">Name</th>
                        <th class="pb-4 font-medium">Category</th>
                        <th class="pb-4 font-medium">Price</th>
                        <th class="pb-4 font-medium">Stock</th>
                        <th class="pb-4 font-medium">Featured</th>
                        <th class="pb-4 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="table-row border-b border-slate-50 last:border-0">
                            <td class="py-4 font-medium text-slate-800">{{ $product->id }}</td>
                            <td class="py-4">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl shadow-sm">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-slate-200 to-slate-300 rounded-xl flex items-center justify-center text-slate-400 text-xs">No img</div>
                                @endif
                            </td>
                            <td class="py-4 font-semibold text-slate-800">{{ $product->name }}</td>
                            <td class="py-4 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                            <td class="py-4 font-semibold text-slate-800">${{ number_format($product->price, 2) }}</td>
                            <td class="py-4">
                                <span class="{{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }} px-3 py-1 rounded-full text-sm font-medium">{{ $product->stock }}</span>
                            </td>
                            <td class="py-4">
                                @if($product->featured)
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">✓ Featured</span>
                                @else
                                    <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-sm font-medium">Normal</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 font-medium text-sm flex items-center gap-1" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>
@endsection
