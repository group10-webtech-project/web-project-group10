<?php

use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MultiplayerGameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;

// Public routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Admin dashboard
    Route::get('/', function () {
        $animals = \App\Models\Animal::with('category')->paginate(10);
        return view('admin.index', compact('animals'));
    })->name('admin.dashboard');


    // Animal CRUD routes
    Route::controller(AnimalController::class)->group(function () {
        Route::get('/animals', 'index')->name('admin.animals');
         Route::get('/animals/create', 'create')->name('admin.animals.create');
         Route::post('/animals', 'store')->name('admin.animals.store');
         Route::get('/animals/{animal}/edit', 'edit')->name('admin.animals.edit');
         Route::put('/animals/{animal}', 'update')->name('admin.animals.update');
         Route::delete('/animals/{animal}', 'destroy')->name('admin.animals.destroy');
         Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('admin.animals.show');

    });
});

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

Route::get('/menu', function() {
    return view('choose-mode');
})->name('menu');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/username', [SettingsController::class, 'updateUsername']);
    Route::delete('/settings/delete-account', [SettingsController::class, 'deleteAccount']);

    Route::get('/multiplayer-menu', function() {
        return view('multiplayer-menu');
    })->name('multiplayer.menu');
    // room routes
    Route::controller(RoomController::class)->group(function () {
        Route::get('/rooms/create', 'create')->name('rooms.create');
        Route::get('/rooms/{id}/join', 'join')->name('rooms.join');
        Route::get('/rooms/{id}/finish', 'finish')->name('rooms.finish');
        Route::get('/rooms/{id}/', 'index')->name('rooms.index');
        Route::post('/rooms/{id}/start', 'start')->name('rooms.start');
        Route::post('/rooms/join', 'joinWithCode')->name('rooms.joinWithCode');
    });

    Route::controller(MultiplayerGameController::class)->group(function () {
        Route::get('/rooms/{id}/newgame', 'newGame')->name('multiplayer.newGame');
        Route::get('/rooms/{id}/game', 'index')->name('multiplayer.index');

        // Rate-limited routes
        Route::middleware('throttle:30,1')->group(function () {
            Route::post('/rooms/{id}/game/guess', 'guess')->name('multiplayer.guess');
            Route::post('/rooms/{id}/game/hint', 'buyHint')->name('multiplayer.hint');
            Route::post('/rooms/{id}/game/check', 'checkCharacteristic')->name('multiplayer.checkCharacteristic');
            Route::post('/rooms/{id}/game/reveal', 'revealAnswer')->name('multiplayer.reveal');
        });
    });
});


