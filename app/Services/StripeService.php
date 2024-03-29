<?php

namespace App\Services;
use App\Models\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripeService{

    private $basketService;
    private $purchaseService;

    public function __construct(BasketService $basketService, PurchaseService $purchaseService)
    {
        $this->basketService = $basketService;
        $this->purchaseService = $purchaseService;
    }

    
    public function index() {
        // Product return but we have already product controller 
    }

    public function checkout($userId) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $response = $this->basketService->paymentServiceBasket($userId);
        $products = $response->getData();
        $lineItems = [];
        $totalPrice = 0;
        
        foreach($products->product_datas as $product) {
            $lineItems[] = [
                 'price_data' => [
                     'currency' => 'usd',
                     'product_data' => [
                         'name' => $product->title,
                     ],
                     'unit_amount' => $product->price * 100,
                 ],
                 'quantity' => $product->quantity,
            ];
            $totalPrice += $product->price * $product->quantity;
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);
    
        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $totalPrice; 
        $order->session_id = $session->id;
        $order->save();
    
        return redirect($session->url);
    }


    /*
        Kullanıcının:
         bilgileri gözükecek
         sepetindeki satın alınmış ürünler gözükecek.
         toplam ücreti gözükecek.
         adresi gözükecek. 


    */
    public function success($userId)
    {
        
        return $this->purchaseService->success($userId);

    }

    public function cancel()
    {

    }
}