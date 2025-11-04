<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::resource('vendors', VendorController::class);

Route::get('/product', [ProductController::class, 'index']);
Route::post('/product-store', [ProductController::class, 'store']);

Route::get('/halo', function () {
    return 'Halo, Laravel!';
});
