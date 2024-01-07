<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /*
        ToDo:
            Her kullanıcının kendisine ait bir Cart'ı olabilir (belongs to)
            Kullanıcı sepetine ürün eklemek istediğinde kullanıcının id'si ve eklenen ürünün id'si eklenecek
            bu sayede hangi kullanıcının sepetinde hangi ürünlerin olduğunun verisini alabiliriz
    */

    protected function validationRules()
    {
        return [
            'product_id' => ['required','numeric',]
        ];
    }

    public function index()
    {
        $baskets = Basket::all();
        return response()->json(['basket' => $baskets], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $product_id = $request->input('product_id');

        $user_id = $request->user()->id;

        $basket = Basket::where('user_id', $user_id)->first();

        if (!$basket) {
            $basket = Basket::create([
                'user_id' => $user_id,
                'products' => json_encode([$product_id]), // Diziyi JSON dizesine çevir
            ]);
        } else {
            $basketProducts = json_decode($basket->products, true) ?? [];
            $basketProducts[] = $product_id;

            $basket->update([
                'products' => json_encode($basketProducts),
            ]);
        }

        return response()->json(['message' => 'Product added to basket successfully', 'basket' => $basket], 201);
    }

    public function update(Request $request, $product_id)
    {}

    public function destroy($product_id, Request $request)
    {
        $user_id = $request->user()->id;
        $basket = Basket::where('user_id', $user_id)->first();

        if ($basket) {
            // Check if the product exists in the basket
            if (in_array($product_id, json_decode($basket->products, true))) {
                $products = json_decode($basket->products, true);

                // Remove the product with the given id from the array
                $newProducts = array_filter($products, function ($value) use ($product_id) {
                    return $value != $product_id;
                });

                $basket->update(['products' => json_encode(array_values($newProducts))]); // Encode back to JSON

                return response()->json([
                    'message' => 'Product removed from the basket',
                    'basket' => $basket,
                    'user_id' => $user_id,
                    'deleted_product_id' => $product_id,
                ], 200);
            } else {
                return response()->json(['message' => 'Product not found in basket', 'product_id' => $product_id], 404);
            }
        } else {
            return response()->json(['message' => 'Basket not found', 'user_id' => $user_id], 404);
        }
    }




}
