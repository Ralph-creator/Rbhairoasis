<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBHairOasis</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-pink-50">
    <!-- Header -->
    <header class="bg-pink-500 text-white shadow p-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <img src="/storage/logo/rbhairs.jpg" alt="RBHairOasis Logo" class="w-10 h-10 rounded-full">
            <h1 class="text-2xl font-bold">RBHairOasis</h1>
        </div>
        <div>
            <a href="/admin" class="bg-white text-pink-500 px-4 py-2 rounded hover:bg-pink-100">Admin Dashboard</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="text-center py-12 px-4">
        <h2 class="text-4xl font-semibold text-pink-600 mb-2">Welcome to RBHairOasis</h2>
        <p class="text-gray-600 text-lg">Luxury Hair Collection - Wigs, Bundles, Closures & More</p>
    </section>

    <!-- Product Grid -->
    <section class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
        @foreach($products as $product)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden relative">
            @if($product->is_sold_out)
                <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 rounded">Sold Out</span>
            @endif
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-semibold text-pink-700">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mb-2">{{ $product->category }}</p>
                <p class="text-lg font-bold mb-3">₦{{ number_format($product->price, 2) }}</p>
                @if(!$product->is_sold_out)
                <a href="https://wa.me/message/4TIY7CJ5LZK3M1?text=I'm%20interested%20in%20buying:%20{{ urlencode($product->name) }}%20for%20₦{{ number_format($product->price, 2) }}"
                   class="block text-center bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                    Checkout on WhatsApp
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </section>
