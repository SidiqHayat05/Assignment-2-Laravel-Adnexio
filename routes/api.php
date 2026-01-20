<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| Product Routes (E3 Step 4)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('permission:products-view');

    Route::get('/products/{id}', [ProductController::class, 'show'])
        ->middleware('permission:products-view');

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('permission:products-create');

    Route::put('/products/{id}', [ProductController::class, 'update'])
        ->middleware('permission:products-update');

    Route::delete('/products/{id}', [ProductController::class, 'destroy'])
        ->middleware('permission:products-delete');
});
