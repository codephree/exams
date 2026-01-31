@extends('instructors.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Instructor Settings</h1>
    <div class="bg-white shadow-sm rounded-lg p-6">
        <form action="{{ route('instructor.update_settings') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::guard('instructors')->user()->name }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::guard('instructors')->user()->email }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Add any JavaScript needed for the settings page here 
</script>
@endsection
