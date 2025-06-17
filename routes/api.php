<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/refresh', [AuthController::class, 'refresh']);

  Route::middleware('jwtAuth')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});

Route::middleware('jwtAuth')->group(function () {
  Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
  });

  Route::get('products/search', [ProductController::class, 'search']);
  Route::post('products/update-stock', [ProductController::class, 'updateStock']);
  Route::apiResource('products', ProductController::class);

  Route::get('inventory/value', [ProductController::class, 'inventoryValue']);
});
