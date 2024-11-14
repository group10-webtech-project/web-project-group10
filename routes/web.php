<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::middleware('web')->group(function () {
    // Public routes
    Route::get('/', function () {
        return view('landing');
    })->name('home');

    Route::get('/play', [GameController::class, 'index'])->name('game.play');

    Route::prefix('game')->name('game.')->group(function () {
        Route::post('/new', [GameController::class, 'newGame'])->name('new');
        Route::post('/set-theme', [GameController::class, 'setTheme'])->name('setTheme');

        // Rate-limited routes
        Route::middleware('throttle:30,1')->group(function () {
            Route::post('/guess', [GameController::class, 'guess'])->name('guess');
            Route::post('/hint', [GameController::class, 'buyHint'])->name('hint');
            Route::post('/check', [GameController::class, 'checkCharacteristic'])->name('checkCharacteristic');
            Route::post('/reveal', [GameController::class, 'revealAnswer'])->name('reveal');
            Route::post('/give-up', [GameController::class, 'giveUp'])->name('giveUp');
        });
    });

    Route::get('/login', function() {
        return redirect('/'); // Temporary redirect until auth is implemented
    })->name('login');
});

