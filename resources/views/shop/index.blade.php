@extends('layouts.app')

@section('content')
<div class="relative">
    {{-- 🔹 Blur the main content if login/register modal is active --}}
    @if(request()->has('show'))
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <a href="{{ route('shop.index') }}" class="absolute text-2xl text-gray-500 hover:text-gray-800 top-2 right-3">&times;</a>

        @if(request()->get('show') == 'login')
            @include('auth._login-modal')
        @elseif(request()->get('show') == 'register')
            @include('auth._register-modal')
        @endif
    </div>
</div>
@endif

<div class="{{ in_array($showModal, ['login', 'register']) ? 'blur-sm pointer-events-none' : '' }}">

        {{-- Your homepage content like product cards here --}}

    <div class="px-4 py-8 mx-auto max-w-7xl">

    <h1 class="mb-6 text-4xl font-bold">Welcome to the Shop</h1>
    <h1 class="mb-6 text-3xl font-bold">Latest Products</h1>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($products as $product)
            <a href="{{ route('product.show', $product->id) }}" class="block overflow-hidden transition bg-white border rounded-lg shadow-sm hover:shadow-lg">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="object-cover w-full h-64 ">
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $product->name }}</h2>
                    <p class="mt-2 font-bold text-green-600">R{{ number_format($product->price, 2) }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-600">No products found.</p>
        @endforelse
            </div>
        </div>
    </div>

    {{-- 🔹 Login/Register Modal --}}
    @if(in_array($showModal, ['login', 'register']))
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative w-full max-w-md p-6 bg-white rounded shadow-lg">
                <a href="{{ route('shop.index') }}" class="absolute text-2xl text-gray-500 top-2 right-3">&times;</a>

                @if($showModal === 'login')
                    @include('auth._login-modal')
                @elseif($showModal === 'register')
                    @include('auth._register-modal')
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

