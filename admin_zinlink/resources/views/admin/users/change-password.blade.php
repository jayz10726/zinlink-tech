@extends('admin.layout')

@section('title', 'Change User Password - zinlink tech Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Change User Password</h1>
                <p class="text-gray-600">Update password for {{ $user->name }}</p>
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
                <p class="text-sm text-blue-600">Role: {{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl">
        <form action="{{ route('admin.users.change-password.store', $user) }}" method="POST">
            @csrf
            
            <!-- Current Password Field -->
            <div class="mb-6">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="Enter current password for {{ $user->name }}"
                       required>
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">
                    You need to know the user's current password to change it.
                </p>
            </div>

            <!-- New Password Field -->
            <div class="mb-6">
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="new_password" 
                       name="new_password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="Enter new password (minimum 8 characters)"
                       required
                       minlength="8">
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password Field -->
            <div class="mb-6">
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="new_password_confirmation" 
                       name="new_password_confirmation" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="Confirm new password"
                       required
                       minlength="8">
            </div>

            <!-- Password Requirements -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Password Requirements:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Minimum 8 characters long</li>
                    <li>• Use a combination of letters, numbers, and symbols</li>
                    <li>• Avoid common passwords and personal information</li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-key mr-2"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 