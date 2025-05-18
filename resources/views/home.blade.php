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
            <!-- Promo / Info Banner  -->
        <div class="relative overflow-hidden bg-violet-700 text-white">
            <div class="animate-marquee whitespace-nowrap py-2">
                <span class="mx-4">You can take a screenshot of the products you want and send it to the admin WhatsApp on +234-903-459-3525</span>
                <span class="mx-4">You can take a screenshot of the products you want and send it to the admin WhatsApp on +234-903-459-3525</span>
            </div>
        </div>

        <!-- Animation style -->
        <style>
        @keyframes marquee {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            display:inline-block;
            animation: marquee 25s linear infinite;
        }
        </style>


    <!-- Hero Section -->
    <section class="text-center py-10 px-4 bg-gradient-to-r from-pink-100 to-violet-100">
        <h2 class="text-4xl font-bold text-violet-700 mb-2">Luxury Hair. Elegant Look.</h2>
        <p class="text-lg text-gray-700">Shop top quality wigs, bundles & closures with ease.</p>
    </section>

        <!-- About Us -->
    <section id="about" class="max-w-4xl mx-auto py-10 px-6 text-center">
        <h3 class="text-2xl font-semibold text-violet-600 mb-4">About Us</h3>
        <p class="text-gray-700">
            RBHairOasis is your premium destination for luxury hair…
        </p>
    </section>
    <!-- Product Grid -->
    <section id="product-grid" class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
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

                    @php
                        $whatsappRaw = "Hello, I’d like to buy:\n"
                            . "{$product->description} ({$product->category})\n"
                            . "Price: ₦" . number_format($product->price, 2) . "\n"
                            . "Thank you!";
                        $whatsappText = urlencode($whatsappRaw);
                    @endphp

                    <div class="flex items-center justify-between mt-3">
                        <a href="https://api.whatsapp.com/send?phone=2349034593525&text={{ $whatsappText }}"
                           class="flex-1 text-center bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700 text-sm"
                           target="_blank" rel="noopener">
                            Checkout on WhatsApp
                        </a>

                        <!-- Wishlist button -->
                        <button type="button"
                                class="wishlist-btn ml-3 text-gray-400 hover:text-pink-600"
                                data-id="{{ $product->id }}"
                                title="Add to Wishlist">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                         2 6 4 4 6.5 4c1.74 0 3.41 1.01 4.5 2.09
                                         C12.09 5.01 13.76 4 15.5 4 18 4 20 6 20 8.5
                                         c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
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
   <section id="contact" class="py-10 bg-white px-4">
    <h3 class="text-2xl text-center text-violet-700 mb-6">Contact Us</h3>

        <form action="{{ route('contact.send') }}" method="POST" class="max-w-2xl mx-auto space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Your Name" required
                       class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-500">
                <input type="email" name="email" placeholder="Your Email" required
                       class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>

            <input type="text" name="subject" placeholder="Subject" required
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-500">

            <textarea name="message" placeholder="Your Message" rows="5" required
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-500"></textarea>

            <button type="submit"
                    class="bg-violet-600 text-white px-6 py-2 rounded hover:bg-violet-700 transition duration-200">
                Send Message
            </button>
        </form>

        @if (session('success'))
            <p class="text-green-600 mt-4 text-center">{{ session('success') }}</p>
        @endif
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
                <ul class="space-y-1">
                    <li>
                        <a href="https://instagram.com/rb_hair_oasis" target="_blank" rel="noopener"
                        class="hover:underline">Instagram</a>  {{-- ← put Instagram URL --}}
                    </li>
                    <li>
                        <a href="#" target="_blank" rel="noopener"
                        class="hover:underline">Facebook</a>    {{-- ← Facebook page URL --}}
                    </li>
                    <li>
                        <a href="https://wa.me/2349034593525" target="_blank" rel="noopener"
                        class="hover:underline">WhatsApp</a>    {{-- ← WhatsApp chat link --}}
                    </li>
                </ul>
            </div>

        </div>
        <p class="text-center mt-6 text-sm">© {{ date('Y') }} RBHairOasis. All rights reserved.</p>
    </footer>

    <!-- Promo Pop-Up -->
    <div id="promoModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg max-w-sm p-6 text-center shadow-lg">
            <h3 class="text-2xl font-bold text-violet-700 mb-2">May Promo!</h3>
            <p class="text-gray-700 mb-4">
                Get <span class="font-semibold">10% off</span> all wigs.
                Use code <span class="font-mono bg-gray-100 px-2 py-1 rounded">RBMAY10</span>
            </p>
            <button id="promoClose"
                    class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded w-full">
                Shop Now
            </button>
        </div>
    </div>

    <!-- Wishlist Toast -->
    <div id="toast"
         class="fixed bottom-4 right-4 bg-violet-600 text-white px-4 py-2 rounded shadow-lg hidden z-50">
        Added to wishlist!
    </div>

    <!-- Inline scripts -->
    <script>
    /* Promo pop-up */
    document.addEventListener('DOMContentLoaded', () => {
        const KEY   = 'promoDismissedMay25';
        const modal = document.getElementById('promoModal');
        const close = document.getElementById('promoClose');
        if (modal && close && !localStorage.getItem(KEY)) {
            modal.classList.remove('hidden');
            close.addEventListener('click', () => {
                modal.classList.add('hidden');
                localStorage.setItem(KEY, '1');
                document.getElementById('product-grid')?.scrollIntoView({behavior:'smooth'});
            });
        }
    });

    /* Wishlist */
    document.addEventListener('DOMContentLoaded', () => {
        const TOAST = document.getElementById('toast');
        const KEY   = 'rbWishlist';
        const btns  = document.querySelectorAll('.wishlist-btn');
        const list  = new Set(JSON.parse(localStorage.getItem(KEY) || '[]'));

        btns.forEach(btn => {
            if (list.has(btn.dataset.id)) {
                btn.classList.replace('text-gray-400', 'text-pink-600');
            }
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                if (list.has(id)) return;
                list.add(id);
                localStorage.setItem(KEY, JSON.stringify([...list]));
                btn.classList.replace('text-gray-400', 'text-pink-600');
                TOAST.classList.remove('hidden');
                setTimeout(() => TOAST.classList.add('hidden'), 2000);
            });
        });
    });
    </script>

</body>
</html>
