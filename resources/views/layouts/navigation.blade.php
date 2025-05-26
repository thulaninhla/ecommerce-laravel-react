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
            <li><a href="{{ route('cart.index') }}" class="hover:underline">Cart</a></li>

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

    <!-- Mobile Menu -->
    <div x-show="open" class="px-6 pb-4 md:hidden">
        <ul class="space-y-2">
            <li><a href="{{ route('shop.index') }}" class="block hover:underline">Home</a></li>
            <li><a href="{{ route('cart.index') }}" class="block hover:underline">Cart</a></li>

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
