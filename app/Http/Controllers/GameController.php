<?php

namespace App\Http\Controllers;

class GameController extends Controller
{
    private $animals = [
        'LION' => 'King of the jungle',
        'TIGER' => 'Largest wild cat species',
        'ZEBRA' => 'African equine with stripes',
        'GIRAFFE' => 'Tallest living terrestrial animal',
        'ELEPHANT' => 'Largest land mammal',
        'PENGUIN' => 'Flightless aquatic bird',
        'KANGAROO' => 'Marsupial that hops',
        'DOLPHIN' => 'Intelligent marine mammal',
        'PANDA' => 'Black and white bear from China',
        'KOALA' => 'Tree-dwelling marsupial',
        'CHEETAH' => 'Fastest land animal',
        'GORILLA' => 'Largest living primate',
        'RHINO' => 'Horned African mammal',
        'HIPPO' => 'Semi-aquatic African mammal',
        'SLOTH' => 'Slow-moving tree dweller',
        'JAGUAR' => 'Spotted big cat of Americas',
        'OSTRICH' => 'Largest flightless bird',
        'OCTOPUS' => 'Intelligent sea creature',
        'GAZELLE' => 'Swift African antelope',
        'RACCOON' => 'Masked nocturnal mammal'
    ];

    private $hintCost = 200;
    private $characteristicCost = 100;
    private $correctGuessPoints = 500;
    private $wrongGuessDeduction = 50;
    private $startingPoints = 1000;

    private $animalCharacteristics = [
        'LION' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'TIGER' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'ZEBRA' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'GIRAFFE' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'ELEPHANT' => [
            'has_legs' => true,
            'has_fur' => false,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'PENGUIN' => [
            'has_legs' => true,
            'has_fur' => false,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'KANGAROO' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'DOLPHIN' => [
            'has_legs' => false,
            'has_fur' => false,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'PANDA' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'KOALA' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'CHEETAH' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'GORILLA' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'RHINO' => [
            'has_legs' => true,
            'has_fur' => false,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'HIPPO' => [
            'has_legs' => true,
            'has_fur' => false,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'SLOTH' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'JAGUAR' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'OSTRICH' => [
            'has_legs' => true,
            'has_fur' => false,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'OCTOPUS' => [
            'has_legs' => false,
            'has_fur' => false,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ],
        'GAZELLE' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => false,
            'can_fly' => false,
            'is_carnivore' => false
        ],
        'RACCOON' => [
            'has_legs' => true,
            'has_fur' => true,
            'can_swim' => true,
            'can_fly' => false,
            'is_carnivore' => true
        ]
    ];

    public function index()
    {
        if (!session()->has('animal')) {
            $this->startNewGame();
        }

        return view('game', [
            'wordLength' => strlen(session('animal')),
            'guesses' => session('guesses', []),
            'gameOver' => session('gameOver', false),
            'won' => session('won', false),
            'points' => session('points', 1000),
            'hints' => session('hints', []),
            'initialHint' => session('initialHint'),
            'hintCost' => $this->hintCost,
            'characteristicCost' => $this->characteristicCost,
            'maxAttempts' => strlen(session('animal'))
        ]);
    }

    public function guess()
    {
        $guess = strtoupper(request('guess'));
        $animal = session('animal');
        $guesses = session('guesses', []);
        $maxAttempts = strlen($animal);
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
        $gameOver = $won || count($guesses) >= $maxAttempts;

        if ($won) {
            $points += $this->correctGuessPoints;
            $this->addTransaction("Correct guess: $animal", $this->correctGuessPoints);
        } else {
            $points -= $this->wrongGuessDeduction;
            $this->addTransaction("Wrong guess: $guess", -$this->wrongGuessDeduction);
            $this->revealLetter();
        }

        session([
            'guesses' => $guesses,
            'gameOver' => $gameOver,
            'won' => $won,
            'points' => max(0, $points)  // Prevent negative points
        ]);

        return back();
    }

    public function buyHint()
    {
        $points = session('points', 1000);

        if ($points < $this->hintCost) {
            return back()->with('error', 'Not enough points to buy a hint!');
        }

        $animal = session('animal');
        $hints = session('hints', []);
        $availablePositions = array_diff(range(0, strlen($animal) - 1), $hints);

        if (empty($availablePositions)) {
            return back()->with('error', 'No more hints available!');
        }

        $newHintPosition = array_rand($availablePositions);
        $hints[] = $newHintPosition;

        // Add transaction record
        $this->addTransaction(
            "Bought letter hint: " . $animal[$newHintPosition],
            -$this->hintCost
        );

        session([
            'points' => $points - $this->hintCost,
            'hints' => $hints
        ]);

        return back()->with('success', "Revealed letter '" . $animal[$newHintPosition] . "'!");
    }

    public function newGame()
    {
        $this->startNewGame();
        return redirect()->route('game.index');
    }

    private function startNewGame()
    {
        $animalKey = array_rand($this->animals);
        $startingPoints = strlen($animalKey) * 200; // 200 points per letter

        session([
            'animal' => $animalKey,
            'initialHint' => $this->animals[$animalKey],
            'guesses' => [],
            'gameOver' => false,
            'won' => false,
            'points' => $startingPoints,
            'hints' => [],
            'revealedLetters' => [],
            'transactions' => []
        ]);
    }

    private function checkGuess($guess, $answer)
    {
        $result = [];
        $answerArray = str_split($answer);

        for ($i = 0; $i < strlen($guess); $i++) {
            if ($guess[$i] === $answer[$i]) {
                $result[$i] = 'correct';
                $answerArray[$i] = null;
            } else {
                $result[$i] = 'wrong';
            }
        }

        for ($i = 0; $i < strlen($guess); $i++) {
            if ($result[$i] !== 'correct') {
                $pos = array_search($guess[$i], $answerArray);
                if ($pos !== false) {
                    $result[$i] = 'present';
                    $answerArray[$pos] = null;
                }
            }
        }

        return $result;
    }

    public function checkCharacteristic()
    {
        $characteristic = request('characteristic');
        $animal = session('animal');
        $points = session('points', $this->startingPoints);

        if ($points < $this->characteristicCost) {
            return response()->json([
                'error' => 'Not enough points!',
                'points' => $points
            ]);
        }

        $this->addTransaction(
            "Checked characteristic: " . str_replace('_', ' ', $characteristic),
            -$this->characteristicCost
        );

        session(['points' => $points - $this->characteristicCost]);

        return response()->json([
            'result' => $this->animalCharacteristics[$animal][$characteristic] ?? false,
            'points' => $points - $this->characteristicCost
        ]);
    }

    private function revealLetter()
    {
        $animal = session('animal');
        $revealedLetters = session('revealedLetters', []);
        $availablePositions = array_diff(range(0, strlen($animal) - 1), $revealedLetters);

        if (!empty($availablePositions)) {
            $newPosition = array_rand($availablePositions);
            $revealedLetters[] = $newPosition;
            session(['revealedLetters' => $revealedLetters]);
        }
    }

    private function addTransaction($action, $points)
    {
        $transactions = session('transactions', []);
        $transactions[] = [
            'action' => $action,
            'points' => $points,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ];
        session(['transactions' => $transactions]);
    }
}
