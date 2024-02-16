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
    $token = csrf_token();
    return response()->json([
        'csrf_token' => $token
    ]);
});


Route::get('/dashboard', function() {
    return "dashboard page";
});

// Routing içerisinde token döndürülmemesi için accept : application-json

/*
    Routing problemlerini çözdüm gibi eğer ki bu mesaj hala daha buradaysa çözememişimdir....

*/

// Ürün Rotaları
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::post('/search', [ProductController::class, 'search'])->name('product.search');
    Route::post('/add', [ProductController::class, 'store'])->name('product.store');
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});

// Sepet Rotaları
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/', [BasketController::class, 'store'])->name('basket.store');
    Route::put('/{id}/{type}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/{id}', [BasketController::class, 'destroy'])->name('basket.destroy');
    Route::get('/sepet', [BasketController::class, 'view'])->name('basket.view');
    Route::get("/paymentBasket", [BasketController::class, 'basket'])->name('basket.payment');
});

// Kullanıcı Bilgisi Rotaları
Route::prefix('address')->group(function () {
    Route::get('/', [UserInfoController::class, 'index'])->name('address.index');
    Route::post('/', [UserInfoController::class, 'store'])->name('address.store');
    Route::put('/', [UserInfoController::class, 'update'])->name('address.update');
    Route::get('/info', [UserInfoController::class, 'show'])->name('address.show');
    Route::delete('/{id}', [UserInfoController::class, 'delete'])->name('address.delete');
});
