<?php

namespace App\Services;

use App\Services\Repositories\Interfaces\BasketRepositoryInterface;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Repositories\UserInfoRepository;
use App\Services\BasketService;

/*
    Bu servicete olan methodların hepsi Payment service'i içerisinde kullanılacak.
*/
class PurchaseService
{
    private $productRepository;
    private $basketService;
    private $userInfoRepository;

    public function __construct
    (
        ProductRepositoryInterface $productRepository,
        BasketService $basketService,
        UserInfoRepository $userInfoRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->basketService = $basketService;
        $this->userInfoRepository = $userInfoRepository;
    }

    public function purchase($productId, $purchaseQuantity)
    {
        $product = $this->productRepository->findProductById($productId);
    
        if (!$product) {
            throw new \Exception("Product not found.");
        }
    
        if ($product->quantity < $purchaseQuantity) {
            throw new \Exception("Not enough products in stock..");
        }
    
        $newQuantity = $product->quantity - $purchaseQuantity;
    
        $this->productRepository->update(['quantity' => $newQuantity], $productId);
    }

    public function success($userId)
    {
        /*
            Ürünlerin listesi olacak
                - Kaç tane alındığı
                - Toplam ücreti
                - Saat kaçta alındığı
                - Hangi adrese alındığı
                    'address_name' => $info->address_name,
                    'name' => $info->name,
                    'surname' => $info->surname,
                    'email' => $info->email,
                    'telephone' => $info->telephone,
                    'city' => $info->city,
                    'district' => $info->district,
                    'neighborhood' => $info->neighborhood,
                    'address' => $info->address
                
                Buradaki bilgilere giriş yapan kullanıcının id'sinden çektirerek erişilebilir.

            Kullanıcının basket'i boşaltılacak
        */

        $basketData = $this->basketService->getBasket($userId);
    
        if ($basketData && isset($basketData['product_datas'])) {
            $products = $basketData['product_datas'];
            $totalPrice = $basketData['basket_total_price'];
    
            $userInfo = $this->userInfoRepository->getUserInfos($userId);
    
            if ($userInfo) {
                $userInfoArray = [
                    'name' => $userInfo->name,
                    'surname' => $userInfo->surname,
                    'telephone' => $userInfo->telephone,
                    'city' => $userInfo->city,
                    'district' => $userInfo->district,
                    'neighborhood' => $userInfo->neighborhood,
                    'full_address' => $userInfo->address,
                ];
    
                $response = [
                    'user_info' => $userInfoArray,
                    'products' => $products,
                    'total_price' => $totalPrice,
                    'purchase_time' => now(),
                ];
    
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


