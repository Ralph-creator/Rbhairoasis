<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\MessageController;
use App\Models\Product;
use App\Models\Review;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Contact form
Route::post('/contact', [MessageController::class, 'store'])->name('contact.send');

// Home page
Route::get('/', function () {
    $products = Product::latest()->get();
    $reviews = Review::latest()->get();
    return view('home', compact('products', 'reviews'));
})->name('home');

// Newsletter
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Disable registration
Route::get('/register', fn() => abort(404));

// Dashboard (authenticated)
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & product management
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::get('/manage', [AdminController::class, 'manage'])->name('manage');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('/product/{id}/soldout', [AdminController::class, 'markAsSoldOut'])->name('soldout');

            Route::middleware(['auth', 'is_admin'])->group(function () {
            Route::get('/admin/inbox', [AdminController::class, 'inbox'])->name('admin.inbox');
        });


    // Inbox
    Route::get('/inbox', [AdminController::class, 'inbox'])->name('inbox');
    Route::get('/inbox/archived', [AdminController::class, 'archivedMessages'])->name('archived');
    Route::post('/inbox/{id}/archive', [AdminController::class, 'archiveMessage'])->name('messages.archive');
    Route::delete('/inbox/{id}', [AdminController::class, 'deleteMessage'])->name('messages.destroy');
});

require __DIR__.'/auth.php';
