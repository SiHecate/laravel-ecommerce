<?php

namespace App\Services\Repositories\Interfaces;

interface BasketRepositoryInterface
{
    public function getAll();

    public function findUserBasket($userId);

    public function createBasket(array $data, $userId);

    public function updateProducts($userId, $productId);

    public function deleteProduct($userId, $productId);

    public function deleteBasket($userId);

    public function getBasketDetails($userId);
}
