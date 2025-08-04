<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('service_used', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', Review::STATUS_PENDING)->count(),
            'approved' => Review::where('status', Review::STATUS_APPROVED)->count(),
            'rejected' => Review::where('status', Review::STATUS_REJECTED)->count(),
            'average_rating' => Review::where('status', Review::STATUS_APPROVED)->avg('rating') ?? 0
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update(['status' => Review::STATUS_APPROVED]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => Review::STATUS_REJECTED]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review rejected successfully.');
    }

    public function delete(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject,delete',
            'reviews' => 'required|array',
            'reviews.*' => 'exists:reviews,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reviews = Review::whereIn('id', $request->reviews);

        switch ($request->action) {
            case 'approve':
                $reviews->update(['status' => Review::STATUS_APPROVED]);
                $message = 'Reviews approved successfully.';
                break;
            case 'reject':
                $reviews->update(['status' => Review::STATUS_REJECTED]);
                $message = 'Reviews rejected successfully.';
                break;
            case 'delete':
                $reviews->delete();
                $message = 'Reviews deleted successfully.';
                break;
        }

        return redirect()->route('admin.reviews.index')->with('success', $message);
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $query = Review::where('status', Review::STATUS_APPROVED);

        if ($request->filled('limit')) {
            $query->limit($request->limit);
        }

        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'message' => 'Reviews retrieved successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'service_used' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $review = Review::create([
            'customer_name' => $request->customer_name,
            'service_used' => $request->service_used,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => Review::STATUS_PENDING
        ]);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review submitted successfully and pending approval'
        ], 201);
    }

    public function stats()
    {
        $stats = [
            'total_reviews' => Review::where('status', Review::STATUS_APPROVED)->count(),
            'average_rating' => Review::where('status', Review::STATUS_APPROVED)->avg('rating') ?? 0,
            'rating_distribution' => [
                '5_star' => Review::where('status', Review::STATUS_APPROVED)->where('rating', 5)->count(),
                '4_star' => Review::where('status', Review::STATUS_APPROVED)->where('rating', 4)->count(),
                '3_star' => Review::where('status', Review::STATUS_APPROVED)->where('rating', 3)->count(),
                '2_star' => Review::where('status', Review::STATUS_APPROVED)->where('rating', 2)->count(),
                '1_star' => Review::where('status', Review::STATUS_APPROVED)->where('rating', 1)->count(),
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'message' => 'Review statistics retrieved successfully'
        ]);
    }
} 