<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Animal Guessing Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">Animal Guessing Game</h1>
                <div class="text-2xl font-bold mt-2">
                    <span class="text-blue-600">Points: {{ session('points', 1000) }}</span>
                </div>
            </div>
            <form action="{{ route('game.new') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    New Game
                </button>
            </form>
        </div>

        <div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded mb-4">
            <span class="font-bold">Hint:</span> {{ session('initialHint') }}
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Buy Letter Button -->
        <div class="mb-4">
            <form action="{{ route('game.hint') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600
                        {{ session('points', 1000) < $hintCost ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ session('points', 1000) < $hintCost ? 'disabled' : '' }}>
                    Buy Letter ({{ $hintCost }} points)
                </button>
            </form>
        </div>

        <!-- Characteristics Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4">Check Animal Characteristics ({{ $characteristicCost }} points each):</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                <button onclick="checkCharacteristic('has_legs')" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Has Legs?
                </button>
                <button onclick="checkCharacteristic('has_fur')" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Has Fur?
                </button>
                <button onclick="checkCharacteristic('can_swim')" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Can Swim?
                </button>
                <button onclick="checkCharacteristic('can_fly')" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Can Fly?
                </button>
                <button onclick="checkCharacteristic('is_carnivore')" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Is Carnivore?
                </button>
            </div>
            <div id="characteristic-result" class="mt-4 text-lg font-bold"></div>
        </div>

        <!-- Word Display -->
        <div class="text-center mb-8">
            <div class="text-4xl font-mono space-x-2">
                @php
                    $revealedLetters = session('revealedLetters', []);
                    $hints = session('hints', []);
                    $animal = session('animal');
                    $allRevealed = array_merge($revealedLetters, $hints);
                @endphp
                @foreach(range(0, $wordLength - 1) as $i)
                    <span class="inline-block w-8 pb-2 border-b-2 border-gray-400">
                        @if(in_array($i, $allRevealed))
                            {{ $animal[$i] }}
                        @else
                            _
                        @endif
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Transaction History -->
        @if(session('transactions') && count(session('transactions')))
            <div class="mb-8">
                <h3 class="text-lg font-bold mb-2">Transaction History:</h3>
                <div class="space-y-1 bg-white p-4 rounded-lg shadow">
                    @foreach(session('transactions') as $transaction)
                        <div class="flex justify-between items-center border-b py-2">
                            <span class="text-gray-700">{{ $transaction['action'] }}</span>
                            <span class="font-mono {{ $transaction['points'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction['points'] >= 0 ? '+' : '' }}{{ $transaction['points'] }} points
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Previous Guesses -->
        @if(count($guesses) > 0)
            <div class="mb-8">
                <h3 class="text-lg font-bold mb-2">Previous Guesses:</h3>
                <div class="space-y-1">
                    @foreach($guesses as $guess)
                        <div class="flex space-x-2 bg-gray-200 p-2 rounded">
                            @foreach(str_split($guess['word']) as $index => $letter)
                                <span class="w-8 h-8 flex items-center justify-center rounded
                                    @if($guess['result'][$index] === 'correct') bg-green-500 text-white
                                    @elseif($guess['result'][$index] === 'present') bg-yellow-500 text-white
                                    @else bg-gray-400 text-white
                                    @endif">
                                    {{ $letter }}
                                </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Game Controls -->
        @if(!$gameOver)
            <form action="{{ route('game.guess') }}" method="POST" class="max-w-lg mx-auto">
                @csrf
                <div class="flex gap-2">
                    <input type="text"
                           name="guess"
                           maxlength="{{ $wordLength }}"
                           class="flex-1 p-2 border-2 border-gray-300 rounded"
                           placeholder="Enter your guess"
                           required
                           autocomplete="off">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guess
                    </button>
                </div>
            </form>
        @else
            <div class="text-center">
                @if($won)
                    <p class="text-2xl text-green-500 font-bold">Congratulations! You won!</p>
                @else
                    <p class="text-2xl text-red-500 font-bold">Game Over! The animal was: {{ session('animal') }}</p>
                @endif
            </div>
        @endif
    </div>

    <script>
        function checkCharacteristic(characteristic) {
            fetch(`/game/check`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ characteristic })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('characteristic-result').textContent = data.error;
                } else {
                    document.getElementById('characteristic-result').textContent =
                        `${characteristic.replace(/_/g, ' ')}: ${data.result ? 'Yes' : 'No'}`;
                    document.querySelector('.text-blue-600').textContent = `Points: ${data.points}`;
                }
            });
        }
    </script>
</body>
</html>
