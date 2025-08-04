@extends('admin.layout')

@section('title', 'Reviews - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Reviews Management</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-box mr-2"></i>Products
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-blue-600 rounded-lg">
                    <i class="fas fa-star text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Total Reviews</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-600 rounded-lg">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-600 rounded-lg">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Approved</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['approved'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-red-600 rounded-lg">
                    <i class="fas fa-times text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Rejected</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['rejected'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-purple-600 rounded-lg">
                    <i class="fas fa-star-half-alt text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Avg Rating</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['average_rating'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-700">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search reviews..." 
                       class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Rating</label>
                <select name="rating" class="w-full px-3 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-700">
        <form method="POST" action="{{ route('admin.reviews.bulk-action') }}" id="bulkActionForm">
            @csrf
            <div class="flex items-center space-x-4">
                <select name="action" class="px-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white">
                    <option value="">Bulk Actions</option>
                    <option value="approve">Approve Selected</option>
                    <option value="reject">Reject Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" onclick="return confirm('Are you sure you want to perform this action?')">
                    Apply
                </button>
            </div>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="bg-gray-800 rounded-lg shadow-sm border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-600 bg-gray-700 text-blue-600">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Comment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="reviews[]" value="{{ $review->id }}" form="bulkActionForm" class="review-checkbox rounded border-gray-600 bg-gray-700 text-blue-600">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $review->customer_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-300">{{ $review->service_used }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                {!! $review->rating_stars !!}
                                <span class="ml-2 text-sm text-gray-400">({{ $review->rating }}/5)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-300 max-w-xs truncate" title="{{ $review->comment }}">
                                {{ Str::limit($review->comment, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $review->status_badge_class }}">
                                {{ $review->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            {{ $review->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.reviews.show', $review) }}" class="text-blue-400 hover:text-blue-300" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($review->status === 'pending')
                                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-400 hover:text-green-300" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-400 hover:text-red-300" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.reviews.delete', $review) }}" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="bg-gray-800 px-4 py-3 border-t border-gray-700 sm:px-6">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.review-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endsection 