<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('layouts.navigation');
<header class='pb-3'>
    <h1>All Orders</h1>
</header>

<!-- Enhanced Search Bar -->
<div class="p-10">
    <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-wrap items-center gap-3 mb-6 ">
        <input
            type="text"
            name="search"
            placeholder="🔍 Search by customer or email"
            value="{{ request('search') }}"
            class="w-full px-4 py-2 transition-all duration-200 border border-gray-300 rounded-lg shadow-sm md:w-1/3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />
        <button
            type="submit"
            class="px-6 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
        >
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('admin.orders') }}"
               class="ml-2 text-sm text-red-500 hover:underline">
                Clear Search
            </a>
        @endif
    </form>
</div>

<section style="padding: 40px;">
    @forelse ($orders as $order)
        <div class="product" style="margin-bottom: 20px;">
            <h3>Order #{{ $order->id }}</h3>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>

            <h4>Items:</h4>
            <ul>
                @foreach (json_decode($order->items, true) as $item)
                    <li>{{ $item['name'] }} x {{ $item['quantity'] }} - ${{ number_format($item['price'], 2) }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</section>
<div class="mt-6">
    {{ $orders->withQueryString()->links() }}
</div>

</body>
</html>
