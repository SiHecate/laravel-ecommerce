<?php

namespace App\Services\Repositories;

use App\Models\Basket;

class BasketRepository implements Interfaces\BasketRepositoryInterface
{
    public function getAll()
    {
        return Basket::orderBy('created_at', 'asc')->get();
    }

    public function findUserBasket($userId)
    {

        return Basket::where('user_id', $userId)->first();
    }

    
    public function createBasket(array $data, $userId)
    {
        // Kullanıcının mevcut sepetini bul
        $existingBasket = $this->findUserBasket($userId);
    
        // Eğer kullanıcının sepeti yoksa yeni bir sepet oluştur
        if ($existingBasket == null) {
            return Basket::create(array_merge($data, ['user_id' => $userId]));
        } else {
            // Eğer kullanıcının sepeti varsa, mevcut sepeti güncelle
            $existingBasket->update($data);
            return $existingBasket;
        }
    }

    public function updateProducts($basketId, $data)
    {
        $basket = Basket::find($basketId);

        if ($basket) {
            $basket->update($data);
            return $basket;
        } else {
            return null;
        }
    }

    // Basket'i tam olarak kaldırma fonksiyonu.
    public function deleteBasket($userId)
    {
        $basket = $this->findUserBasket($userId);
        $basket->delete();
    }

    // Basket içerisindeki product'ı kaldırma fonksiyonu
    public function deleteProduct($productId, $userId)
    {
        $basket = $this->findUserBasket($userId);
        $basket->update(['products' => json_encode(array_values($productId))]);
    }

    public function deletedProduct($deletedProductId, $userId)
    {
        $basket = $this->findUserBasket($userId);
        $basket->update(['deleted_products' => json_encode($deletedProductId)]);
    }

    public function getBasketDetails($basketId)
    {
        return Basket::orderBy('created_at', 'asc')->get();
    }
}
