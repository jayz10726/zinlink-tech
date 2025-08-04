<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ImageController;
use App\Models\Feature;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product Management API Routes
Route::prefix('products')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/category/{category}', [ProductController::class, 'byCategory']);
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/brands', [ProductController::class, 'brands']);
    Route::get('/stats', [ProductController::class, 'stats']);
    Route::get('/{product}', [ProductController::class, 'show']);
    
    // Protected routes (authentication required)
    Route::middleware('auth')->group(function () {
        // Create new product
        Route::post('/', [ProductController::class, 'store']);
        
        // Update product
        Route::put('/{product}', [ProductController::class, 'update']);
        Route::patch('/{product}', [ProductController::class, 'update']);
        
        // Delete product
        Route::delete('/{product}', [ProductController::class, 'destroy']);
        
        // Update stock quantity
        Route::patch('/{product}/stock', [ProductController::class, 'updateStock']);
        
        // Bulk operations
        Route::post('/bulk-update', [ProductController::class, 'bulkUpdate']);
        Route::post('/bulk-delete', [ProductController::class, 'bulkDelete']);
    });
});

// Image Management API Routes
Route::prefix('images')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [ImageController::class, 'index']);
    Route::get('/category/{category}', [ImageController::class, 'byCategory']);
    Route::get('/hero', [ImageController::class, 'heroImages']);
    Route::get('/{image}', [ImageController::class, 'show']);
    
    // Protected routes (authentication required)
    Route::middleware('auth')->group(function () {
        // Create new image
        Route::post('/', [ImageController::class, 'store']);
        
        // Update image
        Route::put('/{image}', [ImageController::class, 'update']);
        Route::patch('/{image}', [ImageController::class, 'update']);
        
        // Delete image
        Route::delete('/{image}', [ImageController::class, 'destroy']);
        
        // Update image order
        Route::patch('/order', [ImageController::class, 'updateOrder']);
    });
});

// Search API Routes
Route::prefix('search')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [SearchController::class, 'search']);
    Route::get('/popular', [SearchController::class, 'popularSearches']);
    
    // Protected routes (authentication required)
    Route::middleware('auth')->group(function () {
        // Search analytics
        Route::get('/analytics', [SearchController::class, 'analytics']);
    });
});

// Reviews API Routes
Route::prefix('reviews')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [ReviewController::class, 'apiIndex']);
    Route::post('/', [ReviewController::class, 'store']);
    Route::get('/stats', [ReviewController::class, 'stats']);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'message' => 'zinlink tech API is running',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});

// API Documentation endpoint
Route::get('/docs', function () {
    return response()->json([
        'message' => 'zinlink tech API Documentation',
        'endpoints' => [
            'GET /api/health' => 'Health check',
            'GET /api/products' => 'Get all products with filtering',
            'GET /api/products/featured' => 'Get featured products',
            'GET /api/products/categories' => 'Get available categories',
            'GET /api/products/brands' => 'Get available brands',
            'GET /api/products/stats' => 'Get product statistics',
            'GET /api/products/{id}' => 'Get single product',
            'POST /api/products' => 'Create new product',
            'PUT /api/products/{id}' => 'Update product',
            'DELETE /api/products/{id}' => 'Delete product',
            'PATCH /api/products/{id}/stock' => 'Update stock quantity',
            'POST /api/products/bulk-update' => 'Bulk update products',
            'POST /api/products/bulk-delete' => 'Bulk delete products',
            'GET /api/images' => 'Get all images with filtering',
            'GET /api/images/hero' => 'Get hero carousel images',
            'GET /api/images/category/{category}' => 'Get images by category',
            'GET /api/images/{id}' => 'Get single image',
            'POST /api/images' => 'Create new image',
            'PUT /api/images/{id}' => 'Update image',
            'DELETE /api/images/{id}' => 'Delete image',
            'PATCH /api/images/order' => 'Update image order',
            'GET /api/search' => 'Advanced search with filters',
            'GET /api/search/analytics' => 'Search analytics',
            'GET /api/search/popular' => 'Popular searches',
        ],
        'filters' => [
            'category' => 'Filter by category',
            'brand' => 'Filter by brand',
            'condition' => 'Filter by condition (new, used, refurbished)',
            'min_price' => 'Minimum price filter',
            'max_price' => 'Maximum price filter',
            'in_stock' => 'Filter by stock availability (true/false)',
            'search' => 'Search in name, description, brand, model, processor',
            'sort_by' => 'Sort by (name, price, created_at, stock_quantity, brand)',
            'sort_order' => 'Sort order (asc, desc)',
            'per_page' => 'Items per page (default: 15)',
        ]
    ]);
});

// Features API Route
Route::get('/features', function () {
    $features = Feature::orderBy('sort_order')->get();
    return response()->json([
        'success' => true,
        'data' => $features
    ]);
}); 