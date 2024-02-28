<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;


    /**
     * Get the order panel that owns the order detail.
     */
    public function orderPanel()
    {
        return $this->belongsTo(OrderPanel::class);
    }
}
