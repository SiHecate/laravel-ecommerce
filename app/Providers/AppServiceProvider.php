<?php

namespace App\Providers;

use App\Services\ProductService;
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
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
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
