<?php

namespace App\Services;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Services\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    /*
        Product objects:
            $table->id();
            $table->string('title', 40);
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('stock');
            $table->boolean('visibility');
            $table->string('tag', 40);
            $table->timestamps();

    */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function getProduct(): JsonResponse
    {
        $products = $this->productRepository->getAll();

        if ($products->isNotEmpty()) {
            $allProducts = $products->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'product_desc' => $product->description,
                    'product_image' => $product->image,
                    'product_price' => $product->price,
                    'product_stock' => $product->stock,
                    'product_creating_time' => $product->created_at,
                ];
            });

            return response()->json([
                'message' => 'All products in database',
                'data' => $allProducts,
            ]);
        }
        return response()->json([
            'message' => 'Products not found in database',
            'data' => [],
        ]);
    }

    public function findProduct($productId): JsonResponse
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

    public function update(array $data, $productId)
    {
        $this->productRepository->update($data, $productId);
        return response()->json(['message' => 'Product updated successfully', 'product' => $data], 200);
    }

    public function deleteProduct($productId): JsonResponse
    {
        $productInfo = $this->findProduct($productId);
        $this->productRepository->deleteProduct($productId);

        return response()->json([
            'message' => 'Product removed successfully',
            'data' => $productInfo,
        ]);
    }

}
