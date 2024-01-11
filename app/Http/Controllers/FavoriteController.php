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

        $user = $request->User();

        if ($user) {
            $user_id = $user->id;
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

    }

    public function update(){

    }


    public function deleted_products()
    {

    }

    public function destroy()
    {

    }

    public function view(Request $request)
    {

    }
}
