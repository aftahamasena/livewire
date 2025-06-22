<?php

use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Product;
use App\Livewire\Home;
use App\Livewire\UserOrders;
use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductTemplateExport;

// Home route for users only
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    Route::get('/product', Product::class)->name('product');
    Route::get('/orders', function () {
        return view('orders');
    })->name('user.orders');
    Route::get('/profile', function () {
        return view('profile');
    })->name('user.profile');
});

// Auth routes (accessible to all)
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');

// Logout route
Route::post('/logout', function () {
    // Clear all session data
    session()->flush();

    // Logout user
    Auth::logout();

    // Clear any cached data
    cache()->flush();

    return redirect('/login')->with('success', 'You have been successfully logged out.');
})->name('logout');

// Admin routes (only for admins)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/admin');
    })->name('admin.dashboard');
});

// Public routes
Route::get('/download-template', function () {
    return Excel::download(new ProductTemplateExport, 'template_products.xlsx');
})->name('download.template');
