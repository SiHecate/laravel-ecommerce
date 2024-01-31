<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    protected function validationRules()
    {
        return [
            'product_id' => ['Required','numeric',]
        ];
    }

    public function index()
    {
        $favorites = Favorite::all();
        return response()->json(['favorite' => $favorites], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $product_id = $request->input('product_id');

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user_id = $user->id;

        $favorite = Favorite::where('user_id', $user_id)->first();

        if (!$favorite) {
            $favorite = Favorite::create([
                'user_id' => $user_id,
                'products' => json_encode([$product_id]),
            ]);
        } else {
            $favoriteProducts = json_decode($favorite->products, true) ?? [];
            $favoriteProducts[] = $product_id;

            $favorite->update([
                'products' => json_encode($favoriteProducts),
            ]);
        }

        return response()->json(['message' => 'Product added to basket successfully', 'basket' => $favorite], 201);
    }


    public function update(Request $request, $product_id, $type){
        // Favorite page'de ihtiyacı olmadığını düşünüyorum şu an için

    }



    public function deleted_products($product_id, $user_id)
    {
        try {
            $favorite = Favorite::Where('user_id', $user_id)->first();

            if ($favorite) {
                $deletedProducts[] = json_encode($favorite->deleted_product, true) ?? [];
                $deletedProducts[] = $product_id;

                error_log('Basket before update: ' . json_encode($favorite));
                error_log('Deleted products before update: ' . json_encode($deletedProducts));

                $favorite->update(['deleted_products' => json_encode($deletedProducts)]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($product_id, Request $request)
    {
        $user_id = $request->user()->id;
        $favorite = Favorite::where('user_id', $user_id)->first();

        if ($favorite) {
            $products = json_decode($favorite->products, true);

            if (is_array($products) && in_array($product_id, $products)) {
                $deletable_products = array_filter($products, function ($value) use ($product_id) {
                    return $value != $product_id;
                });

                $favorite->update(['products' => json_encode(array_values($deletable_products))]);

                $this->deleted_products($product_id, $user_id);

                return response()->json([
                    'message' => 'Product removed from the basket',
                    'basket' => $favorite,
                    'user_id' => $user_id,
                    'deleted_product_id' => $product_id,
                ], 200);
            } else {
                return response()->json(['message' => 'Product not found in favorite', 'product_id' => $product_id], 404);
            }
        } else {
            return response()->json(['message' => 'Favorite not found', 'user_id' => $user_id], 404);
        }
    }

    public function view(Request $request)
    {
        $user_id = $request->user()->id;

        $favorite = Favorite::where('user_id', $user_id)->first();
        $products = json_decode($favorite->prodcuts, true) ?? [];

        $productDetails= [];

        foreach($products as $product_id)
        {
            $product = Product::find($product_id);

            if ($product)
            {
                if (!isset($productDetails[$product->id]))
                {
                    $productDetails[$product->id] =
                    [
                        'product_code' => $product->id,
                        'product_name' => $product->title,
                        'product_image' => $product->image,
                        'product_description' => $product->description,
                        'product_price' => $product->price,
                    ];
                }
            }
        }
        return response()->json(['products in basket' => array_values($productDetails),'current basket' => $favorite,], 200);
    }

}
