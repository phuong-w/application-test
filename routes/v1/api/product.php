<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')
    ->controller(ProductController::class)
    ->name('product.')
    ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{product:slug}', 'show')->name('show');
    Route::post('/', 'store');
    Route::put('/{product}', 'update');
    Route::delete('/{product}', 'destroy');
});