<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function show()
    {
        return view('settings');
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return response()->json(['success' => true]);
    }
}
