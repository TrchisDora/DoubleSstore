<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandProductController;

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

Route::get('/add-product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/save-product', [ProductController::class, 'save_product'])->name('save.product');
Route::get('/all-product', [ProductController::class, 'all_product'])->name('all.product');
Route::get('admin/products', [ProductController::class, 'all_product'])->name('admin.products.index');
Route::post('/admin/products/bulk-action', [ProductController::class, 'bulkAction'])->name('admin.products.bulk_action');
Route::get('edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit.product');
Route::post('update-product/{id}', [ProductController::class, 'update_product'])->name('update.product');
Route::get('delete-product/{id}', [ProductController::class, 'delete_product'])->name('delete.product');
Route::get('active-product/{id}', [ProductController::class, 'active_product'])->name('active.product');
Route::get('unactive-product/{id}', [ProductController::class, 'unactive_product'])->name('unactive.product');
Route::get('active-prominent-product/{id}', [ProductController::class, 'active_prominent_product'])->name('active.prominent.product');
Route::get('unactive-prominent-product/{id}', [ProductController::class, 'unactive_prominent_product'])->name('unactive.prominent.product');

//BrandProduct
Route::get('/add-brand-product', [BrandProductController::class, 'add_brand_product'])->name('add.brand.product');
Route::post('/save-brand-product', [BrandProductController::class, 'save_brand_product'])->name('save.brand.product');
Route::get('/all-brand-product', [BrandProductController::class, 'all_brand_product'])->name('all.brand.product');
Route::get('edit-brand-product/{id}', [BrandProductController::class, 'edit_brand_product'])->name('edit.brand.product');
Route::post('update-brand-product/{id}', [BrandProductController::class, 'update_brand_product'])->name('update.brand.product');
Route::get('delete-brand-product/{id}', [BrandProductController::class, 'delete_brand_product'])->name('delete.brand.product');
Route::get('active-brand-product/{id}', [BrandProductController::class, 'active_brand_product'])->name('active.brand.product');
Route::get('unactive-brand-product/{id}', [BrandProductController::class, 'unactive_brand_product'])->name('unactive.brand.product');
Route::get('show-brand-home/{slug}', [BrandProductController::class, 'show_brand_home'])->name('show.brand.home');