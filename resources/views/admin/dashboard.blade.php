@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Dashboard</h1>
        <p class="text-slate-500">Welcome back, {{ auth()->user()->name }}! Here's what's happening today.</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-green-500 text-sm font-medium bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-slate-500 text-sm mb-1">Total Users</p>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['total_users'] }}</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-green-500 text-sm font-medium bg-green-50 px-2 py-1 rounded-full">+8%</span>
            </div>
            <p class="text-slate-500 text-sm mb-1">Total Orders</p>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-green-500 text-sm font-medium bg-green-50 px-2 py-1 rounded-full">+5%</span>
            </div>
            <p class="text-slate-500 text-sm mb-1">Total Products</p>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['total_products'] }}</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-green-500 text-sm font-medium bg-green-50 px-2 py-1 rounded-full">+15%</span>
            </div>
            <p class="text-slate-500 text-sm mb-1">Total Revenue</p>
            <p class="text-3xl font-bold text-slate-800">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    <!-- Pending Orders Alert -->
    @if($stats['pending_orders'] > 0)
        <div class="bg-gradient-to-r from-amber-400 to-orange-400 text-white px-6 py-4 rounded-xl shadow-lg mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="font-semibold">{{ $stats['pending_orders'] }} pending orders need attention</span>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-all duration-300 font-medium">View Orders</a>
        </div>
    @endif

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-800">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">View All</a>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-slate-500 text-sm border-b border-slate-100">
                            <th class="pb-4 font-medium">Order ID</th>
                            <th class="pb-4 font-medium">Customer</th>
                            <th class="pb-4 font-medium">Total</th>
                            <th class="pb-4 font-medium">Status</th>
                            <th class="pb-4 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-slate-500">No orders yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
