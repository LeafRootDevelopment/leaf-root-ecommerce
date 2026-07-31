<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::resource('admin/products', ProductManagementController::class)
    ->names('admin.products');

Route::resource('admin/categories', CategoryManagementController::class)
    ->names('admin.categories');