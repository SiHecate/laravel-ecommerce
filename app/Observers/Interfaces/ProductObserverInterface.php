<?php

namespace App\Observers\Interfaces;

use App\Models\Product;

interface ProductObserver {
    public function stockUpdated(Product $product);
};  