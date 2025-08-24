@extends('admin.layout')

@section('title', 'Team Members - Admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Team Members ({{ $members->count() }} total)</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h2 class="text-lg font-semibold mb-4">Add New Member</h2>
            <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input type="text" name="role" class="w-full px-3 py-2 border rounded-lg" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <textarea name="bio" rows="4" class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 border rounded-lg" />
                </div>
                <div class="grid grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border rounded-lg" />
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" name="is_active" id="is_active" checked class="rounded" />
                        <label for="is_active" class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">Add Member</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h2 class="text-lg font-semibold mb-4">Preview</h2>
            <p class="text-sm text-gray-600">New members will appear below after saving.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold mb-4">All Members</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($members as $member)
                <tr>
                    <td class="px-4 py-2">
                        @if($member->photo_url)
                            <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : url('/storage/'.$member->photo_url) }}" alt="{{ $member->name }}" class="w-12 h-12 object-cover rounded-full border" />
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-100 border"></div>
                        @endif
                    </td>
                    <td class="px-4 py-2 font-semibold text-gray-900">{{ $member->name }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $member->role }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $member->sort_order }}</td>
                    <td class="px-4 py-2 text-right">
                        <form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                            @csrf
                            <input type="text" name="name" value="{{ $member->name }}" class="px-2 py-1 border rounded" />
                            <input type="text" name="role" value="{{ $member->role }}" class="px-2 py-1 border rounded" />
                            <input type="number" name="sort_order" value="{{ $member->sort_order }}" class="w-20 px-2 py-1 border rounded" />
                            <input type="file" name="photo" class="px-2 py-1 border rounded" />
                            <label class="inline-flex items-center gap-1 text-sm">
                                <input type="checkbox" name="is_active" {{ $member->is_active ? 'checked' : '' }} class="rounded" /> Active
                            </label>
                            <button class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
                        </form>
                        <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this member?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">{{ $members->links() }}</div>
    </div>
</div>
@endsection 