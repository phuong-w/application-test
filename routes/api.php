<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace(env('BASE_API'))->name('api.')->middleware(['api'])->group(function () {

    //Unauthenticated Routes
    Route::group(['middleware' => ['api_key']], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', [LoginController::class, 'login'])->name('login');
        });

        Route::group(['prefix' => 'v1'], function () {
            //
        });
    });

    //Authenticated Routes
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::post('auth/logout', [LoginController::class, 'logout'])->name('logout');

        Route::group(['prefix' => 'v1', 'middleware' => ['api_key']], function () {
            include('v1/api/product.php');
            include('v1/api/store.php');
        });
    });
});