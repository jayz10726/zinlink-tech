@extends('admin.layout')

@section('title', 'General Settings - LaptopHub Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
        </a>
    </div>

    <!-- Features Section -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Why Choose Us / Features</h2>
        <!-- Add New Feature -->
        <form method="POST" action="{{ route('admin.features.store') }}" class="space-y-4 mb-8">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <input type="text" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon (optional, e.g. emoji or icon class)</label>
                <input type="text" name="icon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">Add Feature</button>
            </div>
        </form>

        <!-- List of Features -->
        <h3 class="text-md font-semibold text-gray-900 mb-2">Current Features</h3>
        @if($features->isEmpty())
            <p class="text-gray-500">No features added yet.</p>
        @else
            <div class="space-y-4">
                @foreach($features as $feature)
                    <div class="flex items-center space-x-4 bg-gray-50 rounded-lg p-4 border">
                        <div class="text-2xl">{{ $feature->icon }}</div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $feature->title }}</div>
                            <div class="text-sm text-gray-600 mb-1">{{ $feature->description }}</div>
                            <div class="text-xs text-gray-400">Sort Order: {{ $feature->sort_order }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.features.destroy', $feature) }}" onsubmit="return confirm('Are you sure you want to delete this feature?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-xs">Delete</button>
                        </form>
                        <a href="{{ route('admin.features.edit', $feature) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 text-xs ml-2">Edit</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 