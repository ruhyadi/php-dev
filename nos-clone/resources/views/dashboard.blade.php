@extends('layouts.app')

@section('title', 'Dashboard - NOS Clone')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-lg font-medium text-gray-900">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm text-gray-500">
            You are logged in as a {{ Auth::user()->role->name }}.
        </p>
    </div>
</div>
@endsection