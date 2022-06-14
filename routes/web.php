<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// FrontEnd Routes

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');

Route::get('/shop_detail/{id?}', [FrontendController::class, 'shop_detail'])->name('shop_detail');

Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');

Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/login', [FrontendController::class, 'login'])->name('login');

Route::get('/register', [FrontendController::class, 'register'])->name('register');

// Backend Routes

Route::get('/admin', [BackendController::class, 'index'])->name('admin');

Route::prefix('admin')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::post('category/change_status', [CategoryController::class, 'change_status'])->name('category.change_status');
});
