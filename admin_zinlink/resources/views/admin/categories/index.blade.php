@extends('admin.layout')

@section('title', 'Categories - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.categories.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Add Category
            </a>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 capitalize">{{ $category }}</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.categories.delete', $category) }}" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this category? This will delete all products in this category.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Products:</span>
                    <span class="font-semibold">{{ $categoryStats[$category]['count'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Active Products:</span>
                    <span class="font-semibold text-green-600">{{ $categoryStats[$category]['active'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">In Stock:</span>
                    <span class="font-semibold text-blue-600">{{ $categoryStats[$category]['in_stock'] }}</span>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t">
                <a href="{{ route('admin.products') }}?category={{ urlencode($category) }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    View Products →
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($categories->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-tags text-6xl"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2 text-gray-900">No Categories Found</h3>
        <p class="text-gray-600 mb-6">Start by creating your first category to organize your products.</p>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>Create First Category
        </a>
    </div>
    @endif
</div>
@endsection 