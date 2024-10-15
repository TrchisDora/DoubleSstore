<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Frontend
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);


































// Backend
// Hiển thị trang đăng nhập
Route::get('/login', [AdminController::class, 'login'])->name('login');

// Xử lý đăng nhập (POST)
Route::post('/admin', [AdminController::class, 'admin'])->name('admin.login');

// Trang dashboard sau khi đăng nhập thành công
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/logout', [AdminController::class, 'logout']);
