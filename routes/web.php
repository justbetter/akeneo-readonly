<?php

use App\Http\Controllers\ProductController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::redirect('/', 'products');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/product/image', [ProductController::class, 'image'])->name('product.image');
    Route::get('/product/{identifier}', [ProductController::class, 'show'])->name('product.detail');
});

Route::middleware([Authenticate::class])->group(function() {
    Route::get('health', HealthCheckResultsController::class)->name('health');
});
