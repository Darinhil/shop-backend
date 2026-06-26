<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .login-card {
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="login-card bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 w-full max-w-md border border-white/20">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-3xl font-bold text-white">S</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-slate-300">Sign in to your admin dashboard</p>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-slate-300 text-sm font-medium mb-2">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                        placeholder="admin@example.com">
                    <svg class="w-5 h-5 text-slate-400 absolute right-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.01a6 6 0 110 2.01V12"></path></svg>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-slate-300 text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                        placeholder="••••••••">
                    <svg class="w-5 h-5 text-slate-400 absolute right-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                Sign In
            </button>
        </form>
        <div class="mt-6 text-center">
            <p class="text-slate-400 text-sm">Default: admin@example.com / admin123</p>
        </div>
    </div>
</body>
</html>
