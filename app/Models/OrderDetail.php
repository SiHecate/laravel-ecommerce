<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'order_number', 'product_name', 'product_image', 'product_price', 'product_quantity'];

    /**
     * Get the order panel that owns the order detail.
     */
    public function orderPanel()
    {
        return $this->belongsTo(OrderPanel::class);
    }
}
