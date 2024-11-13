<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request ->only('email','password');

        if (Auth::attempt($credentials)) 
        {
            return redirect()->intended('/dashboard');
        }

        return back()->with(['error' => 'Incorrect email or password.']);
    }

    public function dashboard()
    {
        return view('dashboard');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
