<?php

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\StudentExamAttempt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\StudentAuthController;
use Psy\Command\WhereamiCommand;
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

   
    Route::middleware(['student.auth'])->group(function () {

        // student dashboard route showing enrolled exams
            Route::get('dashboard', function () {
                $student = StudentExamAttempt::where('student_id', Auth::id())
                                    ->pluck('exam_id');
                                    // ->groupBy('exam_id');
                // dd($student);
                $exams = Exam::whereNotIn('id', $student)
                                ->where('status', 'scheduled')
                                ->where('exam_date', '>=', now()) 
                                ->get();
                return view('student.dashboard', [
                    'exams' => $exams
                ]);
            })->name('student.dashboard');
            Route::post('logout', [StudentAuthController::class, 'logout'])->name('student.logout');
            
            // route to take an exam
            Route::get('exam/{id}', function ($id) {
                $questions = ExamQuestion::where('exam_id', $id)->inRandomOrder()->limit(20)->get();
                // create a new StudentExamAttempt record
                StudentExamAttempt::create([
                    'student_id' => Auth::id(),
                    'exam_id' => $id,
                    'started_at' => now(),
                    'status' => 'in_progress'
                ]);

                return view('student.exam', ['questions' => $questions, 'examId' => $id]);
            })->name('student.exam');

            // route to submit an exam
            Route::post('exam/{id}/submit', function (Request $request, $id) {
                // handle exam submission
                $request = request();

                // update the StudentExamAttempt record
                StudentExamAttempt::where('student_id', Auth::id())
                    ->where('exam_id', $id)
                    ->where('status', 'in_progress')
                    ->update([
                        'submitted_at' => now(),
                        'status' => 'submitted'     
                    ]);
                
                $score = 0;

                // dd($request->answers);
                foreach ($request->answers as $questionId => $answer) {
                    // enter student answer into database
                    DB::table('student_answers')->insert([
                        'attempt_id' => StudentExamAttempt::where('student_id', Auth::id())
                            ->where('exam_id', $id)
                            ->where('status', 'submitted')
                            ->first()->id,
                        'question_id' => $questionId,
                        'answer_text' => $answer,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // process each answer
                    $question = ExamQuestion::find($questionId);
                    if ($question && $question->correct_answer == $answer) {
                        $score += $question->marks;
                        $is_correct = true;
                        // store whether the answer was correct
                        DB::table('student_answers')
                            ->where('attempt_id', StudentExamAttempt::where('student_id', Auth::id())
                                ->where('exam_id', $id)
                                ->where('status', 'submitted')
                                ->first()->id)
                            ->where('question_id', $questionId)
                            ->update(['marks_obtained' => $question->marks]);
                    }
                    else {
                        // store whether the answer was correct
                        DB::table('student_answers')
                            ->where('attempt_id', StudentExamAttempt::where('student_id', Auth::id())
                                ->where('exam_id', $id)
                                ->where('status', 'submitted')
                                ->first()->id)
                            ->where('question_id', $questionId)
                            ->update(['marks_obtained' => 0]);
                    }               

                }

                // update score in StudentExamAttempt
                StudentExamAttempt::where('student_id', Auth::id())
                    ->where('exam_id', $id)
                    ->where('status', 'submitted')
                    ->update([
                        'score' => $score,  
                        'status' => 'graded'
                    ]);
                // die();
                // dd($score);
                return redirect()->route('student.exam.results', ['id' => $id]);



            })->name('student.exam.submit');  

            // route to view exam results
            Route::get('exam/{id}/results', function ($id) {
                // fetch exam score for the student and exam id
                $examAttempt = StudentExamAttempt::where('student_id', Auth::id())
                    ->where('exam_id', $id)
                    ->where('status', 'graded')
                    ->firstOrFail();
                // fetch total marks for the exam
            $exams=   DB::table('student_answers')->where('attempt_id', $examAttempt->id)->get();
            
            $sum = 0;
            foreach($exams as $exam){
                $sum += ExamQuestion::find($exam->question_id)->marks;
            }
            $totalMarked = $sum;
            $data = [
                    'exam' => Exam::find($id)->title,
                    'score' => $examAttempt->score,
                    'total_marks' => $totalMarked,
                    'percentage' => ($examAttempt->score / $totalMarked) * 100
                ];
                return view('student.results', ['data' => $data]);
            })->name('student.exam.results');
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

