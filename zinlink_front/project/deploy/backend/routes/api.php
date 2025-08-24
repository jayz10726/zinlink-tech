<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TeamMemberController;

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

// Public API routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/images/hero', [ImageController::class, 'getHeroImages']);
Route::get('/features', [ImageController::class, 'getFeatures']);
Route::get('/reviews', [ReviewController::class, 'apiIndex']);
Route::get('/team', [TeamMemberController::class, 'apiIndex']);
        
// Admin password verification (public - needed for frontend admin access)
Route::post('/verify-admin', function (Request $request) {
    $password = $request->input('password');
        
    // Check if password matches the admin user's password
    $adminUser = \App\Models\User::where('email', 'admin@zinlinktech.com')->first();
    
    if ($adminUser && \Illuminate\Support\Facades\Hash::check($password, $adminUser->password)) {
        return response()->json(['success' => true, 'message' => 'Password verified']);
    }
    
    return response()->json(['success' => false, 'message' => 'Invalid password'], 401);
});

// Protected API routes (require authentication)
Route::middleware('auth')->group(function () {
    // Add protected API routes here if needed
}); 