<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::pluck('title','price');

        return response()->json(['products' => $products], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:40'],
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => ['required', 'numeric', 'between:0.01,999999.99'],
            'tag' => ['required', 'string', 'max:40'],
        ]);

        $product = Product::create($request->all());

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::all(); // Databasedeki bütün ürünlerin listesi

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:40'],
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => ['required', 'numeric', 'between:0.01,999999.99'],
            'tag' => ['required', 'string', 'max:40'],
        ]);

        $product = Product::findOrFail($id);

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->image = $request->input('image');
        $product->price = $request->input('price');
        $product->tag = $request->input('tag');

        $product->save();

        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted succesfully', 'product' => $product], 200);
    }
}
