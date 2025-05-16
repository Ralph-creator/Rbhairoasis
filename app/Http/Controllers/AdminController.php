<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        // Apply both 'auth' and 'admin.only' middleware to all controller methods
        $this->middleware(['auth', 'admin.only']);
    }

    public function index()
    {
        $products = Product::latest()->take(5)->get();
        $totalValue = Product::sum('price');
        $totalProducts = Product::count();
        $featuredItems = Product::where('is_featured', true)->count();
        $categories = Product::distinct('category')->count('category');

        return view('admin.index', compact(
            'products',
            'totalValue',
            'totalProducts',
            'featuredItems',
            'categories'
        ));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function manage()
    {
        $products = Product::latest()->get();
        return view('admin.manage', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable'
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'description' => $validated['description'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'image_path' => $path,
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.create')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        $product->description = $validated['description'];
        $product->category = $validated['category'];
        $product->price = $validated['price'];
        $product->is_featured = $request->has('is_featured');

        $product->save();

        return redirect()->route('admin.manage')->with('success', 'Product updated successfully!');
    }
}
