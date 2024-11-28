<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaddleController;

Route::post('/stripe/payment/{ref_code}', [StripeController::class, 'payment'])->name('stripe.payment');
Route::get('/stripe/checkout/{ref_code}', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');

Route::post('/cart/stripe/payment', [StripeController::class, 'cartPayment'])->name('cart.stripe.payment');
Route::get('/cart/stripe/success', [StripeController::class, 'cartSuccess'])->name('cart.stripe.success');

Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

Route::get('/paypal/checkout/{ref_code}', [PaypalController::class, 'checkout'])->name('paypal.checkout');
Route::get('/paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

Route::get('/paddle/checkout/{ref_code}', [PaddleController::class, 'checkout'])->name('paddle.checkout');
Route::get('/paddle/success', [PaddleController::class, 'success'])->name('paddle.success');
Route::get('/paddle/cancel', [PaddleController::class, 'cancel'])->name('paddle.cancel');
