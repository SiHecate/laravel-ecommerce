<?php

namespace App\Services;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    /*
        Product objects:
            $table->id();
            $table->string('title', 40);
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('stock');
            $table->boolean('visibility');
            $table->string('tag', 40);
            $table->timestamps();

    */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function getProduct()
    {
        $products = $this->productRepository->getAll();

        if ($products->isNotEmpty()) {
            $allProducts = $products->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_desc' => $product->description,
                    'product_image' => $product->image,
                    'product_price' => $product->price,
                    'product_stock' => $product->stock,
                    'product_creating_time' => $product->created_at,
                ];
            });

            return $allProducts->toJson();
        }
        return [];
    }

    public function findProduct($productId)
    {
        $product = $this->productRepository->findProductById($productId);

        if ($product) {
            return $product;
        } else {
            return null;
        }
    }

}
