<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, transparent 100%);
            border-left-color: #6366f1;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .table-row:hover {
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="bg-slate-50">
    @auth
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 text-white shadow-2xl fixed h-full">
                <div class="p-8 border-b border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-xl font-bold">S</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">ShopHub</h1>
                            <p class="text-slate-400 text-sm">Admin Panel</p>
                        </div>
                    </div>
                </div>
                <nav class="mt-6 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white {{ request()->is('admin/dashboard') ? 'active text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white {{ request()->is('admin/categories*') ? 'active text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Categories
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white {{ request()->is('admin/products*') ? 'active text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white {{ request()->is('admin/orders*') ? 'active text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Orders
                    </a>
                    <a href="{{ route('admin.users') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white {{ request()->is('admin/users') ? 'active text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Users
                    </a>
                </nav>
                <div class="absolute bottom-0 w-72 p-4 border-t border-slate-700">
                    <div class="flex items-center gap-3 mb-4 px-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold">{{ auth()->user()->name[0] }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-3 px-4 rounded-lg transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 ml-72">
                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-lg mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-gradient-to-r from-red-400 to-pink-500 text-white px-6 py-4 rounded-xl shadow-lg mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
