<?php

namespace App\Http\Controllers\Instructors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function showLoginForm()
    {
        return view('instructors.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('instructors')->attempt($credentials)) {
            return redirect()->intended(route('instructor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));

    }

    public function logout(Request $request)
    {
        auth()->guard('instructors')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // return redirect()->route('instructor.login');
         return redirect(route('instructor.login'))->with('success', 'You have been logged out.');
    }   
}
