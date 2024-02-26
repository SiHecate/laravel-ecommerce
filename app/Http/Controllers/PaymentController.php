<?php

namespace App\Http\Controllers;

use App\Services\BasketService;
use Illuminate\Http\Request;
use App\Services\StripeService;

class PaymentController extends Controller
{
    private $stripeService;
    private $basketService;

    public function __construct(StripeService $stripeService, BasketService $basketService)
    {
        $this->stripeService = $stripeService;
        $this->basketService = $basketService;
    }


    public function index(Request $request)
    {
        $userId = $request->user()->id;
    
        if (!$userId)
        {
            return "Kayıt olun.";
        }
    
        $basketData = $this->basketService->paymentServiceBasket($userId);
        $basket = json_decode($basketData->getContent(), true);
    
        return view('layouts.product.index', compact('basket'));
    }
    


    public function checkout(Request $request)
    {
        $userId = $request->user()->id;
        return $this->stripeService->checkout($userId);
    }

    public function success(Request $request)
    {
        return $this->stripeService->success($request);   
    }

    public function cancel()
    {
        return "cancel";
    }
}
