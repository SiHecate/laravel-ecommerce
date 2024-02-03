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
        return $allProducts;
    }

    public function store(ProductRequest $request, ProductService $productService)
    {
        $validatedData = $request->validated();
        $response = $productService->createProduct($validatedData);
        return $response;
    }


    public function show($id)
    {
        $product = $this->productService->findProduct($id);
        return $product;
    }


    public function update(ProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $response =  $this->productService->update($validatedData, $id);
        return $response;
    }

    public function destroy($id)
    {
        $product = $this->productService->deleteProduct($id);
        return $product;
    }
}
