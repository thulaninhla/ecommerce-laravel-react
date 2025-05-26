<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'image'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);

    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}


