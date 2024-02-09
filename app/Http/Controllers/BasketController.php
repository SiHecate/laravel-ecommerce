<?php

namespace App\Http\Controllers;

use App\Models\Basket;;
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
        $userId = $request->user()->id;

        $validatedData = $request->validated();
        $newBasket = $this->basketService->addProduct($validatedData, $userId);

        return $newBasket;
    }

    public function update(Request $request, $product_id, $type)
    {
        $userId = $request->user()->id;

        return $this->basketService->updateProduct(
            $product_id,
            $userId,
            $type,
        );
    }

    public function destroy($product_id, Request $request)
    {
        $userId = $request->user()->id;
        return $this->basketService->deleteProduct($product_id, $userId);
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
