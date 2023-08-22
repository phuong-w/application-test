<?php

use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('store')
    ->controller(StoreController::class)
    ->name('store.')
    ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{store}', 'show')->name('show');
    Route::post('/', 'store');
    Route::put('/{store}', 'update');
    Route::delete('/{store}', 'destroy');
});