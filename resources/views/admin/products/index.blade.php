@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-2xl font-bold mb-4">Product Management</h1>

    <a href="{{ route('admin.products.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
        + Add Product
    </a>

    <table class="w-full table-auto border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-20 h-16 object-cover rounded">
                    </td>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">${{ number_format($product->price, 2) }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
