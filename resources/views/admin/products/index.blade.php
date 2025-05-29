@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-2xl font-bold">Product Management</h1>

    <a href="{{ route('admin.products.create') }}"
       class="inline-block px-4 py-2 mb-4 text-white bg-blue-600 rounded hover:bg-blue-700">
        + Add Product
    </a>

    <table class="w-full border border-gray-300 table-auto">
        <thead>
            <tr class="text-left bg-gray-100">
                <th class="px-4 py-2 border">Image</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Price</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="object-cover w-20 h-16 rounded">
                    </td>
                    <td class="px-4 py-2 border">{{ $product->name }}</td>
                    <td class="px-4 py-2 border">${{ number_format($product->price, 2) }}</td>
                    <td class="flex px-4 py-2 space-x-2 border">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No products found.</td>
                </tr>

            @endforelse
        </tbody>

    </table>
</div>
@endsection
