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

   <form method="POST" action="{{ route('pay') }}" id="paymentForm" class="max-w-lg p-6 mx-auto bg-white rounded shadow-md">
    @csrf

    <h1 class="mb-4 text-2xl font-bold">Checkout</h1>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Full Name</label>
        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none">
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Email</label>
        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none">
    </div>

    <div class="mb-6">
        <label class="block mb-1 font-semibold">Address</label>
        <textarea name="address" required class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none"></textarea>
    </div>

    <div class="mb-6 text-center">
        <button type="button" onclick="payWithPaystack()" class="px-6 py-2 text-white bg-green-600 rounded hover:bg-green-700">
            Pay with Paystack
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

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    function payWithPaystack() {
        const form = document.getElementById('paymentForm');
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;

        if (!name || !email) {
            alert('Please fill in all required fields.');
            return;
        }

        let handler = PaystackPop.setup({
            key: '{{ env("PAYSTACK_PUBLIC_KEY") }}', // Your public key
            email: email,
            amount: {{ $total * 100 }}, // Amount in kobo (R100.00 => 10000)
            currency: "ZAR", // Change to "NGN" if using Nigerian Naira
            ref: 'PSK_' + Math.floor((Math.random() * 1000000000) + 1), // Unique reference
            callback: function(response) {
                // Submit the form to your Laravel route with Paystack reference
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'reference';
                hiddenInput.value = response.reference;
                form.appendChild(hiddenInput);
                form.submit();
            },
            onClose: function() {
                alert('Payment cancelled');
            }
        });

        handler.openIframe();
    }
</script>

