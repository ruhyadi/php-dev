@extends('layouts.app')

@section('title', 'Edit User - NOS Clone')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Edit User</h2>
            <p class="mt-1 text-sm text-gray-500">Update user information and role.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.show', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">← Back to User</a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               required>
                    </div>
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                    <div class="mt-1">
                        <select name="role_id" id="role_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="Leave blank to keep current password">
                        <p class="mt-1 text-sm text-gray-500">Minimum 6 characters. Leave empty to keep current password.</p>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="Leave blank to keep current password">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.show', $user->id) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection