@extends('layouts.app')

@section('title', 'User Details - NOS Clone')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-medium text-gray-900">User Details</h2>
            <p class="mt-1 text-sm text-gray-500">View detailed information about this user.</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-900">← Back to Users</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Full name</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Email address</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Role</dt>
                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role->slug === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ $user->role->name }}
                    </span>
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created at</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->created_at->format('F j, Y H:i') }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Last updated</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->updated_at->format('F j, Y H:i') }}</dd>
            </div>
        </dl>
    </div>
    
    <div class="bg-white px-4 py-5 sm:px-6 flex justify-end space-x-3">
        <a href="{{ route('admin.users.edit', $user->id) }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Edit User
        </a>
        @if($user->id !== auth()->id())
            <button 
                onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                type="button"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Delete User
            </button>
        @endif
    </div>
</div>

@if($user->id !== auth()->id())
    <x-delete-confirmation-modal 
        :id="$user->id"
        :action="route('admin.users.delete', $user->id)"
        :userName="$user->name"
    />
@endif
@endsection