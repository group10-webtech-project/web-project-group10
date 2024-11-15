<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::middleware('web')->group(function () {
    // Public routes
    Route::get('/', [GameController::class, 'index'])->name('game.index');
    Route::post('/game/new', [GameController::class, 'newGame'])->name('game.new');
    Route::post('/set-theme', [GameController::class, 'setTheme'])->name('game.setTheme');
    Route::get('/catalogue', [GameController::class, 'catalogue'])->name('catalogue');
    // Rate-limited routes
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('/game/guess', [GameController::class, 'guess'])->name('game.guess');
        Route::post('/game/hint', [GameController::class, 'buyHint'])->name('game.hint');
        Route::post('/game/check', [GameController::class, 'checkCharacteristic'])->name('game.checkCharacteristic');
        Route::post('/game/reveal', [GameController::class, 'revealAnswer'])->name('game.reveal');
        Route::post('/game/give-up', [GameController::class, 'giveUp'])->name('game.giveUp');
    });

    // Authentication routes
    Route::get('/register', [RegisterController::class, 'showRegisterForm']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/dashboard', [LoginController::class, 'dashboard'])->middleware('auth');
    Route::get('/logout', [LoginController::class, 'logout']);
});