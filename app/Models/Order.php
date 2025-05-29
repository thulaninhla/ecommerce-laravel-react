<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
         'email', 'amount', 'payment_reference', 'status'
    ];
}
