<?php

namespace App\Services\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();

    public function findProductById($id);

    public function createProduct(array $data);

    public function update(array $data, $id);

    public function deleteProduct($id);
}
