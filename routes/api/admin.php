<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('access:edit-products')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/products/{product:slug}', [ProductController::class, 'update']);
});

Route::middleware('access:edit-collections')->group(function () {
    Route::post('/collections', [CollectionController::class, 'store']);
    Route::post('/collections/{collection:slug}', [CollectionController::class, 'update']);
});
