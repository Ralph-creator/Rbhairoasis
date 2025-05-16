@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold text-violet-700 mb-6">Add New Product</h2>
           @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded relative">
                    {{ session('success') }}
                    <a href="{{ route('admin.index') }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600">Back to Dashboard</a>
                </div>
            @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 text-red-600 bg-red-100 border border-red-300 p-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Product Form -->
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold">Description</label>
                <input type="text" name="description" value="{{ old('description') }}"
                    class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-gray-700 font-semibold">Category</label>
                <input type="text" name="category" value="{{ old('category') }}"
                    class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-gray-700 font-semibold">Price</label>
                <input type="number" name="price" value="{{ old('price') }}"
                    class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-violet-500" required>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-gray-700 font-semibold">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500"
                    onchange="previewImage(event)">
                <div class="mt-4">
                    <img id="image-preview" class="w-40 h-40 object-cover border rounded hidden" />
                </div>
            </div>

            <!-- Featured Checkbox -->
            <div>
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" name="is_featured" class="form-checkbox text-violet-600"
                        {{ old('is_featured') ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Mark as Featured</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="bg-violet-700 hover:bg-violet-800 text-white font-bold py-2 px-6 rounded shadow">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection
