<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;

use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use App\Models\StudentExamAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //
    public function dashboard()
    {
              $student = StudentExamAttempt::where('student_id', Auth::id())
                                           ->whereNotIn('status', ['graded', 'submitted'])
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
    }

    public function takeExam($id)
    {
              $questions = ExamQuestion::where('exam_id', $id)
                                          ->inRandomOrder()->limit(20)->get();
                // create a new StudentExamAttempt record
                StudentExamAttempt::create([
                    'student_id' => Auth::id(),
                    'exam_id' => $id,
                    'started_at' => now(),
                    'status' => 'in_progress'
                ]);

                return view('student.exam', ['questions' => $questions, 'examId' => $id , 'duration' => Exam::where('id',$id)->pluck('duration_minutes')->first(),  'title' => Exam::where('id',$id)->pluck('title')->first()]);
    }

    public function submitExam(Request $request, $id)
    {
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
    }

    public function viewResults($id)
    {
        //
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
    }
}
