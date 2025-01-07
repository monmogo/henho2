<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminUserController;


// Route sửa người dùng
Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
Route::get('/admin/users/{user}/create', [AdminUserController::class, 'edit'])->name('admin.users.create');



Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('/admin/users', AdminUserController::class)->except(['show']);
});

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Điều hướng sau khi đăng nhập
Route::get('/redirect', function () {
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect('/admin/dashboard');
    }
    return redirect('/');
})->middleware('auth')->name('redirect');

// Bảo vệ profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Hiển thị trang dashboard
    })->name('dashboard');
});

// Nạp routes xác thực
require __DIR__.'/auth.php';
