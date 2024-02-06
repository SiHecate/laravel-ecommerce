<?php

namespace App\Services;

use App\Services\ProductService;
use App\Services\Repositories\Interfaces\BasketRepositoryInterface;

class BasketService
{
    private $productService;
    private $basketRepository;

    public function __construct(ProductService $productService, BasketRepositoryInterface $basketRepository)
    {
        $this->productService = $productService;
        $this->basketRepository = $basketRepository;
    }

    public function getBasket($userId)
    {
        $basket = $this->basketRepository->findUserBasket($userId);
        $products = json_decode($basket->pluck('products')->first(), true) ?? [];
        $totalPrice = $this->calculateTotalPrice($products);
        $productDetails = [];
        $productQuantity = [];
        foreach ($products as $product_id) {
            $product = $this->productService->findProduct($product_id);
            $productQuantity[$product_id] = isset($productQuantity[$product_id]) ? $productQuantity[$product_id] + 1 : 1;
            if ($product) {
                if (!isset($productDetails[$product->id])) {
                    $productDetails[$product->id] = [
                        'code' => $product->id,
                        'title' => $product->title,
                        'image' => $product->image,
                        'desc' => $product->description,
                        'price' => $product->price,
                        'quantity' => $productQuantity[$product_id],
                        'total_price' => $product->price * $productQuantity[$product_id],
                    ];
                } else {
                    $productDetails[$product->id]['quantity'] = $productQuantity[$product_id];
                    $productDetails[$product->id]['total_price'] = $product->price * $productQuantity[$product_id];
                }
            }
        }
        return response()->json(['product_datas' => array_values($productDetails),'basket' => $basket, 'basket_total_price' => $totalPrice], 200);
    }

    public function addProduct(array $data, $userId){
        $productId = $data['product_id'];
        $basket = $this->basketRepository->findUserBasket($userId);

        $product = $this->productService->findProduct($productId);

        if (!$product)
        {
            return response()->json(['message' => 'Product not found in database']);
        }

        if (!$basket)
        {
            $this->basketRepository->createBasket($data, $userId);
        } else {
            $basketProducts = json_decode($basket->products, true) ?? [];
            $basketProducts[] = $productId;
            $basket->update([
                'products' => json_encode($basketProducts),
            ]);
        }
        return response()->json(['message' => 'Product added to basket successfully', 'data' => $basket], 201);
    }



    public function updateProduct($productId ,$userId, $type)
    {
        $basket = $this->basketRepository->findUserBasket($userId);

        if($basket)
        {
            $products = json_decode($basket->products, true) ?? [];
            $product = array_search($productId, $products);
            if ($product !== false) {
                if ($type == '+')
                {
                    $products[] = $products[$product];
                }elseif ($type == '-') {
                    unset($products[$product]);
                } else {
                    return response()->json(['message' => 'Wrong type', 'type' => $type], 404);
                }
                $basket->update(['products' => json_encode(array_values($products))]);
                $basket = $this->basketRepository->findUserBasket($userId);
                return response()->json([
                    'message' => 'Product quantity updated in the basket',
                    'basket' => $basket,
                    'user_id' => $userId,
                    'updated_product_id' => $productId,
                    'type' => $type,
                ], 200);
            } else {
                return response()->json(['message' => "Product with ID $productId not found in the basket",'products' => $products], 404);
            }
        } else {
            return response()->json(['message' => 'No products found in the basket']);
        }
    }

    public function deletedProduct($productId, $userBasket)
    {
        $deletedProducts = json_decode($userBasket->deleted_products, true) ?? [];
        $existingIndex = array_search($productId, $deletedProducts);
        if ($existingIndex === false) {
            $deletedProducts[] = $productId;
            $userBasket->update(["deleted_products" => json_encode($deletedProducts)]);
        }
    }

    public function deleteProduct($productId, $userId)
    {
        $basket = $this->basketRepository->findUserBasket($userId);

        if ($basket) {
            $products = json_decode($basket->products, true);

            if (in_array($productId, $products)) {
                $updatedProducts = array_values(array_diff($products, [$productId]));
                $basket->update(['products' => json_encode($updatedProducts)]);
                $this->deletedProduct($productId, $basket);
                return response()->json([
                    'message' => "$productId removed from the basket successfully",
                    'basket' => $basket,
                    'user_id' => $userId,
                    'deleted_product_id' => $productId,
                ]);
            } else {
                return response()->json(['message' => 'Product not found in basket', 'product_id' => $productId], 404);
            }
        } else {
            return response()->json(['message' => 'Basket not found', 'user_id' => $userId], 404);
        }
    }

    public function deleteBasket($userId)
    {
        $this->basketRepository->deleteBasket($userId);
    }


    // Helpers
    public function getProductQuantity($products)
    {
        $productQuantity = [];
        foreach ($products as $product_id) {
            $productQuantity[$product_id] = isset($productQuantity[$product_id]) ? $productQuantity[$product_id] + 1 : 1;
        }
        return $productQuantity;
    }

    public function calculateTotalPrice($products)
    {
        $totalPrice = 0;

        foreach ($products as $product_id) {
            $product = $this->productService->findProduct($product_id);
            $totalPrice += $product['price'];
        }
        return $totalPrice;
    }
}
