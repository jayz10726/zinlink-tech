@extends('admin.layout')

@section('title', 'Dashboard - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.products') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-box mr-2"></i>Manage Products
            </a>
            <a href="{{ route('admin.statistics') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-chart-bar mr-2"></i>View Statistics
            </a>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add Product
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Products</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-warehouse text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">In Stock</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['in_stock_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['low_stock_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Value</p>
                    <p class="text-2xl font-bold text-gray-900">KES {{ number_format($stats['total_value'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Products -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Products</h3>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach($recent_products as $product)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="w-10 h-10 object-cover rounded-lg border">
                        @else
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-laptop text-blue-600"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $product->brand }} • KES {{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Products by Brand -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Products by Brand</h3>
                <a href="{{ route('admin.statistics') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View Details <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($products_by_brand as $brand)
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">{{ $brand->brand }}</span>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $brand->count }} products
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($low_stock_products->count() > 0)
    <div class="bg-white p-6 rounded-lg shadow-sm border border-yellow-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                Low Stock Alert
            </h3>
            <a href="{{ route('admin.products') }}?stock_status=low_stock" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All Low Stock <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($low_stock_products as $product)
            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-sm text-gray-600">{{ $product->brand }}</p>
                    </div>
                    <span class="text-yellow-800 font-medium">{{ $product->stock_quantity }} left</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 