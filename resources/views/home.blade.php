@extends('layouts.app')

@section('content')
@php $showModal = request()->query('show'); @endphp

<div class="relative" >
    <div class="{{ $showModal ? 'blur-sm' : '' }}">
        {{-- Homepage Content --}}
        <h1 class="mb-6 text-5xl font-bold">Welcome to Your Shop</h1>
    </div>

    @if($showModal === 'login' || $showModal === 'register')
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
