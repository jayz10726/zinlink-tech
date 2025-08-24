<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Advanced search with multiple filters
     */
    public function search(Request $request): JsonResponse
    {
        $query = Product::query();

        // Search term
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('model', 'like', "%{$searchTerm}%")
                  ->orWhere('processor', 'like', "%{$searchTerm}%")
                  ->orWhere('category', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Brand filter
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        // Price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock filter
        if ($request->has('in_stock')) {
            if ($request->boolean('in_stock')) {
                $query->inStock();
            } else {
                $query->outOfStock();
            }
        }

        // Condition filter
        if ($request->has('condition')) {
            $query->where('condition', $request->condition);
        }

        // Only active products
        $query->active();

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSortFields = ['name', 'price', 'created_at', 'stock_quantity', 'brand'];
        
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        // Get search suggestions
        $suggestions = $this->getSearchSuggestions($request->get('q', ''));

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
            'suggestions' => $suggestions,
            'filters' => [
                'search' => $request->get('q'),
                'category' => $request->get('category'),
                'brand' => $request->get('brand'),
                'min_price' => $request->get('min_price'),
                'max_price' => $request->get('max_price'),
                'in_stock' => $request->get('in_stock'),
                'condition' => $request->get('condition'),
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ]
        ]);
    }

    /**
     * Get search suggestions
     */
    private function getSearchSuggestions(string $query): array
    {
        if (empty($query)) {
            return [];
        }

        $suggestions = [];

        // Brand suggestions
        $brands = Product::where('brand', 'like', "%{$query}%")
            ->distinct()
            ->pluck('brand')
            ->take(5);

        // Category suggestions
        $categories = Product::where('category', 'like', "%{$query}%")
            ->distinct()
            ->pluck('category')
            ->take(5);

        // Model suggestions
        $models = Product::where('model', 'like', "%{$query}%")
            ->distinct()
            ->pluck('model')
            ->take(5);

        return [
            'brands' => $brands,
            'categories' => $categories,
            'models' => $models,
        ];
    }

    /**
     * Get search analytics
     */
    public function analytics(): JsonResponse
    {
        $analytics = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'categories_distribution' => Product::select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->get(),
            'brands_distribution' => Product::select('brand', DB::raw('count(*) as count'))
                ->groupBy('brand')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'price_ranges' => [
                'under_50k' => Product::where('price', '<', 50000)->count(),
                '50k_to_100k' => Product::whereBetween('price', [50000, 100000])->count(),
                '100k_to_200k' => Product::whereBetween('price', [100000, 200000])->count(),
                '200k_to_500k' => Product::whereBetween('price', [200000, 500000])->count(),
                'over_500k' => Product::where('price', '>', 500000)->count(),
            ],
            'stock_status' => [
                'in_stock' => Product::inStock()->count(),
                'out_of_stock' => Product::outOfStock()->count(),
                'low_stock' => Product::lowStock()->count(),
            ],
            'recent_additions' => Product::latest()->limit(5)->get(['id', 'name', 'brand', 'price', 'created_at']),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get popular searches (placeholder for future implementation)
     */
    public function popularSearches(): JsonResponse
    {
        $popularSearches = [
            'gaming laptop',
            'macbook',
            'dell xps',
            'lenovo thinkpad',
            'asus rog',
            'ssd',
            'wifi router',
            'cctv camera',
        ];

        return response()->json([
            'success' => true,
            'data' => $popularSearches
        ]);
    }
} 