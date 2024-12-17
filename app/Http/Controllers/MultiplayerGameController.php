<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MultiplayerGameController extends Controller
{
    private $maxGuesses = 5;
    private $hintCost = 200;
    private $characteristicCost = 150;
    private $correctGuessPoints = 2000;
    private $wrongGuessDeduction = 150;
    private $startingPoints = 1000;


    protected \Illuminate\Database\Eloquent\Collection $animals;


    public function __construct()
    {
        $this->animals = Animal::with('category')->get();

    }

    public function index($id)
    {
        $room = Room::findOrFail($id);
        if (Auth::check()) {
            $user = Auth::user();
            if($user->room_id != $room->id)
            {
                return response()->json([
                    'success' => false,
                    'error' => "You aren't a part of this room.",
                ]);
            }
            if(!$room->active)
            {
                return response()->json([
                    'success' => false,
                    'error' => "The game has not started yet."
                ]);
            }

            $playerName = $user->name;

            if (!session()->has('animal_index')) {
                $this->setupNewGame($room);
            }

            return view('multiplayer_game', [
                'room' => $room,
                'remainingSeconds' => Carbon::now()->diffInSeconds($room->game_end_at),
                'playerName' => $playerName,
                'wordLength' => strlen(session('animal')),
                'guesses' => session('guesses', []),
                'gameOver' => session('gameOver', false),
                'won' => session('won', false),
                'points' => session('points', $this->startingPoints),
                'hints' => session('hints', []),
                'initialHint' => session('initialHint'),
                'hintCost' => $this->hintCost,
                'characteristicCost' => $this->characteristicCost,
                'maxAttempts' => $this->maxGuesses,
                'theme' => session('theme', 'fantasy')
            ]);
        }
    }

    public function guess(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        if(!$room->active)
        {
            return response()->json([
                'success' => false,
                'error' => "The game is currently not running."
            ]);
        }
        $request->validate([
            'guess' => 'required|string|alpha|max:10'
        ]);

        if (session('gameOver')) {
            return response()->json(['error' => 'Game is already over'], 400);
        }

        $guess = strtoupper(request('guess'));
        $animal = session('animal');
        $guesses = session('guesses', []);
        $points = session('points', $this->startingPoints);

        if (strlen($guess) !== strlen($animal)) {
            return back()->with('error', 'Invalid guess length');
        }

        $result = $this->checkGuess($guess, $animal);
        $guesses[] = [
            'word' => $guess,
            'result' => $result
        ];

        $won = $guess === $animal;



        if ($won) {
            $points += $this->correctGuessPoints;
            $this->addTransaction("🎉 Correctly guessed the animal: $animal!", $this->correctGuessPoints);
        } else {
            $points -= $this->wrongGuessDeduction;
        }


        $points = max(0, $points);

        $roundOver = $won || count($guesses) >= $this->maxGuesses || $points <= 0;

        if($roundOver)
        {
            $user = Auth::user();
            $user->current_room_score += $points;
            $user->save();
        }

        session([
            'guesses' => $guesses,
            'roundOver' => $roundOver,
            'won' => $won,
            'points' => $points
        ]);

        $gameOver = false;
        if ($roundOver)
        {
            $gameOver = !$this->loadNextRound($room);
        }
        // Instead of redirecting, return JSON response
        return response()->json([
            'success' => true,
            'roundOver' => $roundOver,
            'gameOver' => $gameOver,
            'message' => $message ?? '',
        ]);
    }

    public function buyHint()
    {
        $points = session('points', $this->startingPoints);

        if ($points < $this->hintCost) {
            return response()->json([
                'success' => false,
                'error' => 'Not enough points!'
            ]);
        }

        $animal = session('animal');
        $hints = session('hints', []);
        $availablePositions = array_diff(range(0, strlen($animal) - 1), $hints);

        if (empty($availablePositions)) {
            return response()->json([
                'success' => false,
                'error' => 'No more hints available!'
            ]);
        }

        $newHintPosition = array_rand($availablePositions);
        $hints[] = $newHintPosition;

        $newPoints = $points - $this->hintCost;

        $this->addTransaction(
            "Purchased hint: Letter '" . $animal[$newHintPosition] . "' at position " . ($newHintPosition + 1),
            -$this->hintCost
        );

        session([
            'points' => $newPoints,
            'hints' => $hints
        ]);

        return response()->json([
            'success' => true,
            'position' => $newHintPosition,
            'letter' => $animal[$newHintPosition],
            'points' => $newPoints
        ]);
    }

    public function newGame($id)
    {
        $this->setupNewGame(Room::findOrFail($id));
        return redirect()->route('multiplayer.index', $id);
    }

    private function setupNewGame($room)
    {
        // Clear all game-related session data
        session()->forget([
            'animal_index',
            'guesses',
            'hints',
            'gameOver',
            'won',
            'characteristicChecks',
            'transactions'
        ]);


        //$animals = Animal::with('category')->get();
        /**
         * @var Animal $randomAnimal
         */
        /*
        $randomAnimal = $this->animals->random();

        $animalName = $randomAnimal->getShortName();
        // or get a full name:
        //$animalName = $randomAnimal->getName();
        $animalHint = $randomAnimal->getInitialHint();
        $animalId = $randomAnimal->getId();
        */

        // Initialize new game session data
        session([
            'animal_index' => -1,
            'transactions' => [],
        ]);

        $this->loadNextRound($room);

        // Add initial transaction
        $this->addTransaction('Started new game', 0);
    }

    private function loadNextRound($room) {
        $animalCount = $room->animals()->count();
        if($animalCount <= session('animal_index')+1)
        {
            return false;
        }
        $next_index = session('animal_index')+1;
        $animal = $room->animals()->skip($next_index)->first();
        session([
            'animal_index' => $next_index,
            'animal_id' => $animal->id,
            'animal' => $animal->getShortName(),
            'initialHint' => $animal->getInitialHint(),
            'points' => $this->startingPoints,
            'characteristicChecks' => 0,
            'guesses' => [],
            'hints' => [],
            'gameOver' => false,
            'won' => false
        ]);
        return true;
    }

    private function checkGuess($guess, $answer)
    {
        $result = [];
        $answerArray = str_split($answer);
        $guessArray = str_split($guess);

        // First pass: mark exact matches
        for ($i = 0; $i < strlen($guess); $i++) {
            if ($guessArray[$i] === $answerArray[$i]) {
                $result[$i] = 'correct';
                $answerArray[$i] = null;  // Mark as used
                $guessArray[$i] = null;   // Mark as used
            } else {
                $result[$i] = 'wrong';
            }
        }

        // Second pass: mark present letters
        for ($i = 0; $i < strlen($guess); $i++) {
            if ($guessArray[$i] !== null) {  // If not already matched
                $pos = array_search($guessArray[$i], $answerArray);
                if ($pos !== false) {
                    $result[$i] = 'present';
                    $answerArray[$pos] = null;  // Mark as used
                }
            }
        }

        // Add a more descriptive transaction message
        $correctCount = count(array_filter($result, fn($r) => $r === 'correct'));
        $presentCount = count(array_filter($result, fn($r) => $r === 'present'));

        $message = "Guess: $guess - ";
        if ($correctCount > 0) {
            $message .= "$correctCount letter" . ($correctCount > 1 ? 's' : '') . " in correct position";
            if ($presentCount > 0) {
                $message .= " and ";
            }
        }
        if ($presentCount > 0) {
            $message .= "$presentCount letter" . ($presentCount > 1 ? 's' : '') . " present but misplaced";
        }
        if ($correctCount === 0 && $presentCount === 0) {
            $message .= "No correct letters";
        }

        $this->addTransaction($message, -$this->wrongGuessDeduction);

        return $result;
    }

    public function checkCharacteristic()
    {
        if (session('characteristicChecks', 0) > 20) {
            return response()->json([
                'error' => 'Maximum characteristic checks reached!',
                'points' => session('points')
            ]);
        }

        session(['characteristicChecks' => session('characteristicChecks', 0) + 1]);

        $characteristic = request('characteristic');
        $animal = session('animal');
        $points = session('points', $this->startingPoints);

        if ($points < $this->characteristicCost) {
            return response()->json([
                'error' => 'Not enough points!',
                'points' => $points
            ]);
        }
        $animalId = session('animal_id');

        /**
         * @var Animal $animal
         */
        $animal = $this->animals->firstWhere('id', $animalId);
        $result =  $animal->getCharacteristic($characteristic) ?? false;
        $newPoints = $points - $this->characteristicCost;
        $gameOver = $newPoints <= 0;

        // More descriptive characteristic message
        $formattedCharacteristic = ucwords(str_replace('_', ' ', $characteristic));
        $this->addTransaction(
            "Checked characteristic: " . $formattedCharacteristic . " - " . ($result ? "Yes" : "No"),

            -$this->characteristicCost
        );

        session([
            'points' => $newPoints,
            'gameOver' => $gameOver,
            'won' => false
        ]);

        return response()->json([
            'result' => $result,
            'points' => $newPoints,
            'gameOver' => $gameOver,
            'transactions' => session('transactions', [])
        ]);
    }

    private function addTransaction($action, $points)
    {
        $transactions = session('transactions', []);
        array_unshift($transactions, [
            'action' => $action,
            'points' => $points,
            'timestamp' => now()->toIso8601String()
        ]);
        session(['transactions' => $transactions]);
    }

    public function revealAnswer()
    {
        $animal = session('animal');
        $points = session('points', 0);

        // Deduct all remaining points as penalty
        $this->addTransaction("Revealed answer: $animal", -$points);

        session([
            'gameOver' => true,
            'won' => false,
            'points' => 0
        ]);

        return back();
    }

}
