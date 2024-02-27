<?php

namespace App\Services;

use App\Services\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Repositories\UserInfoRepository;
use App\Services\BasketService;

/*
    Bu servicete olan methodların hepsi Payment service'i içerisinde kullanılacak.
*/
class PurchaseService
{
    private $basketService;
    private $userInfoRepository;
    private $userInfoService;
    private $productService;

    public function __construct
    (
        ProductRepositoryInterface $productRepository,
        BasketService $basketService,
        UserInfoRepository $userInfoRepository,
        UserInfoService $userInfoService,
        ProductService $productService,
    )
    {
        $this->productService = $productService;
        $this->userInfoRepository = $userInfoRepository;
        $this->basketService = $basketService;
        $this->userInfoService = $userInfoService;
    }



    /*
        Bilgiler yollandı CHECK
        Sepet boşaltılacak CHECK
        Stotkan ürün düşülecek  CHECK
        Siparişler sayfası eklenecek 
        Transaction verisi alınacak
    */
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
                $this->productService->stockUpdate($productId, $quantity);
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