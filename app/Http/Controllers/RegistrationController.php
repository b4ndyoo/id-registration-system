<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Ensure you import the User model

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showForm()
    {
        return view('registration');
    }

    /**
     * Handle form submission and save user to database.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:3',
        ]);
    
        if ($validated) {
            // Create a new user
            User::create([
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')), // Hash the password
            ]);
    
            // Redirect or show a success message
            return redirect()->route('login')->with('success', 'Registration successful!');
        } else {
            // Handle validation failure
            return back()->withErrors($validated)->withInput();
        }
    }
    
}
