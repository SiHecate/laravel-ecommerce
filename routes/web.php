<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserInfoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware([LoggerMiddleware::class])->group(function () {

    Route::prefix('info')->group(function() {
        Route::get('/', [UserInfoController::class, 'index']);
        Route::post('/', [UserInfoController::class, 'store']);
        Route::get('/show', [UserInfoController::class, 'show']);
        Route::put('/', [UserInfoController::class, 'update']);
        Route::delete('/', [UserInfoController::class, 'delete']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/add', [ProductController::class, 'store']);
        Route::get('{id}', [ProductController::class, 'show']);
        Route::put('{id}', [ProductController::class, 'update']);
        Route::delete('{id}', [ProductController::class, 'destroy']);
    });

    Route::prefix('basket')->group(function () {
        Route::get('/',[BasketController::class, 'index']);
        Route::post('/add', [BasketController::class, 'store']);
        Route::put('{id}/{type}', [BasketController::class, 'update']);
        Route::delete('{id}', [BasketController::class, 'destroy']);
        Route::get('/sepet', [BasketController::class, 'view']);
    });
});

Route::get('/token', function () {
    return csrf_token();
});

Route::get('{path}', function() {
    return response()->json(['error' => 'endpoint not found']);
})->where('path', '.*');
