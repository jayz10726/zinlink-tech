<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\FeatureController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Routes (Mixed Protection)
Route::prefix('admin')->name('admin.')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
    // Products Management (Create/Edit/Delete) - Temporarily public for testing
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::patch('/products/{product}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/stock', [AdminController::class, 'updateStock'])->name('products.update-stock');
    
    // Reviews Management
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [ReviewController::class, 'delete'])->name('reviews.delete');
    Route::post('/reviews/bulk-action', [ReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
    
    // Hero Images Management
    Route::get('/hero-images', [HeroImageController::class, 'index'])->name('hero-images');
    Route::post('/hero-images', [HeroImageController::class, 'store'])->name('hero-images.store');
    Route::delete('/hero-images/{image}', [HeroImageController::class, 'destroy'])->name('hero-images.destroy');
    Route::get('/hero-images/{image}/edit', [HeroImageController::class, 'edit'])->name('hero-images.edit');
    Route::put('/hero-images/{image}', [HeroImageController::class, 'update'])->name('hero-images.update');
    
    // Features (Why Choose Us) Management
    Route::get('/general-settings', [FeatureController::class, 'index'])->name('features.index');
    Route::post('/features', [FeatureController::class, 'store'])->name('features.store');
    Route::get('/features/{feature}/edit', [FeatureController::class, 'edit'])->name('features.edit');
    Route::put('/features/{feature}', [FeatureController::class, 'update'])->name('features.update');
    Route::delete('/features/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');
    
    // Protected routes (authentication required for modifications)
    Route::middleware('auth')->group(function () {
        // Categories Management
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
        
        // Brands Management
        Route::get('/brands', [AdminController::class, 'brands'])->name('brands');
        Route::get('/brands/create', [AdminController::class, 'createBrand'])->name('brands.create');
        Route::post('/brands', [AdminController::class, 'storeBrand'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [AdminController::class, 'editBrand'])->name('brands.edit');
        Route::put('/brands/{brand}', [AdminController::class, 'updateBrand'])->name('brands.update');
        Route::delete('/brands/{brand}', [AdminController::class, 'deleteBrand'])->name('brands.delete');
    });

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
});

// API route for order creation
Route::post('/api/orders', [\App\Http\Controllers\OrderController::class, 'store']);
