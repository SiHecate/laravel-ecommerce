<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'price', 'stock', 'visibility', 'tag'];

    
    protected static function boot()
    {
        parent::boot();

        static::observe(ProductObserver::class);
    }
}
