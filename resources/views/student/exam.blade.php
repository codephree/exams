@extends('student.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Exam Questions  | {{ $title }}</h1>
    <form action="{{ route('student.exam.submit', ['id' => $examId]) }}" method="POST">
        @csrf
        <div class="space-y-4">
            @foreach ($questions as $index => $question)
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h2 class="text-lg font-semibold">Question {{ $index + 1 }}</h2>
                    <p class="text-gray-700">{{ $question['question_text'] }}</p>
                    <div class="mt-4 space-y-2">
                        @foreach ($question->options as $optionIndex => $option)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ $optionIndex }}" class="form-radio text-blue-600">
                                    <span class="ml-2 text-gray-800">{{ $option }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Submit</button>
        </div>
    </form>
</div>
@endsection