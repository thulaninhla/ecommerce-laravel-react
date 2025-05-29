<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Http\Controllers\{
    ProductController,
    ShopController,
    CartController,
    OrderController,
    ProfileController,
    PaystackController
};

// Home and Shop
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Custom Auth (Register/Login)
Route::post('/custom-register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->route('shop.index', ['show' => 'register'])
                         ->withErrors($validator)
                         ->withInput();
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);
    return redirect('/')->with('success', 'Registration successful! You are now logged in.');
})->name('custom.register');

Route::post('/custom-login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/')->with('success', 'You are now logged in!');
    }

    return redirect()->route('shop.index', ['show' => 'login'])
                     ->withErrors(['email' => 'Invalid credentials'])
                     ->withInput();
})->name('custom.login');

Route::get('/login', fn () => redirect('/?show=login'))->name('login');
Route::get('/register', fn () => redirect('/?show=register'))->name('register');

// Profile (auth only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (auth only)
Route::prefix('admin')->middleware('auth')->group(function () {
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/checkout/process', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

// Paystack Payment
Route::post('/pay', [PaystackController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaystackController::class, 'handleGatewayCallback'])->name('payment.callback');

Route::get('/payment/success', function () {
    return view('payment.success', ['details' => session('details')]);
})->name('payment.success');

Route::get('/payment/failed', function () {
    return view('payment.failed', ['error' => session('error')]);
})->name('payment.failed');


// Product Review
Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('reviews.store')->middleware('auth');

// Laravel Auth scaffolding
require __DIR__.'/auth.php';
