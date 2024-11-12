<!DOCTYPE html>
<html lang="en" data-theme="fantasy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nerdle</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-primary/10 via-base-100 to-secondary/10">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="game-container p-8 mb-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-5xl font-bold text-primary">🎮 Nerdle</h1>
                    <div class="text-2xl font-bold mt-2">
                        <span class="badge badge-primary badge-lg text-2xl p-4">
                            ✨ Points: {{ session('points', 1000) }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('game.new') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg hover:scale-105 transition-transform duration-200">
                        🎲 New Game
                    </button>
                </form>
            </div>

            <!-- Hint Section -->
            <div class="alert alert-info mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-lg">{{ session('initialHint') }}</span>
            </div>

            <!-- Word Display with Animation -->
            <div class="text-center mb-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="join">
                        @php
                            $revealedLetters = session('revealedLetters', []);
                            $hints = session('hints', []);
                            $animal = session('animal');
                            $allRevealed = array_merge($revealedLetters, $hints);
                        @endphp
                        @foreach(range(0, $wordLength - 1) as $i)
                            <div class="transform transition-all duration-300 hover:scale-110">
                                <div class="join-item btn btn-square text-3xl font-mono {{ in_array($i, $allRevealed) ? 'btn-active animate-pulse' : 'btn-outline hover:animate-pulse' }}">
                                    {{ in_array($i, $allRevealed) ? $animal[$i] : '_' }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Buy Letter Button -->
                    <button form="hint-form"
                            class="btn btn-secondary btn-lg {{ session('points', 1000) < $hintCost ? 'btn-disabled' : 'hover:scale-105 transition-transform duration-200' }}"
                            {{ session('points', 1000) < $hintCost ? 'disabled' : '' }}>
                        <span class="text-xl mr-2">💡</span>
                        Buy Letter ({{ $hintCost }} points)
                    </button>
                    <form id="hint-form" action="{{ route('game.hint') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>

            <!-- Characteristics Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4 text-secondary">
                    🔍 Check Animal Characteristics ({{ $characteristicCost }} points each):
                </h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                    @foreach([
                        ['has_legs', '🦿', 'Has Legs?'],
                        ['has_fur', '🦊', 'Has Fur?'],
                        ['can_swim', '🏊‍♂️', 'Can Swim?'],
                        ['can_fly', '🦅', 'Can Fly?'],
                        ['is_carnivore', '🥩', 'Is Carnivore?']
                    ] as [$characteristic, $emoji, $label])
                        <button onclick="checkCharacteristic('{{ $characteristic }}')"
                                class="btn btn-primary hover:scale-105 transition-transform duration-200 shadow-lg">
                            <span class="text-xl mr-2">{{ $emoji }}</span>
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <div id="characteristic-result" class="mt-4 text-lg font-bold animate-pulse"></div>
            </div>

            <!-- Game Controls -->
            @if(!$gameOver)
                <div class="max-w-lg mx-auto mb-8">
                    <form action="{{ route('game.guess') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="join w-full shadow-lg">
                            <input type="text"
                                   name="guess"
                                   maxlength="{{ $wordLength }}"
                                   class="join-item input input-bordered input-lg flex-1 text-lg"
                                   placeholder="Enter your guess"
                                   required
                                   autocomplete="off">
                            <button type="submit" class="join-item btn btn-primary btn-lg hover:scale-105 transition-transform duration-200">
                                <span class="text-xl mr-2">🎯</span>
                                Guess
                            </button>
                        </div>
                    </form>

                    <!-- Give Up Button -->
                    <form action="{{ route('game.reveal') }}" method="POST" class="text-center"
                          onsubmit="return confirm('Are you sure you want to give up? This will end the game and deduct all your remaining points!')">
                        @csrf
                        <button type="submit" class="btn btn-error btn-outline btn-lg hover:scale-105 transition-transform duration-200">
                            <span class="text-xl mr-2">🏳️</span>
                            I Give Up (-{{ session('points', 0) }} points)
                        </button>
                    </form>
                </div>
            @endif

            <!-- Previous Guesses -->
            @if(count($guesses) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-bold mb-2">
                        <span class="text-xl mr-2">📝</span>
                        Previous Guesses:
                    </h3>
                    <div class="space-y-2">
                        @foreach($guesses as $guess)
                            <div class="join animate-fade-in">
                                @foreach(str_split($guess['word']) as $index => $letter)
                                    <div class="join-item btn hover:scale-105 transition-transform duration-200 {{
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

            <!-- Transaction History -->
            <div class="mb-8" id="transaction-history">
                <h3 class="text-lg font-bold mb-2">
                    <span class="text-xl mr-2">💰</span>
                    Transaction History:
                </h3>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body" id="transaction-list">
                        @foreach(session('transactions', []) as $index => $transaction)
                            <div class="flex justify-between items-center border-b py-2 hover:bg-base-200 transition-all duration-300 ease-in-out transform hover:-translate-x-1
                                {{ $index === count(session('transactions')) - 1 ? 'animate-slide-in' : '' }}">
                                <span>{{ $transaction['action'] }}</span>
                                <span class="font-mono {{ $transaction['points'] >= 0 ? 'text-success' : 'text-error' }}">
                                    {{ $transaction['points'] >= 0 ? '+' : '' }}{{ $transaction['points'] }} points
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Game Over Message -->
            @if($gameOver)
                <!-- Full screen overlay for game over -->
                <div class="fixed inset-0 bg-black/50 z-40" id="game-over-overlay"></div>

                <div class="text-center fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-2xl">
                    @if($won)
                        <div class="alert alert-success shadow-lg" id="win-message">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-2xl">Congratulations! You won!</span>
                        </div>
                    @else
                        <div class="alert alert-error shadow-lg relative overflow-hidden" id="lose-message">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 relative z-10" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-2xl relative z-10">
                                Game Over!
                                @if(session('points', 0) <= 0)
                                    You ran out of points!
                                @endif
                                The animal was: {{ session('animal') }}
                            </span>
                        </div>
                    @endif

                    <!-- New Game button in game over screen -->
                    <form action="{{ route('game.new') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            🎲 Play Again
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        function checkCharacteristic(characteristic) {
            const btn = event.target.closest('button');
            btn.classList.add('loading');

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
                btn.classList.remove('loading');
                if (data.error) {
                    document.getElementById('characteristic-result').textContent = data.error;
                } else {
                    document.querySelector('.badge-primary').textContent = `✨ Points: ${data.points}`;

                    const transactionList = document.getElementById('transaction-list');
                    const latestTransaction = data.transactions[data.transactions.length - 1];

                    const div = document.createElement('div');
                    div.className = 'flex justify-between items-center border-b py-2 hover:bg-base-200 transition-all duration-300 ease-in-out transform hover:-translate-x-1 opacity-0';
                    div.style.animation = 'slideIn 0.3s ease-out forwards';
                    div.innerHTML = `
                        <span>${latestTransaction.action}</span>
                        <span class="font-mono ${latestTransaction.points >= 0 ? 'text-success' : 'text-error'}">
                            ${latestTransaction.points >= 0 ? '+' : ''}${latestTransaction.points} points
                        </span>
                    `;

                    transactionList.insertBefore(div, transactionList.firstChild);

                    const allTransactions = transactionList.querySelectorAll('div');
                    for (let i = 1; i < allTransactions.length; i++) {
                        allTransactions[i].style.animation = 'none';
                    }
                }

                if (data.gameOver) {
                    location.reload();
                }
            });
        }

        // Function to trigger confetti
        function triggerWinAnimation() {
            const duration = 3000;
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                const particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
                }));
            }, 250);
        }

        // Function to trigger lose animation
        function triggerLoseAnimation() {
            // Create rain drops for the entire screen
            for (let i = 0; i < 50; i++) { // Increased number of drops
                const drop = document.createElement('div');
                drop.className = 'rain-drop';
                drop.style.left = `${Math.random() * 100}vw`;
                drop.style.animationDuration = `${Math.random() * 1 + 0.5}s`;
                drop.style.animationDelay = `${Math.random() * 2}s`;
                document.body.appendChild(drop);
            }
        }

        // Check if game is over and trigger appropriate animation
        document.addEventListener('DOMContentLoaded', function() {
            const winMessage = document.getElementById('win-message');
            const loseMessage = document.getElementById('lose-message');

            if (winMessage) {
                triggerWinAnimation();
            } else if (loseMessage) {
                triggerLoseAnimation();
            }
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes rain {
            0% {
                transform: translateY(-100vh);
            }
            100% {
                transform: translateY(100vh);
            }
        }

        .rain-drop {
            position: fixed; /* Changed from absolute to fixed */
            width: 2px;
            height: 100px;
            background: linear-gradient(transparent, #666);
            animation: rain linear infinite;
            z-index: 45; /* Between overlay and message */
        }

        #game-over-overlay {
            backdrop-filter: blur(2px);
            transition: all 0.3s ease;
        }
    </style>
</body>
</html>
