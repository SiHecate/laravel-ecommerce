<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;
use App\Http\Middleware\AdminCheck;

require __DIR__.'/auth.php';


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Routing içerisinde token döndürülmemesi için accept : application-json


// Product routes
Route::prefix('product')->group(function () {

    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::post('/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');

    // Admin routes
    Route::middleware(['auth', AdminCheck::class])->group(function () {
        Route::post('/add', [ProductController::class, 'store'])->name('product.store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
});

// Basket routes
Route::prefix('basket')->middleware('auth')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/', [BasketController::class, 'store'])->name('basket.store');
    Route::put('/{id}/{type}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/{id}', [BasketController::class, 'destroy'])->name('basket.destroy');
    Route::get('/sepet', [BasketController::class, 'view'])->name('basket.view');
    Route::get("/paymentBasket", [BasketController::class, 'basket'])->name('basket.payment');
});

// Address routes
Route::prefix('address')->middleware('auth')->group(function () {
    Route::get('/', [UserInfoController::class, 'index'])->name('address.index');
    Route::post('/', [UserInfoController::class, 'store'])->name('address.store');
    Route::put('/', [UserInfoController::class, 'update'])->name('address.update');
    Route::get('/info', [UserInfoController::class, 'show'])->name('address.show');
    Route::delete('/{id}', [UserInfoController::class, 'delete'])->name('address.delete');
});

Route::prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    // Route::get('/success', [ProductController::class, 'success'])->name('checkout.success');
    // Route::get('/cancel', [ProductController::class, 'cancel'])->name('checkout.cancel');
    // Route::post('/webhook', [ProductController::class, 'webhook'])->name('checkout.webhook');
});

// Diğer rotalar
Route::get('token', function() {
    $token = csrf_token();
    return response()->json([
        'csrf_token' => $token
    ]);
});

Route::get('/dashboard', function() {
    return "dashboard page";
});

Route::get('/user/profile', function () {
    $user = Auth::user();
    return $user;
})->middleware('auth');

Route::get('user/adminCheck', function() {
    return 'Admin user';
})->middleware(AdminCheck::class);