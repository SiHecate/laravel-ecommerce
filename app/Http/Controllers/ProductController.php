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

    public function index()
    {
        $products = Product::orderBy('created_at', 'asc')->get();

        return response()->json(['products' => $products], 200);
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

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json(['product' => $product], 200);
    }


    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules());

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
