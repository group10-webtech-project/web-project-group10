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
        $credentials = $request ->only('email','password');

        if (Auth::attempt($credentials)) 
        {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login attempt.']);
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
