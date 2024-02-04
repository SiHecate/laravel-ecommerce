<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BasketService;
use App\Http\Requests\BasketRequest;
use App\Services\Repositories\BasketRepository;

class BasketController extends Controller
{

    protected $basketService;
    protected $basketRepository;

    public function __construct(BasketService $basketService, BasketRepository $basketRepository)
    {
        $this->basketService = $basketService;
        $this->basketRepository = $basketRepository;
    }

    public function index()
    {
        $baskets = Basket::all();
        return response()->json(['basket' => $baskets], 200);
    }

    public function store(BasketRequest $request)
    {
        $user = $request->user();

        if ($user) {
            $user_id = $user->id;
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $validatedData = $request->validated();
        $newBasket = $this->basketService->createBasket($validatedData, $user_id);

        return $newBasket;
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

                $this->deleted_products($product_id, $user_id);

                return response()->json([
                    'message' => 'Product removed from the basket',
                    'basket' => $basket,
                    'user_id' => $user_id,
                    'deleted_product_id' => $product_id,
                ], 200);
            } else {
                return response()->json(['message' => 'Product_not_found_in_basket', 'product_id' => $product_id], 404);
            }
        } else {
            return response()->json(['message' => 'Basket not found', 'user_id' => $user_id], 404);
        }
    }

    public function view(Request $request)
    {
        $user_id = $request->user()->id;
        $basketDetails = $this->basketService->getBasket($user_id);
        return $basketDetails;

    }

    public function basketAmount($user_id)
    {
        $products = $this->basketService->getBasket($user_id);
        $totalPrice = $this->basketService->calculateTotalPrice($products);

        return $totalPrice;
    }
}
