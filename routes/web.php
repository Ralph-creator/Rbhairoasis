<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Review;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page route — pass products and reviews to the view
Route::get('/', function () {
    $products = Product::latest()->get();
    $reviews = Review::latest()->get();
    return view('home', compact('products', 'reviews'));
})->name('home');

// Newsletter subscribe route
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Disable registration
Route::get('/register', function () { abort(404); });

// Dashboard (authenticated users only)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (auth only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
  // Admin routes (auth only)
Route::middleware('auth', 'admin-only')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // changed name from admin.dashboard
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/manage', [AdminController::class, 'manage'])->name('admin.manage');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
// Admin pages
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::post('/admin/product/{id}/soldout', [AdminController::class, 'markAsSoldOut'])->name('admin.soldout');
Route::patch('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');






require __DIR__.'/auth.php';
