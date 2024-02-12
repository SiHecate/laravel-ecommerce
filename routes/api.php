<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;

Route::prefix('user')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', function () {
            return auth()->user();
        });

        Route::get('/id', function () {
            return auth()->id();
        });
    });
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index']);
    Route::post('/', [BasketController::class, 'store']);
    Route::put('/{id}/{type}', [BasketController::class, 'update']);
    Route::delete('/{id}', [BasketController::class, 'destroy']);
    Route::get('/sepet', [BasketController::class, 'view']);
    Route::get("/paymentBasket", [BasketController::class, 'basket']);
});

Route::prefix('address')->group(function () {
    Route::get('/', [UserInfoController::class, 'index']);
    Route::post('/', [UserInfoController::class, 'store']);
    Route::put('/', [UserInfoController::class, 'update']);
    Route::get('/info', [UserInfoController::class, 'show']);
    Route::delete('/{id}', [UserInfoController::class, 'delete']);
});
