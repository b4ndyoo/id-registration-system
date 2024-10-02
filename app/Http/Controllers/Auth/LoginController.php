<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // use AuthenticatesUsers;

    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function showLoginForm()
    {
        return view('login'); // Adjust the path if needed
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/add-student');
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'username' => 'Invalid username or password.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
