<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfStudentsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the default user guard is authenticated and the user is a Student model
        if (Auth::check() && Auth::user() instanceof Student) {
            return redirect('/student/home');
        }

        // If there's a dedicated 'student' guard being used
        if (Auth::guard('student')->check()) {
            return redirect('/student/home');
        }

        return $next($request);
    }
}
