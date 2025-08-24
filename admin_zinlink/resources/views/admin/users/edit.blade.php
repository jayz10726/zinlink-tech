@extends('admin.layout')

@section('title', 'Edit User - zinlink tech Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                <p class="text-gray-600">Update user information for {{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Users
            </a>
        </div>
    </div>

    <!-- User Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                <span class="text-white font-semibold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <div>
                <h3 class="text-lg font-medium text-blue-900">{{ $user->name }}</h3>
                <p class="text-blue-700">{{ $user->email }}</p>
                <p class="text-sm text-blue-600">Role: {{ ucfirst($user->role) }} | Status: {{ $user->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="Enter full name"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="Enter email address"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Field -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    User Role
                </label>
                <select id="role" 
                        name="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">
                    <strong>User:</strong> Basic access to view content<br>
                    <strong>Manager:</strong> Can manage products and orders<br>
                    <strong>Admin:</strong> Full system access
                </p>
            </div>

            <!-- Password Change Link -->
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Password Management</h3>
                        <p class="text-sm text-yellow-700 mt-1">To change the user's password, use the password change option.</p>
                    </div>
                    <a href="{{ route('admin.users.change-password', $user) }}" 
                       class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-key mr-2"></i>
                        Change Password
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 