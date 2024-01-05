<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Eğer kullanıcı giriş yaptıysa bu route'a erişebiliyor olması gerekiyor
// kullanıcı giriş yapmadıysa bu 401 döndürmesi gerekiyor.

Route::middleware(['auth'])->group(function () {
    Route::get('deneme', function() {
        return ("hello this is testing for auth system is working.");
    });
});
