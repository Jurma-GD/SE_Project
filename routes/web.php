<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Public landing page - redirects to login
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('welcome');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Student routes (authenticated)
Route::middleware(['auth'])->group(function () {
    // Browsing routes (require authentication)
    Route::get('/browse', [StudentController::class, 'index'])->name('home');
    Route::get('/vendors/{vendor}', [StudentController::class, 'showVendor'])->name('vendors.show');
    Route::get('/search', [StudentController::class, 'search'])->name('search');
    
    // Order routes
    Route::get('/my-orders', [StudentController::class, 'myOrders'])->name('orders.my');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// Vendor routes (authenticated)
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [VendorController::class, 'profile'])->name('profile');
    Route::put('/profile', [VendorController::class, 'updateProfile'])->name('profile.update');
    
    // Menu item resource routes
    Route::resource('menu-items', MenuItemController::class);
    
    // Custom route for availability toggle (AJAX)
    Route::post('/menu-items/{menuItem}/toggle', [MenuItemController::class, 'toggleAvailability'])
        ->name('menu-items.toggle');
    
    // Order management routes
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'vendorOrders'])->name('orders');
    Route::post('/orders/{order}/ready', [\App\Http\Controllers\OrderController::class, 'markReady'])->name('orders.ready');
    Route::post('/orders/{order}/complete', [\App\Http\Controllers\OrderController::class, 'markCompleted'])->name('orders.complete');
});
