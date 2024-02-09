<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users_address';

    protected $fillable = [
        'address_name',
        'user_id',
        'name',
        'lastname',
        'email',
        'telephone',
        'city',
        'county',
        'neighborhood',
        'full_address',
    ];

    protected $casts = [
        'telephone' => 'integer',
    ];

}
