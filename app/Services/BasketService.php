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
                        'code' => $product->id,
                        'title' => $product->title,
                        'image' => $product->image,
                        'desc' => $product->description,
                        'price' => $product->price,
                        'quantity' => $productQuantity[$product_id],
                        'total_price' => $product->price * $productQuantity[$product_id],
                    ];
                } else {
                    $productDetails[$product->id]['quantity'] = $productQuantity[$product_id];
                    $productDetails[$product->id]['total_price'] = $product->price * $productQuantity[$product_id];
                }
            }
        }
        return response()->json(['product_datas' => array_values($productDetails),'basket' => $basket, 'basket_total_price' => $totalPrice], 200);
    }

    public function createBasket(array $data, $userId){
        $productId = $data['product_id'];
        $basket = $this->basketRepository->findUserBasket($userId);
        if (!$basket)
        {
            $this->basketRepository->createBasket($data, $userId);
        } else {
            $basketProducts = json_decode($basket->products, true) ?? [];
            $basketProducts[] = $productId;
            $basket->update([
                'products' => json_encode($basketProducts),
            ]);
        }
        return response()->json(['message' => 'Product added to basket successfully', 'data' => $basket], 201);
    }

    public function deleteProduct(array $data, $productId)
    {}

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
