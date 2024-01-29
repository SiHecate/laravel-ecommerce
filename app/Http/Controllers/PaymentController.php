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

*/

class PaymentController extends Controller
{

}
