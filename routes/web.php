<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

Route::get('token', function() {
    return csrf_token();
});

Route::get('/dashboard', function() {
    return "dashboard page";
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/search', [ProductController::class, 'search']);
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
