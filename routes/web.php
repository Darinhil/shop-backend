<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Categories
        Route::resource('categories', AdminCategoryController::class);
        
        // Products
        Route::resource('products', AdminProductController::class);
        
        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        
        // Users
        Route::get('/users', [AdminController::class, 'users'])->name('users');
    });
});

// Original category routes (keep for backward compatibility)
Route::resource(
    'categories',
    CategoryController::class
);