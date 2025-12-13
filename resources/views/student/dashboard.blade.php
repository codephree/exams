@extends('student.app')
@section('title', 'Student Dashboard')
@section('content') 
        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            <h2 class="text-xl font-semibold mb-4">Available Exams</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Example Exam Card -->
                @foreach ($exams as $exam)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold mb-2">{{ $exam->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($exam->description, 100) }}</p>
                    <a href="{{ route('student.exam', ['id' => $exam->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Take Exam</a>
                </div>
                @endforeach
                
            </div>
        </main>
@endsection
      