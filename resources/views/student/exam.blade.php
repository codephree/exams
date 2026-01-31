@extends('student.app')

@section('content')

<div class="container mx-auto px-4 py-8">

<h1 class="text-2xl font-bold mb-6">Exam Wizard | {{ $title }}</h1>
<form action="{{ route('student.exam.submit', ['id' => $examId]) }}" method="POST" id="examForm">
    @csrf
    <div id="wizard" class="space-y-4">
        @foreach ($questions as $index => $question)
            <div class="step hidden p-4 border rounded-lg shadow-sm bg-white" data-step="{{ $index + 1 }}">
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
    <div class="mt-6 flex justify-between">
        <button type="button" id="prevBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hidden">Previous</button>
        <button type="button" id="nextBtn" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Next</button>
        <button type="submit" id="submitBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hidden">Submit</button>
    </div>
</form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const steps = document.querySelectorAll('.step');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 0;

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('hidden', index !== step);
            });
            prevBtn.classList.toggle('hidden', step === 0);
            nextBtn.classList.toggle('hidden', step === steps.length - 1);
            submitBtn.classList.toggle('hidden', step !== steps.length - 1);
        }

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        showStep(currentStep);
    });
</script>
<!-- <div class="container mx-auto px-4 py-8">
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
</div> -->
@endsection
