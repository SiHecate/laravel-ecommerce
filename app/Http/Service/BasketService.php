<?php

namespace App\Http\Service;
use App\Models\Basket;
use App\Http\Service\ProductService;

class BasketService
{
    private $productService; // Add a property to hold an instance of ProductService

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getBasket($user_id)
    {
        $basket = Basket::where('user_id', $user_id)->first();
        return json_decode($basket->products, true) ?? [];
    }

    public function getProductQuantity($products)
    {
        $productQuantity = [];

        foreach ($products as $product_id) {
            $productQuantity[$product_id] = isset($productQuantity[$product_id]) ? $productQuantity[$product_id] + 1 : 1;
        }

        return $productQuantity;
    }

    public function calculateTotalPrice($products)
    {
        $totalPrice = 0;

        foreach ($products as $product_id) {
            $product = $this->productService->getProduct($product_id);
            $totalPrice += $product['price'];
        }

        return $totalPrice;
    }
}
