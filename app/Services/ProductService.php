<?php

namespace App\Services;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function findProductById($productId)
    {
        return $this->productRepository->findProductById($productId);
    }

    public function findProductByName($name)
    {
        return $this->productRepository->findProductsByName($name);
    }

    public function getAllProducts(): JsonResponse
    {
        $products = $this->productRepository->getAll();

        if ($products->isNotEmpty()) {
            $allProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'desc' => $product->description,
                    'image' => $product->image,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'creating_time' => $product->created_at,
                ];
            });

            return response()->json([
                'message' => 'all_products',
                'data' => $allProducts,
            ]);
        }
        return response()->json([
            'message' => 'products not found',
            'data' => [],
        ]);
    }

    public function showProduct($productId): JsonResponse
    {
        $product = $this->productRepository->findProductById($productId);

        if ($product) {
            return response()->json([
                'message' => "Product $productId",
                'data' => $product,
            ]);
        } else {
            return response()->json([
                'message' => "Product not found $productId",
            ]);
        }
    }

    public function createProduct(array $data): JsonResponse
    {
        try {
            $visibility = $data['stock'] > 0 ? 1 : 0;
            $data = array_merge($data, ['visibility' => $visibility]);

            $product = $this->productRepository->createProduct($data);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Product creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function stockUpdate($productId, $quantity)
    {
        /*
            Id'si gelen Product'ın ve kaç tane alındığının verisi işlenecek.
            Belirlenen ürünün stock sayısından toplam alınan ürün kadar stok düşürlecek
            Örneğin
                A ürününün 100 Stoku olsun
                A ürününden 5 tane alındı
                A ürününün Stoku 95 olarak güncellenecek.
        */
    
        $product = $this->findProductById($productId);
        $currentQuantity = $product->stock;
        $newQuantity = $currentQuantity - $quantity;
    
        // Güncelleme işlemi için Eloquent kullanılır ve doğru syntax'a dikkat edilmelidir
        Product::where('id', $productId)->update(['stock' => $newQuantity]);
    }
    

    public function update(array $data, $productId)
    {
        try {
            $this->productRepository->update($data, $productId);
            return response()->json(['message' => 'Product updated successfully', 'product' => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Product update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteProduct($productId): JsonResponse
    {
        $productInfo = $this->findProductById($productId);
        $this->productRepository->deleteProduct($productId);

        return response()->json([
            'message' => 'Product removed successfully',
            'data' => $productInfo,
        ]);
    }
}
