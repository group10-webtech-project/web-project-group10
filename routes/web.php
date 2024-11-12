<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game', [GameController::class, 'index']) ->name('game.index');
Route::post('/game/guess', [GameController::class, 'guess'])->name('game.guess');
Route::post('/game/hint', [GameController::class, 'buyHint'])->name('game.hint');
Route::post('/game/new', [GameController::class, 'newGame'])->name('game.new');
Route::post('/game/check', [GameController::class, 'checkCharacteristic'])->name('game.check');

Route::get('/register', [RegisterController::class, 'showRegisterForm']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', [LoginController::class, 'dashboard'])->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout']);
