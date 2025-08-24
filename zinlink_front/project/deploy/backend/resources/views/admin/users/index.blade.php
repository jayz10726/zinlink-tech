@extends('admin.layout')

@section('title', 'User Management - zinlink tech Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-600">Manage system users and their permissions</p>
        </div>
        <div class="flex space-x-3">
            <form action="{{ route('admin.users.logout-all') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2"
                        onclick="return confirm('Are you sure you want to log out ALL users? This will force everyone to log in again.')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout All Users</span>
                </button>
            </form>
            <a href="{{ route('admin.users.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Add New User</span>
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'manager') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.users.change-password', $user) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                       title="Change Password">
                                        <i class="fas fa-key"></i>
                                    </a>
                                    
                                    <!-- Logout User Button -->
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.logout', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-purple-600 hover:text-purple-900 transition-colors duration-200"
                                                    title="Logout User"
                                                    onclick="return confirm('Are you sure you want to log out {{ $user->name }}?')">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="text-{{ $user->is_active ? 'orange' : 'green' }}-600 hover:text-{{ $user->is_active ? 'orange' : 'green' }}-900 transition-colors duration-200"
                                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }} User"
                                                onclick="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} {{ $user->name }}?')">
                                            <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    
                                    @if($user->role !== 'admin' || $adminCount > 1)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                    title="Delete User"
                                                    onclick="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Action Legend -->
    <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Action Icons Legend</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-2">
                <i class="fas fa-edit text-blue-600"></i>
                <span class="text-sm text-gray-700">Edit User</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-key text-yellow-600"></i>
                <span class="text-sm text-gray-700">Change Password</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-sign-out-alt text-purple-600"></i>
                <span class="text-sm text-gray-700">Logout User</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-play text-green-600"></i>
                <span class="text-sm text-gray-700">Activate User</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-pause text-orange-600"></i>
                <span class="text-sm text-gray-700">Deactivate User</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-trash text-red-600"></i>
                <span class="text-sm text-gray-700">Delete User</span>
            </div>
        </div>
    </div>
</div>
@endsection 