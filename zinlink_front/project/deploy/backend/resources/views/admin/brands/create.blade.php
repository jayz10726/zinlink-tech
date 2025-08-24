@extends('admin.layout')

@section('title', 'Add Brand - LaptopHub Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add New Brand</h1>
        <a href="{{ route('admin.brands') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>Back to Brands
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form method="POST" action="{{ route('admin.brands.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g., Apple, Dell, HP, Lenovo, ASUS"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" 
                          placeholder="Describe this brand..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-1">Brand Information</h4>
                        <p class="text-sm text-blue-700">
                            Brands help organize your products by manufacturer. Once created, you can assign products to this brand.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.brands') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Create Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 