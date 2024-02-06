<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'adress_name',
        'user_id',
        'name',
        'surname',
        'email',
        'telephone',
        'city',
        'district',
        'neighborhood',
        'address',
    ];

    protected $casts = [
        'telephone' => 'integer', // Telefon numarasını integer olarak dönüştür
    ];
}
