<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/increase-qty', [CartController::class, 'increaseQuantity'])->name('cart.increaseQty');
Route::post('/cart/decrease-qty', [CartController::class, 'decreaseQuantity'])->name('cart.decreaseQty');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
