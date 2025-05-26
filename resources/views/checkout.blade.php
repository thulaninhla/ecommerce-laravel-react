@extends('layouts.app')

@section('content')
<div class="max-w-3xl px-4 py-10 mx-auto">
    <h2 class="mb-6 text-3xl font-bold">Checkout</h2>

    @if($errors->any())
        <div class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cart.processCheckout') }}" method="POST" class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-bold text-gray-700" for="name">Full Name</label>
            <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none" type="text" name="name" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-bold text-gray-700" for="email">Email</label>
            <input class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none" type="email" name="email" required>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-bold text-gray-700" for="address">Address</label>
            <textarea name="address" rows="4" required class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none"></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="px-6 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700">
                Place Order
            </button>
        </div>
    </form>

    <div class="mt-8">
        <h3 class="mb-2 text-xl font-bold">Order Summary</h3>
        <ul class="space-y-2">
            @foreach($cart as $item)
                <li class="flex justify-between pb-2 border-b">
                    <span>{{ $item['quantity'] }} × {{ $item['name'] }}</span>
                    <span>R{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </li>
            @endforeach
        </ul>
        <h4 class="mt-4 text-lg font-bold">Total: R{{ number_format($total, 2) }}</h4>
    </div>
</div>
@endsection
