<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Students\StudentController as StudentController;
use App\Http\Controllers\Students\AuthController as StudentAuthController;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


Route::prefix('student')->group(function () {

    Route::middleware('guest:students')->group(function () {
        // student login route
        Route::get('login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
        Route::post('login', [StudentAuthController::class, 'login']);
    });

    // protected student routes
    // Route::middleware(['students'])->group(function () {
    Route::group(['middleware' => 'student'], function () {
            Route::get('dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
            Route::post('logout', [StudentAuthController::class, 'logout'])->name('student.logout');
            // route to take an exam
            Route::get('exam/{id}', [StudentController::class, 'takeExam'])->name('student.exam');
            // route to submit an exam
            Route::post('exam/{id}/submit', [StudentController::class, 'submitExam'])->name('student.exam.submit');  
            // route to view exam results
            Route::get('exam/{id}/results', [StudentController::class, 'viewResults'] )->name('student.exam.results');
     });  
});

Route::prefix('instructor')->group(function () {
    // instructor login route
    Route::middleware('guest:instructors')->group(function () {

            Route::get('login', [App\Http\Controllers\Instructors\AuthController::class, 'showLoginForm'])->name('instructor.login');
            Route::post('login', [App\Http\Controllers\Instructors\AuthController::class, 'login']);
    });

    // protected instructor routes
    Route::group(['middleware' => 'instructor'], function () {

            Route::get('dashboard', [App\Http\Controllers\Instructors\InstructorController::class, 'dashboard'])->name('instructor.dashboard');
            Route::post('logout', [App\Http\Controllers\Instructors\AuthController::class, 'logout'])->name('instructor.logout');
            // // route to create an exam
            Route::get('exam/create', [App\Http\Controllers\Instructors\InstructorController::class, 'createExamForm'])->name('instructor.exam.create');
            Route::post('exam/create', [App\Http\Controllers\Instructors\InstructorController::class, 'storeExam'])->name('instructor.exam.store');
            // route to view exams
            Route::get('exams', [App\Http\Controllers\Instructors\InstructorController::class, 'viewExams'])->name('instructor.view_exams');
            Route::post('exam/{id}/import-questions', [App\Http\Controllers\Instructors\InstructorController::class, 'importQuestions'])->name('instructor.exam.import_questions');
            Route::get('/settings', [App\Http\Controllers\Instructors\InstructorController::class, 'settings'])->name('instructor.settings');
            Route::post('/settings', [App\Http\Controllers\Instructors\InstructorController::class, 'updateSettings'])->name('instructor.update_settings');
            Route::post('exam/{id}/edit', [App\Http\Controllers\Instructors\InstructorController::class, 'updateExam'])->name('instructor.exam.update'); 
            // // route to view exam results
            // Route::get('exam/{id}/results', [App\Http\Controllers\Instructors\InstructorController::class, 'viewExamResults'])->name('instructor.exam.results');
     });  
});