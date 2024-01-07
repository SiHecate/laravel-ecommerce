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
            'user_id' => ['required', 'numeric'],
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

        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');

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

}
