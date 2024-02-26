<?php

namespace App\Services;

class StripeService{
    
    public function index() {
        // Product return but we have already product controller 
    }

    public function checkout() {

        // Stripe secret key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Product

        


    }
}