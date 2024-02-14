<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/', function () {
        return auth()->user();
    });
});

