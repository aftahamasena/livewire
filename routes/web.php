<?php

use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('livewire.home');
});
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('livewire.admin.dashboard');
    });
});

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
