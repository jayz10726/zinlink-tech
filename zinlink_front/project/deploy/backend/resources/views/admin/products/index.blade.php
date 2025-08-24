@extends('admin.layout')

@section('title', 'Products - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Products</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.statistics') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-chart-bar mr-2"></i>Statistics
            </a>
            @auth
                <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Add Product
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-lock mr-2"></i>Login to Add Product
                </a>
            @endauth
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search products..." 
                       class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Brand</label>
                <select name="brand" class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Stock Status</label>
                <select name="stock_status" class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">All</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                </select>
            </div>
            
            <div class="md:col-span-2 lg:col-span-4 flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.products') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-gray-800 rounded-lg shadow-sm border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                         class="w-10 h-10 object-cover rounded-lg border">
                                @else
                                    <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-laptop text-blue-400"></i>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-400">{{ $product->model }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-white">{{ $product->brand }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-white">KES {{ number_format($product->price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $product->stock_quantity > 10 ? 'bg-green-900 text-green-200' : 
                                   ($product->stock_quantity > 0 ? 'bg-yellow-900 text-yellow-200' : 'bg-red-900 text-red-200') }}">
                                {{ $product->stock_quantity }} units
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $product->is_active ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @auth
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-400 hover:text-yellow-300">
                                            <i class="fas fa-toggle-{{ $product->is_active ? 'on' : 'off' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.products.delete', $product) }}" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex space-x-2">
                                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-300" title="Login to edit">
                                        <i class="fas fa-lock"></i>
                                    </a>
                                    <span class="text-gray-500 text-xs">Login required</span>
                                </div>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="bg-gray-800 px-4 py-3 border-t border-gray-700 sm:px-6">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 