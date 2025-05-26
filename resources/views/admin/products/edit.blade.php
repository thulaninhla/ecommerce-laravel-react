@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium">Name</label>
            <input type="text" name="name" id="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description"
                      class="w-full border rounded px-3 py-2"
                      rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block font-medium">Price ($)</label>
            <input type="number" step="0.01" name="price" id="price"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block font-medium">Image URL</label>
            <input type="text" name="image" id="image"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('image', $product->image) }}">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.products') }}"
               class="bg-gray-300 text-black px-4 py-2 rounded mr-2 hover:bg-gray-400">
               Cancel
            </a>
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection
