<?php

use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserInfoController;

require __DIR__.'/auth.php';


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

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
    return 'Horray';
})->middleware(AdminCheck::class);


// Routing içerisinde token döndürülmemesi için accept : application-json

/*
    Admin tarafında kullanılacak olan methodlar
    - Ürün işlemleri
        - crud
    - Kullanıcı bilgileri
        - show
        - index
    - Ödeme işlemleri
        - kontroller
    
    Kullanıcı tarafında kullanılacak olan methodlar (kayıtlı kayıtsız fark etmeksizin)
    - Ürün işlemleri
        - index
        - show
        - search

    - Sepet işlemleri (kayıtlı kullanıcı)
        - ürün ekleme çıkarma düzenleme silme (CRUD)

    - Adres bilgileri (kayıtlı kullanıcı)
        - adres ekleme çıkarma düzenleme silme (CRUD)
        - 

    Yardım alınacak middleware'lar
        - Auth
        - Admin (admin user yaratılacak) 
        - User ? 
*/ 

// Ürün Rotaları
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::post('/search', [ProductController::class, 'search'])->name('product.search');
    Route::post('/add', [ProductController::class, 'store'])->middleware('auth')->name('product.store');
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::put('/{id}', [ProductController::class, 'update'])->middleware('auth')->name('product.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware('auth')->name('product.destroy');
});

// Sepet Rotaları
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/', [BasketController::class, 'store'])->middleware('auth')->name('basket.store');
    Route::put('/{id}/{type}', [BasketController::class, 'update'])->middleware('auth')->name('basket.update');
    Route::delete('/{id}', [BasketController::class, 'destroy'])->middleware('auth')->name('basket.destroy');
    Route::get('/sepet', [BasketController::class, 'view'])->middleware('auth')->name('basket.view');
    Route::get("/paymentBasket", [BasketController::class, 'basket'])->middleware('auth')->name('basket.payment');
});

// Kullanıcı Bilgisi Rotaları
Route::prefix('address')->middleware('auth')->group(function () {
    Route::get('/', [UserInfoController::class, 'index'])->name('address.index');
    Route::post('/', [UserInfoController::class, 'store'])->name('address.store');
    Route::put('/', [UserInfoController::class, 'update'])->name('address.update');
    Route::get('/info', [UserInfoController::class, 'show'])->name('address.show');
    Route::delete('/{id}', [UserInfoController::class, 'delete'])->name('address.delete');
});