<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    return redirect('/')->with('success', 'Registration successful! You are now logged in.')    ;
})->name('custom.register');


Route::post('/custom-login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/')->with('success', 'You are now logged in!'); // redirect to home on success and returns message
    }

    return redirect()->route('shop.index', ['show' => 'login'])
                     ->withErrors(['email' => 'Invalid credentials'])
                     ->withInput();
})->name('custom.login');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/login', function () {
    return redirect('/?show=login');
})->name('login');

Route::get('/register', function () {
    return redirect('/?show=register');
})->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders');

     // Admin product management
     Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
     Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
     Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
     Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
     Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
     Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [CartController::class, 'viewOrders'])->name('admin.orders');
});

// Show cart page

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Add to cart

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::post('/cart/checkout/process', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Clear cart (after order placed)

Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Show the checkout form (GET)

Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Handle checkout form submission

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
});

Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('reviews.store')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

require __DIR__.'/auth.php';


