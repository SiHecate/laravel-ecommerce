<?php

namespace App\Providers;

use App\Models\Product;
use App\Services\BasketService;
use App\Services\PaymentService;
use App\Services\ProductService;
use App\Services\UserInfoService;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\BasketRepository;
use App\Services\Repositories\ProductRepository;
use App\Services\Repositories\UserInfoRepository;
use App\Services\Repositories\Interfaces\BasketRepositoryInterface;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Repositories\Interfaces\UserInfoRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Product Repo and Service
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, ProductService::class);

        // Basket Repo and Service
        $this->app->bind(BasketRepositoryInterface::class, BasketRepository::class);
        $this->app->bind(BasketService::class, BasketService::class);

        $this->app->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
        $this->app->bind(UserInfoService::class, UserInfoService::class);

        $this->app->bind(PaymentService::class, PaymentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }
}
