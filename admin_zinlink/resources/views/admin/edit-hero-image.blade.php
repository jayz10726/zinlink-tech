@extends('admin.layout')

@section('title', 'Edit Hero Image - zinlink tech Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Hero Image</h1>
        <a href="{{ route('admin.hero-images') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>Back to Hero Images
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form method="POST" action="{{ route('admin.hero-images.update', $image) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $image->alt_text ?? $image->name }}" class="w-48 h-32 object-cover rounded-lg border mb-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $image->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <input type="text" name="description" value="{{ old('description', $image->description) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                <input type="text" name="alt_text" value="{{ old('alt_text', $image->alt_text) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $image->sort_order) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <input type="hidden" name="category" value="hero">
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection 