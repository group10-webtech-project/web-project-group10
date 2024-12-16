<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{
    public function index() 
    {
        return view('twoFactor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_auth_code' => 'integer|required',
        ]);

        $user = auth()->user();

        if($request->input('two_factor_auth_code') == $user->two_factor_auth_code)
        {
            $user->resetTwoFactorAuthCode();

            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['two_factor_auth_code' => 'The two factor code you have entered does not match']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorAuthCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}