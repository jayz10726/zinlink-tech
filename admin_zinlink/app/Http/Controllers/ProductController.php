<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by brand
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by condition
        if ($request->has('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by stock availability
        if ($request->has('in_stock')) {
            if ($request->boolean('in_stock')) {
                $query->inStock();
            } else {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('processor', 'like', "%{$search}%");
            });
        }

        // Sort products
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSortFields = ['name', 'price', 'created_at', 'stock_quantity', 'brand'];
        
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Only show active products by default
        if (!$request->has('include_inactive')) {
            $query->active();
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'filters' => [
                'category' => $request->get('category'),
                'brand' => $request->get('brand'),
                'condition' => $request->get('condition'),
                'min_price' => $request->get('min_price'),
                'max_price' => $request->get('max_price'),
                'in_stock' => $request->get('in_stock'),
                'search' => $request->get('search'),
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ]
        ]);
    }

    /**
     * Get featured products
     */
    public function featured(): JsonResponse
    {
        $featuredProducts = Product::active()
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $featuredProducts
        ]);
    }

    /**
     * Get products by category
     */
    public function byCategory(Request $request, string $category): JsonResponse
    {
        $query = Product::where('category', $category)->active();

        // Apply additional filters
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
            'category' => $category
        ]);
    }

    /**
     * Get available categories
     */
    public function categories(): JsonResponse
    {
        $categories = Product::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get available brands
     */
    public function brands(): JsonResponse
    {
        $brands = Product::active()
            ->select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->pluck('brand');

        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'processor' => 'nullable|string|max:255',
                'ram' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'display' => 'nullable|string|max:255',
                'graphics' => 'nullable|string|max:255',
                'operating_system' => 'nullable|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'image_url' => 'nullable|url',
                'category' => 'nullable|string|max:255',
                'condition' => 'nullable|in:new,used,refurbished',
                'warranty' => 'nullable|string|max:255',
                'is_active' => 'boolean',
                // CCTV Camera fields
                'resolution' => 'nullable|string|max:255',
                'night_vision' => 'nullable|in:yes,no',
                'weatherproof' => 'nullable|in:indoor,outdoor,both',
                'power_supply' => 'nullable|string|max:255',
                'viewing_angle' => 'nullable|string|max:255',
                'storage_type' => 'nullable|string|max:255',
                // Charger fields
                'output_voltage' => 'nullable|string|max:255',
                'output_current' => 'nullable|string|max:255',
                'connector_type' => 'nullable|string|max:255',
                'compatible_brands' => 'nullable|string|max:255',
                // Hard Disk fields
                'capacity' => 'nullable|string|max:255',
                'disk_type' => 'nullable|in:hdd,ssd,nvme',
                'interface' => 'nullable|string|max:255',
                'speed' => 'nullable|string|max:255',
                // WiFi Router fields
                'wifi_standard' => 'nullable|string|max:255',
                'wifi_speed' => 'nullable|string|max:255',
                'coverage' => 'nullable|string|max:255',
                'antennas' => 'nullable|string|max:255',
                // Accessories fields
                'material' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255',
                'compatibility' => 'nullable|string|max:255',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image_url'] = '/storage/' . $imagePath;
            }

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified product
     */
    public function show(Product $product): JsonResponse
    {
        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found or inactive'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'price' => 'sometimes|required|numeric|min:0',
                'brand' => 'sometimes|required|string|max:255',
                'model' => 'sometimes|required|string|max:255',
                'processor' => 'nullable|string|max:255',
                'ram' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'display' => 'nullable|string|max:255',
                'graphics' => 'nullable|string|max:255',
                'operating_system' => 'nullable|string|max:255',
                'stock_quantity' => 'sometimes|required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'image_url' => 'nullable|url',
                'category' => 'nullable|string|max:255',
                'condition' => 'nullable|in:new,used,refurbished',
                'warranty' => 'nullable|string|max:255',
                'is_active' => 'boolean',
                // CCTV Camera fields
                'resolution' => 'nullable|string|max:255',
                'night_vision' => 'nullable|in:yes,no',
                'weatherproof' => 'nullable|in:indoor,outdoor,both',
                'power_supply' => 'nullable|string|max:255',
                'viewing_angle' => 'nullable|string|max:255',
                'storage_type' => 'nullable|string|max:255',
                // Charger fields
                'output_voltage' => 'nullable|string|max:255',
                'output_current' => 'nullable|string|max:255',
                'connector_type' => 'nullable|string|max:255',
                'compatible_brands' => 'nullable|string|max:255',
                // Hard Disk fields
                'capacity' => 'nullable|string|max:255',
                'disk_type' => 'nullable|in:hdd,ssd,nvme',
                'interface' => 'nullable|string|max:255',
                'speed' => 'nullable|string|max:255',
                // WiFi Router fields
                'wifi_standard' => 'nullable|string|max:255',
                'wifi_speed' => 'nullable|string|max:255',
                'coverage' => 'nullable|string|max:255',
                'antennas' => 'nullable|string|max:255',
                // Accessories fields
                'material' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255',
                'compatibility' => 'nullable|string|max:255',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
                    $oldImagePath = str_replace('/storage/', '', $product->image_url);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
                
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image_url'] = '/storage/' . $imagePath;
            }

            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product): JsonResponse
    {
        // Delete associated image
        if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
            $imagePath = str_replace('/storage/', '', $product->image_url);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get product statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'in_stock_products' => Product::inStock()->count(),
            'out_of_stock_products' => Product::where('stock_quantity', '<=', 0)->count(),
            'total_value' => Product::sum('price'),
            'categories_count' => Product::select('category')->distinct()->count(),
            'brands_count' => Product::select('brand')->distinct()->count(),
            'recent_products' => Product::latest()->limit(5)->get(),
            'low_stock_products' => Product::where('stock_quantity', '>', 0)
                ->where('stock_quantity', '<=', 5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Product $product): JsonResponse
    {
        try {
            $validated = $request->validate([
                'stock_quantity' => 'required|integer|min:0',
                'operation' => 'nullable|in:add,subtract,set'
            ]);

            $operation = $validated['operation'] ?? 'set';
            $quantity = $validated['stock_quantity'];

            switch ($operation) {
                case 'add':
                    $product->stock_quantity += $quantity;
                    break;
                case 'subtract':
                    $product->stock_quantity = max(0, $product->stock_quantity - $quantity);
                    break;
                case 'set':
                default:
                    $product->stock_quantity = $quantity;
                    break;
            }

            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully',
                'data' => [
                    'product_id' => $product->id,
                    'new_stock_quantity' => $product->stock_quantity,
                    'is_in_stock' => $product->isInStock()
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'exists:products,id',
                'updates' => 'required|array',
                'updates.is_active' => 'nullable|boolean',
                'updates.category' => 'nullable|string|max:255',
                'updates.condition' => 'nullable|in:new,used,refurbished',
            ]);

            $updatedCount = Product::whereIn('id', $validated['product_ids'])
                ->update($validated['updates']);

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} products",
                'updated_count' => $updatedCount
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'exists:products,id',
            ]);

            $products = Product::whereIn('id', $validated['product_ids'])->get();

            // Delete associated images
            foreach ($products as $product) {
                if ($product->image_url && !str_starts_with($product->image_url, 'http')) {
                    $imagePath = str_replace('/storage/', '', $product->image_url);
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            $deletedCount = Product::whereIn('id', $validated['product_ids'])->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} products",
                'deleted_count' => $deletedCount
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
