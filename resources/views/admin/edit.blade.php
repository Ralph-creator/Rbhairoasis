<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - RBHairOasis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-pink-50 min-h-screen">
    <header class="bg-pink-500 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">RBHairOasis Admin</h1>
        <a href="{{ route('admin.index') }}" class="bg-white text-pink-500 px-4 py-2 rounded hover:bg-pink-100">Back to Dashboard</a>
    </header>

    <main class="max-w-2xl mx-auto py-10">
        <h2 class="text-2xl font-semibold text-center mb-6">Edit Product</h2>
                    @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded relative">
                    {{ session('success') }}
                    <a href="{{ route('admin.index') }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600">Back to Dashboard</a>
                </div>
            @endif


        <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-6">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded p-2" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Category</label>
                <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Price (₦)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Image</label>
                <input type="file" name="image" class="w-full border rounded p-2">
                <p class="text-sm text-gray-600 mt-1">Current: <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image" class="h-24 mt-2"></p>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Update Product</button>
                <a href="{{ route('admin.index') }}" class="text-pink-500">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>
