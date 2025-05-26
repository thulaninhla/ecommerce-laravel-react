@extends('layouts.app')

@section('content')
<div class="max-w-5xl px-4 py-8 mx-auto">
    <div class="grid gap-8 md:grid-cols-2">
        <!-- Left Column: Images -->
        <div>
            <!-- Main Image -->
            <img id="mainImage" src="{{ $product->image }}" alt="{{ $product->name }}"
                class="w-full mb-4 rounded-lg max-h-[400px] object-cover shadow">

            <!-- Thumbnail Gallery -->
            <div class="flex gap-3">
                @foreach ($product->images as $img)
                    <img src="{{ asset($img->image_url) }}"
                         alt="Thumbnail"
                         class="object-cover w-24 h-24 border rounded cursor-pointer hover:ring-2 hover:ring-blue-400"
                         onclick="document.getElementById('mainImage').src = '{{ asset($img->image_url) }}'">
                @endforeach
            </div>
        </div>

        <!-- Right Column: Product Info -->
        <div>
            <h1 class="mb-2 text-3xl font-bold">{{ $product->name }}</h1>
            <p class="mb-4 text-gray-700">{{ $product->description }}</p>
            <p class="mb-6 text-xl font-semibold text-green-600">R{{ number_format($product->price, 2) }}</p>

            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="decreaseQty()" class="px-3 py-1 text-lg font-bold bg-gray-200 rounded">−</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-16 p-1 text-center border rounded">
                        <button type="button" onclick="increaseQty()" class="px-3 py-1 text-lg font-bold bg-gray-200 rounded">+</button>
                    </div>
                </div>

                <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                    Add to Cart
                </button>
            </form>

            <script>
                function increaseQty() {
                    let qtyInput = document.getElementById('quantity');
                    qtyInput.value = parseInt(qtyInput.value) + 1;
                }

                function decreaseQty() {
                    let qtyInput = document.getElementById('quantity');
                    if (parseInt(qtyInput.value) > 1) {
                        qtyInput.value = parseInt(qtyInput.value) - 1;
                    }
                }
            </script>


        </div>
    </div>

    <!-- Customer Reviews -->
    <div class="mt-12">
        <h2 class="mb-4 text-2xl font-bold">Customer Reviews</h2>

        @auth
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="rating" class="block mb-1 font-medium">Rating</label>
                    <select name="rating" id="rating" required class="w-20 p-2 border rounded">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label for="comment" class="block mb-1 font-medium">Comment</label>
                    <textarea name="comment" id="comment" rows="3"
                              class="w-full p-2 border rounded"
                              placeholder="Your review..."></textarea>
                </div>

                <button type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Submit Review</button>
            </form>
        @else
            <p class="mb-6 text-sm">Please <a href="{{ route('login') }}" class="text-blue-500 underline">login</a> to leave a review.</p>
        @endauth

        @if ($product->reviews->count())
            <div class="space-y-6">
                @foreach ($product->reviews as $review)
                    <div class="pb-2 border-b">
                        <p class="text-yellow-500">{{ str_repeat('⭐', $review->rating) }}</p>
                        <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                        <p class="text-xs text-gray-400">by {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Related Products -->
    <div class="mt-12">
        <h2 class="mb-4 text-xl font-semibold">Related Products</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
            @foreach (\App\Models\Product::inRandomOrder()->limit(3)->get() as $related)
                <a href="{{ route('product.show', $related->id) }}"
                   class="p-4 transition border rounded-lg hover:shadow-lg">
                    <img src="{{ $related->image }}" alt="{{ $related->name }}"
                         class="object-cover w-full h-40 mb-2 rounded">
                    <h4 class="text-lg font-bold">{{ $related->name }}</h4>
                    <p class="text-green-600">R{{ number_format($related->price, 2) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
