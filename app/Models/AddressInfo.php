<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressInfo extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'address_name', 'name', 'lastname', 'telephone', 'city', 'county', 'neighborhood', 'full_address'];

}
