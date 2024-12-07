<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;

// Public routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Game routes
Route::controller(GameController::class)->group(function () {
    Route::get('/game', 'index')->name('game.index');
    Route::get('/catalogue', 'catalogue')->name('catalogue');
    Route::post('/game/new', 'newGame')->name('game.new');
    Route::post('/game/set-theme', 'setTheme')->name('game.setTheme');

    // Rate-limited routes
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('/game/guess', 'guess')->name('game.guess');
        Route::post('/game/hint', 'buyHint')->name('game.hint');
        Route::post('/game/check', 'checkCharacteristic')->name('game.checkCharacteristic');
        Route::post('/game/reveal', 'revealAnswer')->name('game.reveal');
        Route::post('/game/give-up', 'giveUp')->name('game.giveUp');
    });
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', function () {
        return view('reset-password');
    })->middleware('guest')->name('password.request');

    Route::post('/forgot-password', function () {
        return back()->with('message', 'If your email exists in our system, you will receive a password reset link.');
    })->middleware('guest')->name('password.email');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/username', [SettingsController::class, 'updateUsername']);
    Route::delete('/settings/delete-account', [SettingsController::class, 'deleteAccount']);
});



