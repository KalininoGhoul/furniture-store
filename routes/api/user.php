<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\Order\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/sign-up', [UserController::class, 'store']);
Route::post('/get-token', [AuthController::class, 'getToken']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product:slug}', [ProductController::class, 'show']);

Route::get('/collections', [CollectionController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart/products', [CartController::class, 'index']);
    Route::post('/cart/products', [CartController::class, 'addToCart']);
    Route::delete('/cart/products/{product:slug}', [CartController::class, 'removeFromCart']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
});
