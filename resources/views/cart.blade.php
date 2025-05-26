@extends('layouts.app')

@section('content')
<div class="max-w-5xl px-4 py-8 mx-auto">
    <h2 class="mb-6 text-3xl font-bold">Your Cart</h2>

    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="space-y-6">
            @foreach($cart as $id => $item)
                <div class="flex items-center justify-between pb-4 border-b">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="object-cover w-24 h-20 rounded">
                        <div>
                            <h3 class="text-xl font-semibold">{{ $item['name'] }}</h3>
                            <p class="text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                    <p class="text-lg font-bold">R{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-right">
            <h3 class="mb-4 text-2xl font-bold">Total: R{{ number_format($total, 2) }}</h3>
            <div class="space-x-4">
                <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Clear Cart</button>
                </form>
                <form action="{{ route('cart.checkout') }}" method="GET" class="inline">
                    <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Proceed to Checkout</button>
                </form>
            </div>
        </div>
    @else
        <p class="text-gray-600">Your cart is empty.</p>
    @endif
</div>
@endsection
