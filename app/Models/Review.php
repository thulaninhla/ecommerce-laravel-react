<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    public function user()
    {
    return $this->belongsTo(User::class);
    }

public function product()
    {
    return $this->belongsTo(Product::class);
    }
    protected $fillable = ['product_id', 'user_id', 'comment', 'rating'];

}
