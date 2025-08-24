@extends('admin.layout')

@section('title', 'Hero Images - LaptopHub Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Hero Images</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
        </a>
    </div>

    <!-- Upload New Hero Image -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Hero Image</h2>
        <form method="POST" action="{{ route('admin.hero-images.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image *</label>
                <input type="file" name="image" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <input type="text" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                <input type="text" name="alt_text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <input type="hidden" name="category" value="hero">
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">Upload</button>
            </div>
        </form>
    </div>

    <!-- List of Current Hero Images -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Current Hero Images</h2>
        @if($heroImages->isEmpty())
            <p class="text-gray-500">No hero images uploaded yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($heroImages as $image)
                    <div class="flex items-center space-x-4 bg-gray-50 rounded-lg p-4 border">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $image->alt_text ?? $image->name }}" class="w-32 h-20 object-cover rounded-lg border">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $image->name }}</div>
                            <div class="text-sm text-gray-600 mb-1">{{ $image->description }}</div>
                            <div class="text-xs text-gray-400">Alt: {{ $image->alt_text }}</div>
                            <div class="text-xs text-gray-400">Sort Order: {{ $image->sort_order }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.hero-images.destroy', $image) }}" onsubmit="return confirm('Are you sure you want to delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-xs">Delete</button>
                        </form>
                        <a href="{{ route('admin.hero-images.edit', $image) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 text-xs ml-2">Edit</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 