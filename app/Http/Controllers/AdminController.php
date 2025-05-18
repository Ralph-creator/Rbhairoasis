<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Message;            // ✅ use Message model (messages table)
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin.only']);
    }

    /* ---------- Product Dashboard ---------- */

    public function index()
    {
        $products       = Product::latest()->take(5)->get();
        $totalValue     = Product::sum('price');
        $totalProducts  = Product::count();
        $featuredItems  = Product::where('is_featured', true)->count();
        $categories     = Product::distinct('category')->count('category');

        return view('admin.index', compact(
            'products', 'totalValue', 'totalProducts',
            'featuredItems', 'categories'
        ));
    }

    public function create()  { return view('admin.create'); }
    public function manage()  { return view('admin.manage',  ['products' => Product::latest()->get()]); }
    public function edit($id) { return view('admin.edit',    ['product'  => Product::findOrFail($id)]); }

    /* ---------- Product CRUD ---------- */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'  => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured'  => 'nullable'
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'description'  => $validated['description'],
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'image_path'   => $path,
            'is_featured'  => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.create')
                         ->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'description'  => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured'  => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'description'  => $validated['description'],
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'is_featured'  => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.manage')
                         ->with('success', 'Product updated successfully!');
    }

    /* ---------- Inbox ---------- */

    public function inbox()
    {
        $messages = Message::where('is_archived', false)->latest()->get();
        return view('admin.inbox', compact('messages'));
    }

    public function archiveMessage($id)
    {
        Message::where('id', $id)->update(['is_archived' => true]);
        return redirect()->route('admin.inbox')
                         ->with('success', 'Message archived successfully.');
    }

    public function destroyMessage($id)
    {
        Message::destroy($id);
        return redirect()->route('admin.inbox')
                         ->with('success', 'Message deleted successfully.');
            }
            /** @deprecated kept for backward-compat HTML; use destroyMessage */
        public function deleteMessage($id)
        {
            return $this->destroyMessage($id);
        }


    public function archivedMessages()
    {
        $messages = Message::where('is_archived', true)->latest()->get();
        return view('admin.archived', compact('messages'));
    }
}
