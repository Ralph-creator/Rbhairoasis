<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
            <div class="space-x-3">
                <a href="{{ route('admin.create') }}"
                   class="bg-violet-700 hover:bg-violet-800 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                    Add Product
                </a>
                <a href="{{ route('admin.manage') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                    Manage Products
                </a>
                <a href="{{ url('/') }}"
                   class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                    Back to Store
                </a>
                                <a href="{{ route('admin.inbox') }}"
                style="background:#2563eb!important; color:#fff!important;"
                class="inline-block px-4 py-2 rounded shadow text-sm font-semibold">
                    Inbox
                </a>


            </div>
        </div>
    </x-slot>
    <br>

        <!-- Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                <p class="text-2xl text-violet-700 font-bold">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Value</h3>
                <p class="text-2xl text-violet-700 font-bold">₦{{ number_format($totalValue) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold text-gray-700">Featured Items</h3>
                <p class="text-2xl text-violet-700 font-bold">{{ $featuredItems }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold text-gray-700">Categories</h3>
                <p class="text-2xl text-violet-700 font-bold">{{ $categories }}</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Product Sales</h4>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Category Distribution</h4>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Recent Products</h4>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $product->description }}</td>
                            <td class="px-4 py-2">{{ $product->category }}</td>
                            <td class="px-4 py-2">₦{{ number_format($product->price) }}</td>
                            <td class="px-4 py-2">{{ $product->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const salesChart = new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(138, 43, 226, 0.7)',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: ['Wigs', 'Bundles', 'Closures', 'Frontals'],
                    datasets: [{
                        label: 'Categories',
                        data: [10, 20, 5, 8],
                        backgroundColor: [
                            '#8A2BE2', '#FFD700', '#FF69B4', '#4B0082'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
    @endpush
</x-app-layout>
