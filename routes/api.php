<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// // Eğer kullanıcı giriş yaptıysa bu route'a erişebiliyor olması gerekiyor
// // kullanıcı giriş yapmadıysa bu 401 döndürmesi gerekiyor.

Route::middleware(['auth'])->group(function () {
    Route::get('deneme', function() {
        return ("hello this is testing for auth system is working.");
    });
});


