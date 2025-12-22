@extends('student.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Exam Results</h1>

        <div class="bg-gray-100 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700">Your Performance</h2>
            <p class="text-gray-600 mt-2">Here are the results based on the questions you answered:</p>

            <ul class="mt-4 space-y-2">
                <!-- Example result item -->
                <li class="flex justify-between bg-white p-3 rounded shadow">
                    <span class="text-gray-800">Question 1:</span>
                    <span class="text-green-600 font-semibold">Correct</span>
                </li>
                <li class="flex justify-between bg-white p-3 rounded shadow">
                    <span class="text-gray-800">Question 2:</span>
                    <span class="text-red-600 font-semibold">Incorrect</span>
                </li>
                <!-- Add more questions dynamically -->
            </ul>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('student.dashboard') }}" class="text-blue-500 hover:underline">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection