<?php

namespace App\Providers;

use App\Services\BasketService;
use App\Services\ProductService;
use App\Services\Repositories\BasketRepository;
use App\Services\Repositories\Interfaces\BasketRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\ProductRepository;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Product Repo and Service
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

        // Basket Repo and Service
        $this->app->bind(BasketRepositoryInterface::class, BasketRepository::class);
        $this->app->bind(BasketService::class, function($app){
            return new BasketService($app->make(BasketRepositoryInterface::class));
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
