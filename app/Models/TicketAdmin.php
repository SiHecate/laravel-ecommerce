<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAdmin extends Model
{
    use HasFactory;
    protected $fillable = ['response_id', 'ticket_id', 'title', 'desc'];
}
