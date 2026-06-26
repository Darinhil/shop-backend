@extends('admin.layout')

@section('title', 'Order Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Orders
        </a>
    </div>
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Order #{{ $order->id }}</h1>
        <p class="text-slate-500">View and manage order details</p>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Customer Information
            </h2>
            <div class="space-y-3">
                <p><span class="text-slate-500">Name:</span> <span class="font-medium text-slate-800">{{ $order->full_name }}</span></p>
                <p><span class="text-slate-500">Email:</span> <span class="font-medium text-slate-800">{{ $order->email }}</span></p>
                <p><span class="text-slate-500">Phone:</span> <span class="font-medium text-slate-800">{{ $order->phone }}</span></p>
                <p><span class="text-slate-500">Address:</span> <span class="font-medium text-slate-800">{{ $order->address }}</span></p>
                <p><span class="text-slate-500">City:</span> <span class="font-medium text-slate-800">{{ $order->city }}</span></p>
                <p><span class="text-slate-500">State:</span> <span class="font-medium text-slate-800">{{ $order->state }}</span></p>
                <p><span class="text-slate-500">Country:</span> <span class="font-medium text-slate-800">{{ $order->country }}</span></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Order Status
            </h2>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-semibold mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 mb-6">
        <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Order Items
        </h2>
        <table class="w-full">
            <thead>
                <tr class="text-left text-slate-500 text-sm border-b border-slate-100">
                    <th class="pb-4 font-medium">Product</th>
                    <th class="pb-4 font-medium">Quantity</th>
                    <th class="pb-4 font-medium">Price</th>
                    <th class="pb-4 font-medium">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b border-slate-50 last:border-0">
                        <td class="py-4 text-slate-800">{{ $item->product_name }}</td>
                        <td class="py-4 text-slate-600">{{ $item->quantity }}</td>
                        <td class="py-4 text-slate-800">${{ number_format($item->price, 2) }}</td>
                        <td class="py-4 font-semibold text-slate-800">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 pt-4 border-t border-slate-100 text-right">
            <p class="text-2xl font-bold text-slate-800">Total: ${{ number_format($order->total_amount, 2) }}</p>
        </div>
    </div>

    @if($order->notes)
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Order Notes
            </h2>
            <p class="text-slate-600">{{ $order->notes }}</p>
        </div>
    @endif
@endsection
