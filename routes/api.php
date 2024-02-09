<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;

Route::middleware(['auth:sanctum', LoggerMiddleware::class])->group(function () {

    Route::prefix('userInfos')->group(function() {
        Route::get('/userInfo', function (Request $request) {
            return $request->user();
        });
    });
});


Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/add', [ProductController::class, 'store']);
    Route::get('{id}', [ProductController::class, 'show']);
    Route::put('{id}', [ProductController::class, 'update']);
    Route::delete('{id}', [ProductController::class, 'destroy']);
});

Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index']);
    Route::post('/add', [BasketController::class, 'store']);
    Route::put('{id}/{type}', [BasketController::class, 'update']);
    Route::delete('{id}', [BasketController::class, 'destroy']);
    Route::get('/sepet', [BasketController::class, 'view']);
});

Route::prefix('info')->group(function () {
    Route::get('/', [UserInfoController::class, 'index']);
    Route::get('/show', [UserInfoController::class, 'show']);
    Route::post('/', [UserInfoController::class, 'store']);
    Route::put('/', [UserInfoController::class, 'update']);
    Route::delete('/', [UserInfoController::class, 'delete']);
});