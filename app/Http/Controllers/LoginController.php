<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TwoFactorCode;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::check() && Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }
            
            $user = Auth::user();
            $user -> generateTwoFactorAuthCode();
            $user -> notify(new TwoFactorCode());

            return redirect()->intended(route('verify.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/game');
    }
}
