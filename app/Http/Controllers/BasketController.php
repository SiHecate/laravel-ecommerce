<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;

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

        $user = $request->user();

        if ($user) {
            $user_id = $user->id;
        } else {
            // Handle the case when there is no authenticated user
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $basket = Basket::where('user_id', $user_id)->first();

        if (!$basket) {
            $basket = Basket::create([
                'user_id' => $user_id,
                'products' => json_encode([$product_id]),
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

    public function update(Request $request, $product_id, $type)
    {
        $user_id = $request->user()->id;
        $basket = Basket::where('user_id', $user_id)->first();
        if ($basket) {
            $products = json_decode($basket->products, true);
            $product = array_search($product_id, $products);
            if ($product !== false) {

                if ($type == '+') {
                    $products[] = $products[$product];
                } elseif ($type == '-') {
                        unset($products[$product]);
                } else {
                    return response()->json(['message' => 'Wrong type', 'type' => $type], 404);
                }
                $basket->update(['products' => json_encode(array_values($products))]);
                $basket = Basket::where('user_id', $user_id)->first();
                return response()->json([
                    'message' => 'Product quantity updated in the basket',
                    'basket' => $basket,
                    'user_id' => $user_id,
                    'updated_product_id' => $product_id,
                    'type' => $type,
                ], 200);
            } else {
                return response()->json(['message' => "Product with ID $product_id not found in the basket", 'product_id' => $product_id, 'products' => $products], 404);
            }
        } else {
            return response()->json(['message' => 'No products found in the basket', 'user_id' => $user_id], 404);
        }
    }


    public function deleted_products($product_id, $user_id) {
        try {
            $basket = Basket::where('user_id', $user_id)->first();

            if ($basket) {
                $deletedProducts = json_decode($basket->deleted_products, true) ?? [];
                $deletedProducts[] = $product_id;

                // Add these debug statements
                error_log('Basket before update: ' . json_encode($basket));
                error_log('Deleted products before update: ' . json_encode($deletedProducts));

                $basket->update(['deleted_products' => json_encode($deletedProducts)]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($product_id, Request $request)
    {
        $user_id = $request->user()->id;
        $basket = Basket::where('user_id', $user_id)->first();

        if ($basket) {
            if (in_array($product_id, json_decode($basket->products, true))) {
                $products = json_decode($basket->products, true);

                $deletableProduct = array_filter($products, function ($value) use ($product_id) {
                    return $value != $product_id;
                });

                $basket->update(['products' => json_encode(array_values($deletableProduct))]);

                $this-> deleted_products($product_id, $user_id);

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

    public function view(Request $request)
    {
        /*
            ToDo:
                Ürün bilgilerine toplam fiyat ekle (ürün_fiyati*ürün_adeti) olarak
                Ürünlerin bilgilerini al (resim, isim, kodu, adet, birim fiyatı, toplam tutarı)
                    - Resim
                    - İsim
                    - Kod
                    - Adet
                    - Birim fiyat
                    - Toplam tutar
                Sepet boşsa sepet boş uyarısı
                Falan filan. xD
        */

        $user_id = $request->user()->id;


        $basket = Basket::where('user_id', $user_id)->first(); // buradan sepetteki ürünlerin listesini al
        $product = Product::all(); // buradan sepetteki ürünlerin bilgilerini al



        return response()->json(['basket' => $basket], 200);
    }


}
