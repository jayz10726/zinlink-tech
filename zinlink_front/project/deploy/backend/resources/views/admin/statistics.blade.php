@extends('admin.layout')

@section('title', 'Statistics - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Statistics</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-box mr-2"></i>Manage Products
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                    <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['out_of_stock_products'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Products by Brand -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Products by Brand</h3>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View Products <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($products_by_brand as $brand)
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">{{ $brand->brand }}</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($brand->count / $stats['total_products']) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $brand->count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Products by Category -->
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Products by Category</h3>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View Products <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($products_by_category as $category)
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">{{ ucfirst($category->category) }}</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($category->count / $stats['total_products']) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $category->count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Price Range Distribution -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Range Distribution</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($price_ranges as $range => $count)
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-900">{{ $range }}</p>
                <p class="text-2xl font-bold text-blue-600">{{ $count }}</p>
                <p class="text-xs text-gray-500">products</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Products by Condition -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Products by Condition</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products_by_condition as $condition)
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center
                    {{ $condition->condition == 'new' ? 'bg-green-100 text-green-600' : 
                       ($condition->condition == 'used' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600') }}">
                    <i class="fas fa-{{ $condition->condition == 'new' ? 'star' : ($condition->condition == 'used' ? 'clock' : 'tools') }} text-xl"></i>
                </div>
                <p class="text-lg font-semibold text-gray-900">{{ ucfirst($condition->condition) }}</p>
                <p class="text-2xl font-bold text-gray-700">{{ $condition->count }}</p>
                <p class="text-sm text-gray-500">products</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 