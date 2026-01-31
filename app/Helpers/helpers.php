<?php

if (!function_exists('formatDate')) {
    /**
     * Format a date to a more readable format.
     *
     * @param  string  $date
     * @return string
     */
    function formatDate($date)
    {
        // return \Carbon\Carbon::parse($date)->format('F j, Y, g:i a');
        return Carbon\Carbon::parse($date)->setTimezone('Europe/London')->toDayDateTimeString();
    }
}


if (!function_exists('checkExamisExpired')) {
    function checkExamisExpired($startdate)
    {
        $currentDate = Carbon\Carbon::now();
        $examDate = Carbon\Carbon::parse($startdate);

        if ($currentDate->greaterThan($examDate)) {
            return true;
        } else {
            return false;
        }
       
    }
}   

if (!function_exists('checkeExamQuestionsIsEmpty')) {
    function checkeExamQuestionsIsEmpty($exam_id)
    {
        $questions = App\Models\ExamQuestion::where('exam_id', $exam_id)->get();
        if (count($questions) == 0)
        {
            return true;
        } else {
             return false;
        }

       
    }
}