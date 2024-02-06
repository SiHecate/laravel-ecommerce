<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressInfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    Route::prefix('address')->group(function() {
        Route::Get('/', [AddressInfoController::class, 'index']);
        Route::Post('/add', [AddressInfoController::class, 'store']);
        Route::Get('/adresler', [AddressInfoController::class, 'view']);
    });

    Route::get('/token', function () {
        return csrf_token();
    });

});
