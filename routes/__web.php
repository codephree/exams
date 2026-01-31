<?php

use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentAuthController;
// use App\Http\Controllers\AuthController;


/* Web Routes |--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Add your web routes here

// 1. login route
// dashboard route showing open exams
// exam taking route
// exam submission route


// 2. admin routes
Route::prefix('admin')->group(function () {
    // admin login route
    // admin dashboard route showing all exams
    // route to create a new exam
    // route to edit an existing exam
    // route to delete an exam
    // route to view exam results
});

// 3. instructor routes
Route::prefix('instructor')->group(function () {
    // instructor login route
    Route::get('login', [StudentAuthController::class, 'showLoginForm'])->name('instructor.login');
    Route::post('login', [StudentAuthController::class, 'login']);

    // protected instructor routes
    Route::middleware(['instructor.auth'])->group(function () {
            Route::get('dashboard', [Student::class, 'dashboard'])->name('instructor.dashboard');
            Route::post('logout', [StudentAuthController::class, 'logout'])->name('instructor.logout');
            // route to manage questions
         
     });    

    // instructor dashboard route showing their exams
    // route to create a new exam
    // route to edit an existing exam
    // route to delete an exam
    // route to view exam results
});

// 4. student routes
Route::prefix('student')->group(function () {
    // student login route
    Route::get('login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('login', [StudentAuthController::class, 'login']);
    // protected student routes
    Route::middleware(['student.auth'])->group(function () {
            Route::get('dashboard', [Student::class, 'dashboard'])->name('student.dashboard');
            Route::post('logout', [StudentAuthController::class, 'logout'])->name('student.logout');
            // route to take an exam
            Route::get('exam/{id}', [Student::class, 'takeExam'])->name('student.exam');
            // route to submit an exam
            Route::post('exam/{id}/submit', [Student::class, 'submitExam'])->name('student.exam.submit');  
            // route to view exam results
            Route::get('exam/{id}/results', [Student::class, 'viewResults'] )->name('student.exam.results');
     });  
});

// 5. API routes for exam data (if needed)
Route::prefix('api')->group(function () {
    // route to fetch exam data
    // route to submit exam answers
});

// 6. Authentication routes (if not using Laravel Breeze/Jetstream)
// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');    


// 7. Password reset routes
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');   
// 8. Registration routes (if applicable)
// Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [AuthController::class, 'register']);

// 9. Miscellaneous routes
// Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
// Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');

// Add this at the top of the file

