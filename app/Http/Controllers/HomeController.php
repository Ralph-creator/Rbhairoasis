<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review; // Remove this line if you don't have a Review model

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // If you don't have a Review model, use: $reviews = [];
        $reviews = Review::all();

        return view('home', compact('products', 'reviews'));
    }
}