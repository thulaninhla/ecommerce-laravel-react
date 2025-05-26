<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    //
    public function index()
{
    $this->authorizeAdmin();
    $products = \App\Models\Product::all();
    return view('admin.products.index', compact('products'));
}

public function store(Request $request)
{
    $this->authorizeAdmin();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'main_image' => 'required|image|mimes:jpeg,png,jpg|max:3072',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:3072'
    ]);

    // Store main image
    $mainImagePath = $request->file('main_image')->store('products', 'public');

    // Create product
    $product = Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? '',
        'price' => $validated['price'],
        'image' => '/storage/' . $mainImagePath
    ]);

    // Store thumbnails
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $thumbPath = $image->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/storage/' . $thumbPath
            ]);
        }
    }

    return redirect()->route('admin.products')->with('success', 'Product created!');
}


public function create()
{
    $this->authorizeAdmin();
    return view('admin.products.create');
}

protected function authorizeAdmin()
{
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized');
    }
}
public function edit($id)
{
    $this->authorizeAdmin();
    $product = \App\Models\Product::findOrFail($id);
    return view('admin.products.edit', compact('product'));
}

public function update(Request $request, $id)
{
    $this->authorizeAdmin();

    $product = \App\Models\Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|string',
    ]);

    $product->update($validated);

    return redirect()->route('admin.products')->with('success', 'Product updated!');
    }
    public function destroy($id)
    {
    $this->authorizeAdmin();

    $product = \App\Models\Product::findOrFail($id);
    $product->delete();

    return redirect()->route('admin.products')->with('success', 'Product deleted!');
    }


    public function storeReview(Request $request, $id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);

    Review::create([
        'product_id' => $id,
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->back()->with('success', 'Review submitted!');
}
public function show($id)

    {
        $product = Product::with('images', 'reviews.user')->findOrFail($id);
            return view('product.show', compact('product'));

    }

}
