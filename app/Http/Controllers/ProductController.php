<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Services\Repositories\ProductRepository;
use Illuminate\Http\Client\Request;

class ProductController extends Controller
{

    protected $productRepository;
    protected $productService;


    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index(ProductService $productService)
    {
        $allProducts = $productService->getAllProducts();
        return $allProducts;
    }

    public function store(ProductRequest $request, ProductService $productService)
    {
        $validatedData = $request->validated();
        $response = $productService->createProduct($validatedData);
        return $response;
    }

    public function show($id, ProductService $productService)
    {
        $product = $productService->findProductById($id);
        return $product;
    }

    public function search(Request $request, ProductService $productService)
    {
        $productName = $request->query('productName');
        dd($productName);
        $products = $productService->findProductByName($productName);
        return $products;
    }
    
    

    public function update(ProductRequest $request, $id, ProductService $productService)
    {
        $validatedData = $request->validated();
        $response =  $productService->update($validatedData, $id);
        return $response;
    }

    public function destroy($id, ProductService $productService)
    {
        $product = $productService->deleteProduct($id);
        return $product;
    }
}
