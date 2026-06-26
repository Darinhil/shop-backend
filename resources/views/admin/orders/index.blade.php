@extends('admin.layout')

@section('title', 'Orders')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Orders</h1>
        <p class="text-slate-500">Manage customer orders and shipments</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
        <div class="p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-slate-500 text-sm border-b border-slate-100">
                        <th class="pb-4 font-medium">Order ID</th>
                        <th class="pb-4 font-medium">Customer</th>
                        <th class="pb-4 font-medium">Total</th>
                        <th class="pb-4 font-medium">Status</th>
                        <th class="pb-4 font-medium">Date</th>
                        <th class="pb-4 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="table-row border-b border-slate-50 last:border-0">
                            <td class="py-4 font-medium text-slate-800">#{{ $order->id }}</td>
                            <td class="py-4 text-slate-600">{{ $order->user->name }}</td>
                            <td class="py-4 font-semibold text-slate-800">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status == 'pending') bg-amber-100 text-amber-700
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
