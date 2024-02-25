<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    /**
     * @LRDparam username string|max:32
     * @ nickaname string|nullable|max:32
     * @LRDresponses 200|422
     */
    public function index()
    {
        $allProducts = $this->productService->getAllProducts();
        return $allProducts;
    }

    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->productService->createProduct($validatedData);
        return $response;
    }

    public function show($id)
    {
        $product = $this->productService->findProductById($id);
        return $product;
    }

    public function search(Request $request)
    {
        $name = $request->productName;
        $products = $this->productService->findProductByName($name);
        return $products;
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
