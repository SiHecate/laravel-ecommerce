<?php

namespace App\Service;
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

        if ($products)
        {
            $allProduct = [
                'product_id' => $products->id,
                'product_name' => $products->name,
                'product_desc' => $products->description,
                'product_image' => $products->image,
                'product_price' => $products->price,
                'product_stock' => $products->stock,
                'product_creating_time' => $products->created_at,
            ];
            return response()->json(['products' => $allProduct], 200);
        } else {
            return response()->json(['there is no product in product database'], 404);
        }
    }

    public function findProduct($productId)
    {
        $product = $this->productRepository->findProductById($productId);
        if($product)
        {
            return response()->json(['product' => $product], 200);
        } else {
            return response()->json(['message' => "There is no product in the database with ID: $productId"], 404);
        }
    }

}
