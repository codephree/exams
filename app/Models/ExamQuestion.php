<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    //
    protected $table = 'exam_questions';

    protected $fillable = [
        'exam_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'marks',
    ];

    protected $casts = [
        'options' => 'array',
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    

}
