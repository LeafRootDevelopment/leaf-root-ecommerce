<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/contact', [ContactController::class, 'create'])
    ->name('contact.create');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register.show');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');
});

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

/*
|--------------------------------------------------------------------------
| Basket Routes
|--------------------------------------------------------------------------
*/

Route::get('/basket', [BasketController::class, 'index'])
    ->name('basket.index');

Route::post('/basket/add/{product}', [BasketController::class, 'add'])
    ->name('basket.add');

Route::patch('/basket/update/{basketItem}', [BasketController::class, 'update'])
    ->name('basket.update');

Route::delete('/basket/remove/{basketItem}', [BasketController::class, 'remove'])
    ->name('basket.remove');

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])
    ->name('checkout.confirmation');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by auth and admin middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

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

    Route::get(
        '/admin/orders',
        [OrderManagementController::class, 'index']
    )->name('admin.orders.index');

    Route::get(
        '/admin/orders/{order}',
        [OrderManagementController::class, 'show']
    )->name('admin.orders.show');

    Route::patch(
        '/admin/orders/{order}/status',
        [OrderManagementController::class, 'updateStatus']
    )->name('admin.orders.update-status');

    /*
    |--------------------------------------------------------------------------
    | Admin Contact Routes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/contacts',
        [AdminContactController::class, 'index']
    )->name('admin.contacts.index');

    Route::get(
        '/admin/contacts/{contact}',
        [AdminContactController::class, 'show']
    )->name('admin.contacts.show');

    Route::patch(
        '/admin/contacts/{contact}/status',
        [AdminContactController::class, 'updateStatus']
    )->name('admin.contacts.update-status');

    Route::delete(
        '/admin/contacts/{contact}',
        [AdminContactController::class, 'destroy']
    )->name('admin.contacts.destroy');
});