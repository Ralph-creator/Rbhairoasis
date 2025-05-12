@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Add Product</h2>
    <form method="POST" action="/admin/products" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Name" class="block w-full border mb-2 p-2" required>
        <textarea name="description" placeholder="Description" class="block w-full border mb-2 p-2" required></textarea>
        <input type="text" name="category" placeholder="Category" class="block w-full border mb-2 p-2" required>
        <input type="number" step="0.01" name="price" placeholder="Price" class="block w-full border mb-2 p-2" required>
        <input type="file" name="image" class="block w-full border mb-4 p-2" required>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
