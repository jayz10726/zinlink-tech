<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        $adminCount = User::where('role', 'admin')->count();
        
        return view('admin.users.index', compact('users', 'adminCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|in:admin,user,manager',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'nullable|string|in:admin,user,manager',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the last admin user
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show the form for changing user password.
     */
    public function showChangePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    /**
     * Change user password.
     */
    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Show the form for changing own password.
     */
    public function showChangeOwnPassword()
    {
        $user = auth()->user();
        return view('admin.users.change-own-password', compact('user'));
    }

    /**
     * Change own password.
     */
    public function changeOwnPassword(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Your password has been changed successfully.');
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.users.index')
            ->with('success', "User {$status} successfully.");
    }

    /**
     * Log out a specific user (admin only).
     */
    public function logoutUser(User $user)
    {
        // Check if the current user is an admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Only administrators can log out users.');
        }

        // Prevent admin from logging out themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot log out yourself.');
        }

        // Invalidate all sessions for the user
        $user->update([
            'remember_token' => null,
        ]);

        // If using database sessions, you can also clear them
        if (config('session.driver') === 'database') {
            \DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been logged out successfully.");
    }

    /**
     * Force logout all users except current admin.
     */
    public function logoutAllUsers()
    {
        // Check if the current user is an admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Only administrators can log out all users.');
        }

        // Get all users except the current admin
        $users = User::where('id', '!=', auth()->id())->get();

        foreach ($users as $user) {
            // Invalidate remember tokens
            $user->update(['remember_token' => null]);
        }

        // Clear all database sessions except current admin's
        if (config('session.driver') === 'database') {
            \DB::table('sessions')
                ->where('user_id', '!=', auth()->id())
                ->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'All users have been logged out successfully.');
    }
}
