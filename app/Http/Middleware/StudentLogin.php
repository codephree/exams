<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        if (!auth()->check()) {
            
            return redirect()->route('student.login')->with('failure', 'Error when trying to login!');
        } else {
           
            $student = Student::where('user_id', auth()->user()->id)->count();
            if ($student == 0) 
            {
                Auth::logout();
                return redirect()->route('student.login')->with('failure', 'Error when trying to login!');
            }
        }

        return $next($request);
        
    }
}
