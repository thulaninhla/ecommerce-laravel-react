@php
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
@endphp


<nav x-data="{ open: false }" class="text-white bg-blue-600 shadow">
    <div class="container flex items-center justify-between px-6 py-4 mx-auto">
        <!-- Logo -->
        <div class="text-xl font-bold">
            <a href="{{ route('shop.index') }}">Kasi Brands</a>
        </div>

        <!-- Hamburger (mobile) -->
        <button @click="open = !open" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Links (desktop) -->
        <ul class="items-center hidden space-x-4 md:flex">
            <li><a href="{{ route('shop.index') }}" class="hover:underline">Home</a></li>
          <li class="relative group">
    <a href="{{ route('cart.index') }}" class="flex items-center gap-1 hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-5h-4"/>
        </svg>
        @if($cartCount > 0)
            <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-600 rounded-full -top-2 -right-2">
                {{ $cartCount }}
            </span>
        @endif
    </a>

    <!-- Dropdown -->
    <div class="absolute right-0 z-50 hidden w-64 p-4 mt-2 bg-white rounded shadow-lg group-hover:block">
        @if($cartCount > 0)
            <ul class="overflow-y-auto divide-y divide-gray-200 max-h-52">
                @foreach($cart as $item)
                    <li class="flex justify-between py-2 text-sm">
                        <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 text-right">
                <a href="{{ route('cart.checkout') }}"
                   class="inline-block px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                    Checkout
                </a>
            </div>
        @else
            <p class="text-sm text-gray-500">Your cart is empty.</p>
        @endif
    </div>
</li>



           @auth
                @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.orders') }}" class="hover:underline">Admin Orders</a></li>
                    <li><a href="{{ route('admin.products.create') }}" class="nav-link">Create Product</a></li>

                @endif

                <li class="flex items-center gap-2">
                    {{-- Avatar Circle with Initials --}}
                    <div class="flex items-center justify-center w-8 h-8 font-bold text-blue-600 uppercase bg-white rounded-full">
                       {{ collect(explode(' ', auth()->user()->name))->map(fn($part) => strtoupper($part[0]))->join('') }}
                    </div>
                    Hi, {{ auth()->user()->name }}!
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-red-500 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth


            @guest
                <a href="{{ route('shop.index', ['show' => 'login']) }}">Login</a>
                <a href="{{ route('shop.index', ['show' => 'register']) }}">Register</a>

            @endguest

        </ul>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="px-6 pb-4 md:hidden">
        <ul class="space-y-2">
            <li><a href="{{ route('shop.index') }}" class="block hover:underline">Home</a></li>
            <li class="relative">
    <a href="{{ route('cart.index') }}" class="flex items-center gap-1 hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-5h-4"/>
        </svg>
        <span>Cart</span>
        @if($cartCount > 0)
            <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-600 rounded-full -top-2 -right-2">
                {{ $cartCount }}
            </span>
        @endif
    </a>
</li>



           @auth
                @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.orders') }}" class="hover:underline">Admin Orders</a></li>
                @endif

                <li class="flex items-center gap-2">
                    {{-- Avatar Circle with Initials --}}
                    <div class="flex items-center justify-center w-8 h-8 font-bold text-blue-600 uppercase bg-white rounded-full">
                        {{ collect(explode(' ', auth()->user()->name))->map(fn($part) => strtoupper($part[0]))->join('') }}
                    </div>
                    Hi, {{ auth()->user()->name }}!
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-red-500 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth


            @guest
                <a href="{{ route('shop.index', ['show' => 'login']) }}">Login</a>
                <a href="{{ route('shop.index', ['show' => 'register']) }}">Register</a>

            @endguest
        </ul>
    </div>
</nav>


<!-- Spacer for fixed navbar -->
<div class="h-20"></div>
