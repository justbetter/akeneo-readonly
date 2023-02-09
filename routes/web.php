<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'products');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/product/image', [ProductController::class, 'image'])->name('product.image');
    Route::get('/product/{identifier}', [ProductController::class, 'show'])->name('product.detail');
});
