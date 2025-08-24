<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('sort_order')->get();
        return view('admin.general-settings', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }
        Feature::create($validated);
        return redirect()->route('admin.features.index')->with('success', 'Feature added successfully!');
    }

    public function edit(Feature $feature)
    {
        $features = Feature::orderBy('sort_order')->get();
        return view('admin.general-settings', compact('features', 'feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }
        $feature->update($validated);
        return redirect()->route('admin.features.index')->with('success', 'Feature updated successfully!');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Feature deleted successfully!');
    }
} 