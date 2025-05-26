<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<header>
    <h1>All Orders</h1>
</header>

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

</body>
</html>
