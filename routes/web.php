<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ContactController;

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

Route::get('/shop_detail/{slug}', [FrontendController::class, 'shop_detail'])->name('shop_detail');

Route::get('/change-color/{id}', [FrontendController::class, 'change_color'])->name('change_color');

Route::get('/change-image/{id}', [FrontendController::class, 'change_image'])->name('change_image');

Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');

Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/login', [FrontendController::class, 'login'])->name('login');

Route::get('/register', [FrontendController::class, 'register'])->name('register');

// Backend Routes

Route::get('/admin', [BackendController::class, 'index'])->name('admin');

Route::prefix('admin')->group(function () {
    Route::resource('home-slider', HomeSliderController::class);
    Route::post('home-slider/change_status', [HomeSliderController::class, 'change_status'])->name('home-slider.change_status');

    Route::resource('category', CategoryController::class);
    Route::post('category/change_status', [CategoryController::class, 'change_status'])->name('category.change_status');

    Route::resource('brand', BrandController::class);
    Route::post('brand/change_status', [BrandController::class, 'change_status'])->name('brand.change_status');

    Route::resource('product', ProductController::class);
    Route::post('product/change_status', [ProductController::class, 'change_status'])->name('product.change_status');

    // Route::resource('variant', VariantController::class);
    Route::get('variant/', [VariantController::class, 'index'])->name('variant.index'); // Done
    Route::get('variant/{id}', [VariantController::class, 'show'])->name('variant.show'); // Done
    Route::get('variant/create/{id}', [VariantController::class, 'create'])->name('variant.create'); //Done
    Route::post('variant/store', [VariantController::class, 'store'])->name('variant.store'); // Done
    Route::get('variant/{id}/edit', [VariantController::class, 'edit'])->name('variant.edit');
    Route::put('variant/update/{id}', [VariantController::class, 'update'])->name('variant.update');
    Route::delete('variant/delete/{id}', [VariantController::class, 'destroy'])->name('variant.destroy');
    Route::post('variant/change_status', [VariantController::class, 'change_status'])->name('variant.change_status');

    Route::resource('contact', ContactController::class)->only(['index', 'store']);
});
