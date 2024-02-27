<?php

namespace App\Services;

class OrderService
{

    // Construct
    public function __construct()
    {
        
    }


    /*
        userId aracılığı ile kullanıcının adına ve diğer bilgilerine erişebileceğiz.
        order oluştururken tek tek bütün verileri kaydetmeyi planıyorum 
        Örneğin 
        -> order_id 1 orderNumber123 Ürün_Adı1 Ürün_Resmi1 Ürün_Fiyatı1 Ürün_Adeti1
        -> order_id 1 orderNumber124 Ürün_Adı2 Ürün_Resmi2 Ürün_Fiyatı2 Ürün_Adeti2
        -> order_id 1 orderNumber125 Ürün_Adı2 Ürün_Resmi3 Ürün_Fiyatı3 Ürün_Adeti3
        -> order_id başına
            --> Sepet toplam tutarı
            --> Kullanıcının bilgileri
                ---> Adres Bilgileri
                ---> Müşteri adı, soyadı
        
        Bu sistemi kurabilmek için one-to-many kullanılması mantıklı gibi 
        Order_Table --> Order_Details
        OrderDetails ile OrderTable'da ortak bir veri kullanmayı planlıyorum.
        Bu sayede order_id altında kategorilenecek ve her ürün ayrı ayrı gösterilecek
    */    
    public function createOrder($userId, $productId, $totalPrice)
    {

    }

}