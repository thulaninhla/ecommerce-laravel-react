<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
   protected $fillable = [
    'id',
    'reference',
    'email',
    'amount',
    'status',
    'cart_summary',
];
}
