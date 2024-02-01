<?php

namespace App\Services\Repositories\Interface;

interface BasketRepositoryInterface
{
    public function getAll();

    public function findByUserId($userId);

    public function createBasket(array $data, $userId);

    public function updateProducts($userId, $productId);

    public function deleteProduct($userId, $productId);

    public function getBasketDetails($userId);

    public function calculateTotalPrice($userId);
}
