<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketUser extends Model
{
    use HasFactory;
    protected $fillable = ['title' ,'desc', 'ticket_id', 'user_id'];

}
