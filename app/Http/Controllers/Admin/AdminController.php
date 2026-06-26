<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }
}
