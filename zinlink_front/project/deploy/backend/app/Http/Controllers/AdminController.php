<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'in_stock_products' => Product::inStock()->count(),
            'out_of_stock_products' => Product::where('stock_quantity', 0)->count(),
            'total_value' => Product::sum('price'),
            'low_stock_products' => Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
        ];

        // Get recent products
        $recent_products = Product::latest()->take(5)->get();

        // Get products by brand
        $products_by_brand = Product::select('brand', DB::raw('count(*) as count'))
            ->groupBy('brand')
            ->get();

        // Get low stock products
        $low_stock_products = Product::where('stock_quantity', '<=', 5)
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_products', 'products_by_brand', 'low_stock_products'));
    }

    /**
     * Show products management page
     */
    public function products(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        // Filter by stock status
        if ($request->has('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->inStock();
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0);
            }
        }

        // Filter by active status
        if ($request->has('active_status')) {
            if ($request->active_status === 'active') {
                $query->active();
            } elseif ($request->active_status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(15);
        $brands = Product::distinct('brand')->pluck('brand');
        $categories = Product::distinct('category')->pluck('category');

        return view('admin.products.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show create product form
     */
    public function createProduct()
    {
        $brands = Product::distinct('brand')->pluck('brand');
        $categories = Product::distinct('category')->pluck('category');
        
        return view('admin.products.create', compact('brands', 'categories'));
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request)
    {
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    /**
     * Show edit product form
     */
    public function editProduct(Product $product)
    {
        $brands = Product::distinct('brand')->pluck('brand');
        $categories = Product::distinct('category')->pluck('category');
        
        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, Product $product)
    {
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
                if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                    unlink(storage_path('app/public/' . $oldImagePath));
                }
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product active status
     */
    public function toggleProductStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        
        $status = $product->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.products')->with('success', "Product {$status} successfully!");
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update(['stock_quantity' => $request->stock_quantity]);

        return redirect()->route('admin.products')->with('success', 'Stock updated successfully!');
    }

    /**
     * Show product statistics
     */
    public function statistics()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'in_stock_products' => Product::inStock()->count(),
            'out_of_stock_products' => Product::where('stock_quantity', 0)->count(),
            'total_value' => Product::sum('price'),
            'low_stock_products' => Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
        ];

        // Products by brand
        $products_by_brand = Product::select('brand', DB::raw('count(*) as count'))
            ->groupBy('brand')
            ->orderBy('count', 'desc')
            ->get();

        // Products by category
        $products_by_category = Product::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        // Products by condition
        $products_by_condition = Product::select('condition', DB::raw('count(*) as count'))
            ->groupBy('condition')
            ->orderBy('count', 'desc')
            ->get();

        // Price range distribution
        $price_ranges = [
            'Under KES 50,000' => Product::where('price', '<', 50000)->count(),
            'KES 50,000 - 100,000' => Product::whereBetween('price', [50000, 100000])->count(),
            'KES 100,000 - 150,000' => Product::whereBetween('price', [100000, 150000])->count(),
            'KES 150,000 - 200,000' => Product::whereBetween('price', [150000, 200000])->count(),
            'Over KES 200,000' => Product::where('price', '>', 200000)->count(),
        ];

        return view('admin.statistics', compact('stats', 'products_by_brand', 'products_by_category', 'products_by_condition', 'price_ranges'));
    }

    /**
     * Show categories management page
     */
    public function categories()
    {
        $categories = Product::distinct('category')->pluck('category')->filter();
        $categoryStats = [];
        
        foreach ($categories as $category) {
            $categoryStats[$category] = [
                'count' => Product::where('category', $category)->count(),
                'active' => Product::where('category', $category)->where('is_active', true)->count(),
                'in_stock' => Product::where('category', $category)->where('stock_quantity', '>', 0)->count(),
            ];
        }

        return view('admin.categories.index', compact('categories', 'categoryStats'));
    }

    /**
     * Show create category form
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,category',
            'description' => 'nullable|string',
        ]);

        // For now, we'll create a sample product with this category
        // In a real app, you'd have a separate categories table
        Product::create([
            'name' => 'Sample Product - ' . $request->name,
            'description' => $request->description ?? 'Sample product for category: ' . $request->name,
            'price' => 0,
            'brand' => 'Sample',
            'model' => 'Sample',
            'category' => $request->name,
            'stock_quantity' => 0,
            'is_active' => false,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    /**
     * Show edit category form
     */
    public function editCategory($category)
    {
        $products = Product::where('category', $category)->get();
        return view('admin.categories.edit', compact('category', 'products'));
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update all products with this category
        Product::where('category', $category)->update(['category' => $request->name]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }

    /**
     * Delete category
     */
    public function deleteCategory($category)
    {
        // Delete all products in this category
        Product::where('category', $category)->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }

    /**
     * Show brands management page
     */
    public function brands()
    {
        $brands = Product::distinct('brand')->pluck('brand')->filter();
        $brandStats = [];
        
        foreach ($brands as $brand) {
            $brandStats[$brand] = [
                'count' => Product::where('brand', $brand)->count(),
                'active' => Product::where('brand', $brand)->where('is_active', true)->count(),
                'in_stock' => Product::where('brand', $brand)->where('stock_quantity', '>', 0)->count(),
            ];
        }

        return view('admin.brands.index', compact('brands', 'brandStats'));
    }

    /**
     * Show create brand form
     */
    public function createBrand()
    {
        return view('admin.brands.create');
    }

    /**
     * Store new brand
     */
    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,brand',
            'description' => 'nullable|string',
        ]);

        // For now, we'll create a sample product with this brand
        // In a real app, you'd have a separate brands table
        Product::create([
            'name' => 'Sample Product - ' . $request->name,
            'description' => $request->description ?? 'Sample product for brand: ' . $request->name,
            'price' => 0,
            'brand' => $request->name,
            'model' => 'Sample',
            'category' => 'Sample',
            'stock_quantity' => 0,
            'is_active' => false,
        ]);

        return redirect()->route('admin.brands')->with('success', 'Brand created successfully!');
    }

    /**
     * Show edit brand form
     */
    public function editBrand($brand)
    {
        $products = Product::where('brand', $brand)->get();
        return view('admin.brands.edit', compact('brand', 'products'));
    }

    /**
     * Update brand
     */
    public function updateBrand(Request $request, $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update all products with this brand
        Product::where('brand', $brand)->update(['brand' => $request->name]);

        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully!');
    }

    /**
     * Delete brand
     */
    public function deleteBrand($brand)
    {
        // Delete all products in this brand
        Product::where('brand', $brand)->delete();

        return redirect()->route('admin.brands')->with('success', 'Brand deleted successfully!');
    }
}
