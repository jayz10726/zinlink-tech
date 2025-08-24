@extends('admin.layout')

@section('title', 'Review Details - LaptopHub Admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Review Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.reviews.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
            </a>
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Review Details -->
    <div class="bg-gray-800 rounded-lg shadow-sm border border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Review Information -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">Review Information</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Customer Name</label>
                                <p class="text-white font-medium">{{ $review->customer_name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Service Used</label>
                                <p class="text-white">{{ $review->service_used }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Rating</label>
                                <div class="flex items-center mt-1">
                                    {!! $review->rating_stars !!}
                                    <span class="ml-2 text-sm text-gray-400">({{ $review->rating }}/5)</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $review->status_badge_class }}">
                                    {{ $review->status_label }}
                                </span>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Submitted On</label>
                                <p class="text-gray-300">{{ $review->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Comment -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Customer Comment</h3>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <div class="flex flex-wrap gap-3">
                    @if($review->status === 'pending')
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Approve Review
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                <i class="fas fa-times mr-2"></i>Reject Review
                            </button>
                        </form>
                    @elseif($review->status === 'approved')
                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                                <i class="fas fa-undo mr-2"></i>Mark as Rejected
                            </button>
                        </form>
                    @elseif($review->status === 'rejected')
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i>Approve Review
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.reviews.delete', $review) }}" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Delete Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 