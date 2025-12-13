@extends('student.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Exam Results | {{ $data['exam'] }}</div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Your Score: {{ $data['score'] }}/{{ $data['total_marks'] }}</h5>
                        <h5 class="card-title">Your Percentage: {{ round($data['percentage'],1) }}%</h5>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-primary mt-3">Back to Exams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection