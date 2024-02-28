<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPanel extends Model
{
    use HasFactory;

    protected $fillable = ['order_id' ,'user_id', 'total_amount'];

    /**
     * Get the order details for the order panel.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
