<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
    -  Gereken veriler  -

    apikey
    secretkey
    baseurl?

    locale
    ConservationID?
    price
    paid price
    currency (iyzco içerisinden var)
    ınstallment
    basketid
    paymentchannel
    paymentgroup

    -card-
    card holder name
    card number
    expire month
    expire yearh
    cvc
    registered card(0) büyük ihtimalle boolean
    $request->setPaymentCard($paymentCard); kullanımı var

    -buyer-
    id
    name
    surname
    gsmnumber
    email
    idenitynumber
    last login date
    registration date
    registration address
    ip
    city
    country
    zipcode
    $request->setBuyer($buyer);

    -shipping-
    contanct name
    city
    country
    address
    zipcode

    -billing-
    contanct name
    city
    coutry
    address
    zipcode

    -basket item-
    id
    name
    category1
    category2
    itemtype
    price
    $basketItems[0] = $firstBasketItem;

*/

class PaymentController extends Controller
{

}
