<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->paginate(20);
        return view('admin.team.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Add debugging
        \Log::info('Team member creation attempt', [
            'request_data' => $request->all(),
            'has_file' => $request->hasFile('photo'),
            'method' => $request->method(),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $photoUrl = $path;
        }

        try {
            $member = TeamMember::create([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'photo_url' => $photoUrl,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

            \Log::info('Team member created successfully', ['member_id' => $member->id]);
        return redirect()->back()->with('success', 'Team member created.');
        } catch (\Exception $e) {
            \Log::error('Failed to create team member', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create team member: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamMember $teamMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamMember $teamMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'role' => $validated['role'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'sort_order' => $validated['sort_order'] ?? $teamMember->sort_order,
            'is_active' => $request->boolean('is_active', $teamMember->is_active),
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $data['photo_url'] = $path;
        }

        $teamMember->update($data);

        return redirect()->back()->with('success', 'Team member updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->back()->with('success', 'Team member deleted.');
    }

    // API: list active members
    public function apiIndex()
    {
        $members = TeamMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'role' => $m->role,
                    'bio' => $m->bio,
                    'photo_url' => $m->photo_url ? (str_starts_with($m->photo_url, 'http') ? $m->photo_url : url('/storage/'.$m->photo_url)) : null,
                    'sort_order' => $m->sort_order,
                ];
            });
        return response()->json(['success' => true, 'data' => $members]);
    }
}
