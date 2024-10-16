<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;

// Frontend
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);

//danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{$category_id}', [CategoryProduct::class, 'index']);






































// Backend
// Hiển thị trang đăng nhập
Route::get('/login', [AdminController::class, 'login'])->name('login');

// Xử lý đăng nhập (POST)
Route::post('/admin', [AdminController::class, 'admin'])->name('admin.login');

// Trang dashboard sau khi đăng nhập thành công
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Đăng xuất
Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

//CategoryProduct
Route::get('add-category-product', [CategoryProductController::class, 'add_category_product'])->name('add.category.product');
Route::post('save-category-product', [CategoryProductController::class, 'save_category_product'])->name('save.category.product');
Route::get('all-category-product', [CategoryProductController::class, 'all_category_product'])->name('all.category.product');
Route::get('edit-category-product/{id}', [CategoryProductController::class, 'edit_category_product'])->name('edit.category.product');
Route::post('update-category-product/{id}', [CategoryProductController::class, 'update_category_product'])->name('update.category.product');
Route::get('delete-category-product/{id}', [CategoryProductController::class, 'delete_category_product'])->name('delete.category.product');
Route::get('active-category-product/{id}', [CategoryProductController::class, 'active_category_product'])->name('active.category.product');
Route::get('unactive-category-product/{id}', [CategoryProductController::class, 'unactive_category_product'])->name('unactive.category.product');
Route::get('show-category-home/{slug}', [CategoryProductController::class, 'show_category_home'])->name('show.category.home');
Route::get('export-csv', [CategoryProductController::class, 'export_csv'])->name('export.csv');
Route::post('import-csv', [CategoryProductController::class, 'import_csv'])->name('import.csv');
