<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Home route
Route::get('/', [ProductController::class, 'index'])->name('home');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/', [ProductController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});