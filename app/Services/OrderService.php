<?php

namespace App\Services;
use App\Models\OrderPanel;
use App\Models\OrderDetail;

class OrderService
{

    // Construct

    private $productService; 

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function createOrder($userId, $totalPrice, $productId, $productQuantity)
    {
        $orderPanel = OrderPanel::create([
            'user_id' => $userId,
            'total_amount' => $totalPrice,
        ]);
        $product = $this->productService->findProductById($productId);
        $productDetail = [
            'order_id' => $orderPanel->id,
            'order_number' => mt_rand(100000, 999999), 
            'product_name' => $product['title'], 
            'product_image' => $product['image'], 
            'product_price' => $product['price'], 
            'product_quantity' => $productQuantity, 
        ];
        OrderDetail::create($productDetail);
        return true;
    }
    

}   