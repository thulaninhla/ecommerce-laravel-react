<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ShopController extends Controller
{
    //
    // public function index()
    // {
    //     $products = Product::all();
    //     return view('shop.index', compact('products'));


    // }
    public function index(Request $request)
{
    $products = Product::latest()->get();
    $showModal = $request->query('show');

    return view('shop.index', compact('products', 'showModal'));
}
}
