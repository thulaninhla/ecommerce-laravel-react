@extends('layouts.app')

@section('content')
<div class="max-w-3xl p-6 mx-auto bg-white rounded-md shadow-md">
    <h2 class="mb-6 text-2xl font-bold">Create Product</h2>

    @if ($errors->any())
        <div class="p-4 mb-4 text-red-600 bg-red-100 rounded">
            <ul>

                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="name">Product Name</label>
            <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="description">Description</label>
            <textarea name="description" id="description" class="w-full px-3 py-2 border rounded" rows="4"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="price">Price (R)</label>
            <input type="number" name="price" id="price" step="0.01" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium" for="main_image">Main Image</label>
            <input type="file" name="main_image" id="main_image" accept="image/*" class="w-full px-3 py-2 border">
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-medium" for="images">Thumbnail Images (up to 4)</label>
            <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full px-3 py-2 border">
        </div>

        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            Create Product
        </button>
    </form>
</div>
@endsection
