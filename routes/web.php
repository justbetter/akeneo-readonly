<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('products');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/products', function () {
    return view('products');
})->name('products');
