<?php

// app/Providers/ProductServiceProvider.php

namespace App\Providers;

use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Repositories\ProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

    }

    public function boot()
    {
        // Burada gerekirse başka işlemler yapabilirsiniz
    }
}
