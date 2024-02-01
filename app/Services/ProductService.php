<?php

// File path: C:\php\e-commerce\e-commerce\app\Http\Service\ProductSerivce.php
namespace App\Http\Service;
use App\Models\Product;

class ProductService
{
    public function getProduct($product_id)
    {
        $product = Product::where('id', $product_id)->first(); // Corrected method call
        return json_decode($product, true) ?? [];
    }
}
