<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of images
     */
    public function index(Request $request): JsonResponse
    {
        $query = Image::query();

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Filter by active status
        if ($request->has('active')) {
            if ($request->boolean('active')) {
                $query->active();
            }
        }

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort images
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortOrder = $request->get('sort_order', 'asc');
        $allowedSortFields = ['name', 'category', 'sort_order', 'created_at'];
        
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $images = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $images->items(),
            'pagination' => [
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
                'per_page' => $images->perPage(),
                'total' => $images->total(),
                'from' => $images->firstItem(),
                'to' => $images->lastItem(),
            ]
        ]);
    }

    /**
     * Get images by category
     */
    public function byCategory(string $category): JsonResponse
    {
        $images = Image::active()
            ->byCategory($category)
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    /**
     * Get hero carousel images
     */
    public function heroImages(): JsonResponse
    {
        $images = Image::active()
            ->byCategory('hero')
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    /**
     * Store a newly created image
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'category' => 'required|string|max:255',
                'alt_text' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ]);

            // Handle image upload
            $imagePath = $request->file('image')->store('frontend-images', 'public');
            $validated['image_url'] = $imagePath;

            $image = Image::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Image created successfully',
                'data' => $image
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified image
     */
    public function show(Image $image): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $image
        ]);
    }

    /**
     * Update the specified image
     */
    public function update(Request $request, Image $image): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'category' => 'sometimes|required|string|max:255',
                'alt_text' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($image->image_url && !str_starts_with($image->image_url, 'http')) {
                    if (Storage::disk('public')->exists($image->image_url)) {
                        Storage::disk('public')->delete($image->image_url);
                    }
                }
                
                $imagePath = $request->file('image')->store('frontend-images', 'public');
                $validated['image_url'] = $imagePath;
            }

            $image->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'data' => $image
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified image
     */
    public function destroy(Image $image): JsonResponse
    {
        // Delete image file
        if ($image->image_url && !str_starts_with($image->image_url, 'http')) {
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Update image order
     */
    public function updateOrder(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'images' => 'required|array',
                'images.*.id' => 'required|exists:images,id',
                'images.*.sort_order' => 'required|integer|min:0',
            ]);

            foreach ($validated['images'] as $imageData) {
                Image::where('id', $imageData['id'])
                    ->update(['sort_order' => $imageData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Image order updated successfully'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
