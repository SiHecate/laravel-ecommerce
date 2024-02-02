<?php

// app/Providers/ProductServiceProvider.php

namespace App\Providers;

use App\Http\Service\ProductService as ServiceProductService;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Repositories\ProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ServiceProductService::class, function ($app) {
            return new ServiceProductService($app->make(ProductRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Burada gerekirse başka işlemler yapabilirsiniz
    }
}
