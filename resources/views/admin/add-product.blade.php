<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Product</h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-6">
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-10">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Description</label>
                    <input type="text" name="description" class="w-full border rounded px-3 py-2" required>
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
            </div>
            <div class="mt-4 flex items-center">
                <input type="checkbox" name="is_featured" class="mr-2">
                <label class="font-medium">Mark as Featured</label>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-violet-700 text-white px-6 py-2 rounded hover:bg-violet-800">Add Product</button>
            </div>
        </form>
    </div>
</x-app-layout>
