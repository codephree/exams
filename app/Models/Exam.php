<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //
    protected    $table = 'exams';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'duration_minutes',
        'total_marks',
        'instructor_id',
        'status',
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(StudentExamAttempt::class);
    }

    public function isOngoing()
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now;
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    
}
