<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExamAttempt extends Model
{
    //
    private $table = 'student_exam_attempts';
    protected $fillable = [
        'student_id',
        'exam_id',
        'started_at',
        'submitted_at',
        'score',
        'status',
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    

}
