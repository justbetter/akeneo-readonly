<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('products');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/products', function () {
        return view('products');
    })->name('products');

    Route::get('/product/{identifier}', function (Product $product) {
        return view('product', ['product' => $product]);
    })->name('product.detail');
});
