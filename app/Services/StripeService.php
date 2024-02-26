<?php

namespace App\Services;
use App\Models\Order;

class StripeService{

    private $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    
    public function index() {
        // Product return but we have already product controller 
    }

    public function checkout($userId) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $products = $this->basketService->paymentServiceBasket($userId);
        $lineItems = [];
        $totalPrice = 0;
    
        foreach($products['product_datas'] as $product) {
           $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product['title'],
                        'image' => $product['image'],
                    ],
                    'unit_amount' => $product['price'] * 100,
                ],
                'quantity' => $product['quantity'],
           ];
           $totalPrice += $product['price'] * $product['quantity'];
        }
    
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true),
            'cancel_url' => route('checkout.cancel', [], true ),
        ]);
    
        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $totalPrice; 
        $order->session_id = $session->id;
        $order->save();
    
        return redirect($session->url);
    }
    
}