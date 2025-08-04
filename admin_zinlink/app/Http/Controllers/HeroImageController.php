<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    /**
     * Display a listing of hero images
     */
    public function index()
    {
        $heroImages = Image::where('category', 'hero')->orderBy('sort_order')->get();
        return view('admin.hero-images', compact('heroImages'));
    }

    /**
     * Store a newly created hero image
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Default sort_order to 0 if not provided
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        // Handle image upload
        $imagePath = $request->file('image')->store('frontend-images', 'public');
        $validated['image_url'] = $imagePath;

        Image::create($validated);

        return redirect()->route('admin.hero-images')->with('success', 'Hero image uploaded successfully!');
    }

    /**
     * Delete a hero image
     */
    public function destroy(Image $image)
    {
        // Delete image file
        if ($image->image_url && !str_starts_with($image->image_url, 'http')) {
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }
        }
        $image->delete();
        return redirect()->route('admin.hero-images')->with('success', 'Hero image deleted successfully!');
    }

    /**
     * Show the form for editing a hero image
     */
    public function edit(Image $image)
    {
        return view('admin.edit-hero-image', compact('image'));
    }

    /**
     * Update a hero image
     */
    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }
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
        return redirect()->route('admin.hero-images')->with('success', 'Hero image updated successfully!');
    }
} 