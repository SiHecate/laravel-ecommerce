<?php

namespace App\Services\Repositories;

use App\Models\Basket;

class BasketRepository implements Interface\BasketRepositoryInterface
{
    public function getAll()
    {
        return Basket::all();
    }

    public function findByUserId($userId)
    {
        return Basket::where('user_id', $userId)->first();
    }

    public function createBasket(array $data, $userId)
    {
        return Basket::create([
            'user_id' => $userId,
            'products' => $data
        ]);
    }

    public function updateProducts($basketId, $data)
    {
    }

    public function deleteProduct($basketId, $productId)
    {
    }

    public function getBasketDetails($basketId)
    {
    }

    public function calculateTotalPrice($basketId)
    {
    }
}
