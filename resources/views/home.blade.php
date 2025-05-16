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
        .bg-gold { background-color: #FFD700; }
        .text-gold { color: #FFD700; }
    </style>
</head>
<body class="bg-pink-50 text-gray-800">

    <!-- Header -->
    <header class="bg-violet-600 text-white p-4 shadow flex justify-between items-center">
        <div class="flex items-center gap-2">
            <img src="/storage/logo/rbhairs.jpg" alt="RBHairOasis Logo" class="w-10 h-10 rounded-full">
            <h1 class="text-2xl font-bold">RBHairOasis</h1>
        </div>
        <a href="/admin" class="bg-gold text-black px-4 py-2 rounded hover:bg-yellow-400">Admin Dashboard</a>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-10 px-4 bg-gradient-to-r from-pink-100 to-violet-100">
        <h2 class="text-4xl font-bold text-violet-700 mb-2">Luxury Hair. Elegant Look.</h2>
        <p class="text-lg text-gray-700">Shop top quality wigs, bundles & closures with ease.</p>
    </section>

    <!-- About Us -->
    <section class="max-w-4xl mx-auto py-10 px-6 text-center">
        <h3 class="text-2xl font-semibold text-violet-600 mb-4">About Us</h3>
        <p class="text-gray-700">RBHairOasis is your premium destination for luxury hair. We offer a curated selection of wigs, bundles, closures, and more — providing confidence and beauty with every strand.</p>
    </section>

    <!-- Product Grid -->
    <section class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
        @foreach($products as $product)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden relative">
                @if($product->is_sold_out)
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 rounded">Sold Out</span>
                @endif

                <img src="{{ asset('storage/' . $product->image_path) }}"
                     alt="{{ $product->description }}"
                     class="w-full h-64 object-cover">

                <div class="p-4">
                    <h3 class="text-xl font-semibold text-pink-700">{{ $product->description }}</h3>
                    <p class="text-gray-500 text-sm mb-2">{{ $product->category }}</p>
                    <p class="text-lg font-bold mb-3">₦{{ number_format($product->price, 2) }}</p>

                    @if(!$product->is_sold_out)
                                            @php
                        // Build the raw message with real newlines
                        $whatsappRaw = "Hello, I’d like to buy:\n"
                            . "{$product->description} ({$product->category})\n"
                            . "Price: ₦" . number_format($product->price, 2) . "\n"
                            . "Thank you!";
                        // URL-encode it
                        $whatsappText = urlencode($whatsappRaw);
                    @endphp

                                        <a
                        href="https://api.whatsapp.com/send?phone=2349034593525&text={{ $whatsappText }}"
                        class="block text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700"
                        target="_blank" rel="noopener"
                        >
                        Checkout on WhatsApp
                        </a>


                    @endif
                </div>
            </div>
        @endforeach
    </section>

    <!-- Hair Essentials Gallery -->
    <section class="bg-white py-10">
        <h3 class="text-2xl text-center text-violet-700 mb-6">Hair Essentials Gallery</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto px-4">
            @foreach (File::allFiles(public_path('storage/hair-essentials')) as $file)
                <img src="{{ asset('storage/hair-essentials/' . $file->getFilename()) }}"
                     class="rounded-lg shadow-md h-40 w-full object-cover" />
            @endforeach
        </div>
    </section>

    <!-- Reviews -->
    <section class="bg-pink-100 py-10">
        <h3 class="text-2xl text-center text-violet-700 mb-6">What Our Customers Say</h3>
        <div class="max-w-4xl mx-auto px-4 grid gap-6">
            @foreach($reviews as $review)
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-700 italic">"{{ $review->message }}"</p>
                    <p class="text-sm font-semibold text-right text-violet-600 mt-2">- {{ $review->name }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-10 bg-white px-4">
        <h3 class="text-2xl text-center text-violet-700 mb-6">Contact Us</h3>
        <form action="/contact" method="POST" class="max-w-lg mx-auto bg-pink-50 p-6 rounded shadow">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required class="w-full p-2 mb-4 border rounded">
            <input type="email" name="email" placeholder="Your Email" required class="w-full p-2 mb-4 border rounded">
            <textarea name="message" placeholder="Your Message" rows="4" required class="w-full p-2 mb-4 border rounded"></textarea>
            <button type="submit" class="w-full bg-violet-600 text-white py-2 rounded hover:bg-violet-700">Send Message</button>
        </form>
    </section>

    <!-- Newsletter -->
    <section class="py-10 bg-violet-100 px-4 text-center">
        <h3 class="text-xl font-semibold text-violet-800 mb-4">Subscribe to Our Newsletter</h3>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2 max-w-md mx-auto">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required
                   class="flex-1 px-4 py-2 rounded-l-lg border focus:outline-none">
            <button type="submit" class="bg-violet-600 text-white px-6 py-2 rounded-r-lg hover:bg-violet-700">
                Subscribe
            </button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="bg-violet-700 text-white py-6 mt-8">
        <div class="max-w-6xl mx-auto grid sm:grid-cols-3 gap-6 px-4">
            <div>
                <h4 class="font-bold text-lg mb-2">Quick Links</h4>
                <ul class="space-y-1">
                    <li><a href="/" class="hover:underline">Home</a></li>
                    <li><a href="#about" class="hover:underline">About</a></li>
                    <li><a href="#contact" class="hover:underline">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-2">Contact</h4>
                <p>Email: rbhairoasis@gmail.com</p>
                <p>Phone: +234-903-459-3525</p>
                <p>Address: Breadfruit, Balogun Market, Lagos Island</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-2">Follow Us</h4>
                <p>Instagram | Facebook | WhatsApp</p>
            </div>
        </div>
        <p class="text-center mt-6 text-sm">© {{ date('Y') }} RBHairOasis. All rights reserved.</p>
    </footer>

</body>
</html>
