<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected function validationRules()
    {
        return [
            'title' => ['required', 'string', 'max:40'],
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => ['required', 'numeric', 'between:0.01,999999.99'],
            'stock' => ['required', 'numeric'],
            'visibility' => 'nullable',
            'tag' => ['required', 'string', 'max:40'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::pluck('title', 'price');

        return response()->json(['products' => $products], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate($this->validationRules());

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


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json(['product' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules());

        $product = Product::findOrFail($id);

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully', 'product' => $product], 200);
    }
}
