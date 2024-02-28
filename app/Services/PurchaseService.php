<?php

namespace App\Services;
use App\Services\BasketService;

/*
    Bu servicete olan methodların hepsi Payment service'i içerisinde kullanılacak.
*/
class PurchaseService
{
    private $basketService;
    private $userInfoService;
    private $productService;
    private $orderService;

    public function __construct
    (
        
        BasketService $basketService,
        UserInfoService $userInfoService,
        ProductService $productService,
        OrderService $orderService,
    )
    {
        $this->productService = $productService;
        $this->basketService = $basketService;
        $this->userInfoService = $userInfoService;
        $this->orderService = $orderService;
    }
    
    public function success($userId)
    {
        $basketData = json_decode($this->basketService->getBasket($userId)->getContent(), true);
        if ($basketData && isset($basketData['product_datas'])) {
            $products = $basketData['product_datas'];
            $totalPrice = $basketData['basket_total_price'];    
            $userInfo = $this->userInfoService->getUserInfos($userId);
            if ($userInfo) {
                $response = [
                    'user_info' => $userInfo,
                    'products' => $products,
                    'total_price' => $totalPrice,
                    'purchase_time' => now(),
                ];
            foreach($products as $product)
            {
                $quantity = $product['quantity'];
                $productId = $product['code'];
                $this->productService->stockReduction($productId, $quantity);
                $this->orderService->createOrder($userId, $totalPrice, $productId, $quantity);
            }
                $this->basketService->clearUserBasket($userId);
                return response()->json($response, 200);
            } else {
                return response()->json(['message' => 'User info cannot be found'], 404);
            }
        } else {
            return response()->json(['message' => 'Basket data cannot be found'], 404);
        }
    }     

    public function failure(){
        return null;
    }
}