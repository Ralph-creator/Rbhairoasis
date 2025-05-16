<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Products</h2>
    </x-slot>
    
    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold bg-green-100 border border-green-300 p-4 rounded">
            {{ session('success') }}
        </div>
          <a href="{{ route('admin.index') }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600">Back to Dashboard</a>
                </div>
    @endif

    <div class="max-w-6xl mx-auto py-10">
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-gray-100 text-left text-sm text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="" class="h-16 w-16 object-cover rounded">
            </td>
            <td class="px-4 py-2">{{ $product->description }}</td>
            <td class="px-4 py-2">{{ $product->category }}</td>
            <td class="px-4 py-2">₦{{ number_format($product->price) }}</td>
            <td class="px-4 py-2 space-x-2">
                @if (!$product->is_sold_out)
                    <form action="{{ route('admin.soldout', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Mark this product as sold out?')">
                        @csrf
                        <button class="text-yellow-600 hover:underline" type="submit">Mark as Sold</button>
                    </form>
                @else
                    <span class="text-red-500 font-semibold">Sold Out</span>
                @endif

                <a href="{{ route('admin.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>

                <form action="{{ route('admin.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" type="submit">Delete</button>
                </form>
            </td>
        </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
