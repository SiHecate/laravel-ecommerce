<?php

namespace App\Observers;

use App\Models\Product;
use App\Observers\Interfaces\ProductObserver as ProductObserverInterface;

class ProductObserver implements ProductObserverInterface{

    public function stockUpdated(Product $product) {

        if ($product->stock === 0) {
          $product->visibility = false;
          $product->save();
        }

        if ($product->stock > 0) {
            $product->visibility = true;
            $product->save();
        }
      }
}