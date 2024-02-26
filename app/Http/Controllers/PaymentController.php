<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\StripeService;

class PaymentController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }


    public function index()
    {
        $products = Product::all();

        return view('layouts.product.index', compact('products'));
    }


    public function checkout(Request $request)
    {
        $userId = $request->user()->id;
        return $this->stripeService->checkout($userId);
    }
}
