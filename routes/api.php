<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);        // List all products
Route::get('/products/{id}', [ProductController::class, 'show']);    // Get single product
Route::post('/products', [ProductController::class, 'store']);       // Create new product
Route::put('/products/{id}', [ProductController::class, 'update']);  // Update product
Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Delete product
