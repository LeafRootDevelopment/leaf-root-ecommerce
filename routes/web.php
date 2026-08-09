<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/basket', [BasketController::class, 'index'])
    ->name('basket.index');

Route::post('/basket/add/{product}', [BasketController::class, 'add'])
    ->name('basket.add');

Route::patch('/basket/update/{basketItem}', [BasketController::class, 'update'])
    ->name('basket.update');

Route::delete('/basket/remove/{basketItem}', [BasketController::class, 'remove'])
    ->name('basket.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])
    ->name('checkout.confirmation');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource(
        'admin/products',
        ProductManagementController::class
    )->names('admin.products');

    Route::resource(
        'admin/categories',
        CategoryManagementController::class
    )->names('admin.categories');

});