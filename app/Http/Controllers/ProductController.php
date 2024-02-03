<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Services\Repositories\ProductRepository;

class ProductController extends Controller
{

    protected $productRepository;
    protected $productService;


    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index()
    {
        $allProducts = $this->productService->getProduct();

        return response()->json([
            'message' => 'All products in the database',
            'data' => $allProducts,
        ], 200);
    }


    public function tags()
    {
        try {
            $tags = Product::pluck('tag');

            $uniqueTag = $tags->unique();

            return response()->json(['tags' => $uniqueTag], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving tags', 'error' => $e->getMessage()], 500);
        }
    }


    public function store(ProductRequest $request)
    {
        try {
            if ($request->stock > 0) {
                $request->merge(['visibility' => 1]);
            } else {
                $request->merge(['visibility' => 0]);
            }

            $product = Product::create($request->all());

            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation error', 'error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $product = $this->productService->findProduct($id);

        return response()->json([
            'message' => "Product $id",
            'data' => $product,
        ], $product ? 200 : 404);
    }


    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully', 'product' => $product], 200);
    }
}
