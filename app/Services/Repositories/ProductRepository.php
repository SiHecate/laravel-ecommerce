<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::orderBy('created_at', 'asc')->get();
    }

    public function findProductById($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return null;
        }
    
        return $product;
    }

    public function createProduct(array $data)
    {
        return Product::create($data); 
    }

    public function update(array $data, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
