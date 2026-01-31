@extends('instructors.layouts.app')

@section('content')
    
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left column: stats & menu -->
            @include('instructors.layouts.sidebar')

            <!-- Main content -->
            <section class="lg:col-span-3">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Create New Exam</h2>
                    </div>  

                    <form action="{{ route('instructor.exam.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Exam Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full border @error('title') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm p-2" required value="{{ old('title') }}">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border @error('description') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm p-2" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Exam Date</label>
                            <input type="datetime-local" name="date" id="date" class="mt-1 block w-full border @error('date') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm p-2" required value="{{ old('date') }}">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <input type="number" name="duration" id="duration" class="mt-1 block w-full border @error('duration') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm p-2" required value="{{ old('duration') }}">
                            @error('duration')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="marks" class="block text-sm font-medium text-gray-700">Total Marks</label>
                            <input type="number" name="marks" id="marks" class="mt-1 block w-full border @error('marks') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm p-2" required value="{{ old('marks') }}">
                            @error('marks')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Exam</button>   
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection