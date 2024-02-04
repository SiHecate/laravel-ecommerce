<?php

namespace App\Services;

use App\Models\Basket;
use App\Services\ProductService;
use App\Services\Repositories\Interfaces\BasketRepositoryInterface;

class BasketService
{
    private $productService;
    private $basketRepository;

    public function __construct(ProductService $productService, BasketRepositoryInterface $basketRepository)
    {
        $this->productService = $productService;
        $this->basketRepository = $basketRepository;
    }

    public function getBasket($userId)
    {
        $basket = $this->basketRepository->findUserBasket($userId);
        $products = json_decode($basket->pluck('products')->first(), true) ?? [];
        $totalPrice = $this->calculateTotalPrice($products);
        $productDetails = [];
        $productQuantity = [];
        foreach ($products as $product_id) {
            $product = $this->productService->findProduct($product_id);
            $productQuantity[$product_id] = isset($productQuantity[$product_id]) ? $productQuantity[$product_id] + 1 : 1;

            if ($product) {
                if (!isset($productDetails[$product->id])) {
                    $productDetails[$product->id] = [
                        'product_code' => $product->id,
                        'product_name' => $product->title,
                        'product_image' => $product->image,
                        'product_description' => $product->description,
                        'product_price' => $product->price,
                        'product_quantity' => $productQuantity[$product_id],
                        'product_total_price' => $product->price * $productQuantity[$product_id],
                    ];
                } else {
                    $productDetails[$product->id]['product_quantity'] = $productQuantity[$product_id];
                    $productDetails[$product->id]['product_total_price'] = $product->price * $productQuantity[$product_id];
                }
            }
        }
        return response()->json(['products_in_basket' => array_values($productDetails),'current_basket' => $basket, 'basket_total_price' => $totalPrice], 200);
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
            $product = $this->productService->findProduct($product_id);
            $totalPrice += $product['price'];
        }
        return $totalPrice;
    }
}
