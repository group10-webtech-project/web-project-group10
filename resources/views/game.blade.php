<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Animal Guessing Game</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">Animal Guessing Game</h1>
                <div class="text-2xl font-bold mt-2">
                    <span class="badge badge-primary badge-lg">Points: {{ session('points', 1000) }}</span>
                </div>
            </div>
            <form action="{{ route('game.new') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-success">
                    New Game
                </button>
            </form>
        </div>

        <!-- Hint Section -->
        <div class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('initialHint') }}</span>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Buy Letter Button -->
        <div class="mb-4">
            <form action="{{ route('game.hint') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="btn btn-secondary {{ session('points', 1000) < $hintCost ? 'btn-disabled' : '' }}"
                    {{ session('points', 1000) < $hintCost ? 'disabled' : '' }}>
                    Buy Letter ({{ $hintCost }} points)
                </button>
            </form>
        </div>

        <!-- Characteristics Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4">Check Animal Characteristics ({{ $characteristicCost }} points each):</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                <button onclick="checkCharacteristic('has_legs')" class="btn btn-primary">Has Legs?</button>
                <button onclick="checkCharacteristic('has_fur')" class="btn btn-primary">Has Fur?</button>
                <button onclick="checkCharacteristic('can_swim')" class="btn btn-primary">Can Swim?</button>
                <button onclick="checkCharacteristic('can_fly')" class="btn btn-primary">Can Fly?</button>
                <button onclick="checkCharacteristic('is_carnivore')" class="btn btn-primary">Is Carnivore?</button>
            </div>
            <div id="characteristic-result" class="mt-4 text-lg font-bold"></div>
        </div>

        <!-- Word Display -->
        <div class="text-center mb-8">
            <div class="join">
                @php
                    $revealedLetters = session('revealedLetters', []);
                    $hints = session('hints', []);
                    $animal = session('animal');
                    $allRevealed = array_merge($revealedLetters, $hints);
                @endphp
                @foreach(range(0, $wordLength - 1) as $i)
                    <div class="join-item btn btn-square text-2xl font-mono {{ in_array($i, $allRevealed) ? 'btn-active' : 'btn-outline' }}">
                        {{ in_array($i, $allRevealed) ? $animal[$i] : '_' }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Transaction History -->
        @if(session('transactions') && count(session('transactions')))
            <div class="mb-8">
                <h3 class="text-lg font-bold mb-2">Transaction History:</h3>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        @foreach(session('transactions') as $transaction)
                            <div class="flex justify-between items-center border-b py-2">
                                <span>{{ $transaction['action'] }}</span>
                                <span class="font-mono {{ $transaction['points'] >= 0 ? 'text-success' : 'text-error' }}">
                                    {{ $transaction['points'] >= 0 ? '+' : '' }}{{ $transaction['points'] }} points
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Previous Guesses -->
        @if(count($guesses) > 0)
            <div class="mb-8">
                <h3 class="text-lg font-bold mb-2">Previous Guesses:</h3>
                <div class="space-y-2">
                    @foreach($guesses as $guess)
                        <div class="join">
                            @foreach(str_split($guess['word']) as $index => $letter)
                                <div class="join-item btn {{
                                    $guess['result'][$index] === 'correct' ? 'btn-success' :
                                    ($guess['result'][$index] === 'present' ? 'btn-warning' : 'btn-neutral')
                                }}">
                                    {{ $letter }}
                                </div>
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
                <div class="join w-full">
                    <input type="text"
                           name="guess"
                           maxlength="{{ $wordLength }}"
                           class="join-item input input-bordered flex-1"
                           placeholder="Enter your guess"
                           required
                           autocomplete="off">
                    <button type="submit" class="join-item btn btn-primary">
                        Guess
                    </button>
                </div>
            </form>
        @else
            <div class="text-center">
                @if($won)
                    <div class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-2xl">Congratulations! You won!</span>
                    </div>
                @else
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-2xl">Game Over! The animal was: {{ session('animal') }}</span>
                    </div>
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
                    document.querySelector('.badge-primary').textContent = `Points: ${data.points}`;
                }
            });
        }
    </script>
</body>
</html>
