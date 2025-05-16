<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBHairOasis Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-pink-500 text-white p-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <img src="/storage/logo/rbhairs.jpg" alt="RBHairOasis Logo" class="w-10 h-10 rounded-full">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        </div>
        <a href="/" class="bg-white text-pink-500 px-4 py-2 rounded hover:bg-pink-100">Back to Home</a>
    </header>

    <!-- Button Navigation Group -->
    <div class="max-w-7xl mx-auto mt-6 px-4">
        <div class="mb-6 flex justify-end gap-4">
            <a href="{{ route('admin.create') }}" class="bg-violet-700 hover:bg-violet-800 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                Add Product
            </a>
            <a href="{{ route('admin.manage') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                Manage Products
            </a>
            <a href="{{ url('/') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                Back to Store
            </a>
        </div>
    </div>

    <!-- Product Upload Form -->
    <section class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4 text-pink-600">Upload New Product</h2>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-medium">Product Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div>
                <label class="block mb-1 font-medium">Category</label>
                <input type="text" name="category" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-medium">Price (₦)</label>
                <input type="number" name="price" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1 font-medium">Image</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600">Upload</button>
        </form>
    </section>

    <!-- Product List -->
    <section class="max-w-7xl mx-auto mt-12 px-4">
        <h2 class="text-xl font-semibold mb-4 text-pink-600">Manage Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow p-4 relative">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded">
                <h3 class="text-lg font-semibold mt-2">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600">{{ $product->category }}</p>
                <p class="text-sm text-gray-500 mb-2">₦{{ number_format($product->price, 2) }}</p>
                @if($product->is_sold_out)
                    <p class="text-red-500 font-bold text-sm">SOLD OUT</p>
                @endif
                <div class="flex gap-2 mt-3">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="toggle_sold_out" value="true">
                        <button type="submit" class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">
                            {{ $product->is_sold_out ? 'Mark Available' : 'Mark Sold Out' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</body>
</html>
