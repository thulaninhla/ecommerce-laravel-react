<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;


class CartController extends Controller
{

    public function add(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $quantity = max((int) $request->input('quantity', 1), 1);

    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        // If already in cart, update quantity
        $cart[$productId]['quantity'] += $quantity;
    } else {
        // If not in cart, add it
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $quantity,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Product added to cart!');
}


    public function index()
    {
    $cart = session()->get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return view('cart', compact('cart', 'total'));
    }

    public function clear()
    {
    session()->forget('cart');
    return redirect()->route('cart.index')->with('success', 'Thank you! Your order has been placed.');
    }

    public function checkout()
{
    $cart = session()->get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return view('checkout', compact('cart', 'total'));
}

public function processCheckout(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'address' => 'required'
    ]);

    $cart = session()->get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Store in DB
    Order::create([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'items' => json_encode($cart),
        'total' => $total
    ]);

    session()->forget('cart');

    return redirect()->route('cart.index')->with('success', 'Thanks for your order, ' . $request->name . '!');
 }

    public function viewOrders()
    {
    $orders = Order::latest()->get();
    return view('admin.orders', compact('orders'));
    }


}
