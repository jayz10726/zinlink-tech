<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HeroImageController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// All Admin Routes - Protected with Authentication
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products Management
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::patch('/products/{product}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/stock', [AdminController::class, 'updateStock'])->name('products.update-stock');
    
    // Statistics
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
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

    // Orders Management
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    
    // Team Management
    Route::get('/team', [TeamMemberController::class, 'index'])->name('team.index');
    Route::post('/team', [TeamMemberController::class, 'store'])->name('team.store');
    Route::post('/team/{teamMember}', [TeamMemberController::class, 'update'])->name('team.update');
    Route::delete('/team/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team.destroy');
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/change-password', [UserController::class, 'showChangePassword'])->name('users.change-password');
    Route::post('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password.store');
    Route::get('/change-password', [UserController::class, 'showChangeOwnPassword'])->name('users.change-own-password');
    Route::post('/change-password', [UserController::class, 'changeOwnPassword'])->name('users.change-own-password.store');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/logout', [UserController::class, 'logoutUser'])->name('users.logout');
    Route::post('/users/logout-all', [UserController::class, 'logoutAllUsers'])->name('users.logout-all');
});

// API route for order creation (public - needed for frontend checkout)
Route::post('/api/orders', [\App\Http\Controllers\OrderController::class, 'store']);

// API route for team members (public - needed for frontend About page)
Route::get('/api/team', [TeamMemberController::class, 'apiIndex']);
