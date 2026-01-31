<?php

namespace App\Http\Controllers\Instructors;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\InstructorUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    //

    public function dashboard()
    {
        return view('instructors.dashboard');
    }

    public function createExamForm()
    {
        return view('instructors.create_exam');
    }

    public function storeExam(Request $request)
    {

        // dd($request->all());
        // Validate and store the exam details
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'marks' => 'required|integer|min:1',
        ]);
   
        $exams = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_time' => Carbon::parse($validated['date'])->toISOString(),
                'end_time' => Carbon::parse($validated['date'])->addMinutes((int)$validated['duration'])->toISOString(),
                'duration_minutes' => $validated['duration'],
                'total_marks' => $validated['marks'],
                'instructor_id' => Auth::guard('instructors')->user()->id, 
        ];
        // Logic to store exam in the database would go here
        Exam::create($exams);

        return redirect()->route('instructor.dashboard')->with('success', 'Exam created successfully!');
    }

    public function viewExams()
    {
        $exams = Exam::where('instructor_id', Auth::guard('instructors')->user()->id)->get();
        return view('instructors.view_exams', compact('exams'));
    }

    public function updateExam(Request $request, $id)
    {
        // Validate and update the exam details
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'marks' => 'required|integer|min:1',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->title = $validated['title'];
        $exam->description = $validated['description'];
        // $exam->start_time = Carbon::parse($validated['date'])->toISOString();
        // $exam->end_time = Carbon::parse($validated['date'])->addMinutes((int)$validated['duration'])->toISOString();
        $exam->duration_minutes = $validated['duration'];
        $exam->total_marks = $validated['marks'];
        $exam->save();

        return redirect()->route('instructor.view_exams')->with('success', 'Exam updated successfully!');
    }

    public function importQuestions(Request $request, $id)
    {

        // dd($request->all(), $id);
        // Handle file upload and import questions logic here
        $request->validate([
            'questions_file' => 'required|file|mimes:csv,xlsx',
        ]);

        $file = $request->file('questions_file');

        // Logic to parse the file and import questions into the exam with ID $id
        if ($handle = fopen($file->getRealPath(), 'r')) {
            $firstLine = true;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
               
                // Skip header row
                 if ($firstLine) {
                     
                    $firstLine = false;
                    continue;
                }

                // Assuming the CSV has columns: question_text, option_a, option_b, option_c, option_d, correct_option
                $options = json_encode([
                    'A' => $data[1],
                    'B' => $data[2],
                    'C' => $data[3],
                    'D' => $data[4],
                ]);
                // Logic to create question records in the database
                 ExamQuestion::create([
                    'exam_id' => $id,
                    'question_text' => $data[0],
                    'options' => $options,
                    'correct_answer' => $data[5],
                    'marks' => 1,
                    'question_type' => $data[6] ?? 'multiple_choice',
                ]);
            }
            fclose($handle);
            return redirect()->route('instructor.view_exams')->with('success', 'Questions imported successfully!');
        }

        // return redirect()->route('instructor.view_exams')->with('success', 'Questions imported successfully!');
        return redirect()->back()->with('error', 'Unable to open file.');
    } 
    
    // 
    public function settings()
    {
        return view('instructors.settings');
    }

    public function updateSettings(Request $request)
    {
        // Validate and update instructor settings
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:ex_instructor_users,email,' . Auth::guard('instructors')->id(),
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $instructor = InstructorUser::find(Auth::guard('instructors')->id());
        $instructor->name = $validated['name'];
        $instructor->email = $validated['email'];

        if (!empty($validated['password'])) {
            $instructor->password = bcrypt($validated['password']);
        }

        $instructor->save();

        return redirect()->route('instructor.settings')->with('success', 'Settings updated successfully!');
    }   


}