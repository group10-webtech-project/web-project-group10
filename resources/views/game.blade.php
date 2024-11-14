<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'fantasy') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nerdle</title>
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-primary/10 via-base-100 to-secondary/10">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="game-container p-8 mb-8">
            <div class="flex justify-between items-center mb-8">

                <div class="flex items-center gap-4">
                    <img src="{{ asset('icon.svg') }}" alt="Game Icon" class="w-24 h-24">
                    <h1 class="text-5xl font-bold text-primary">Nerdle</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="badge badge-primary badge-lg text-2xl p-4">
                        ✨ Points: {{ session('points', 500) }}
                    </span>
                    <button onclick="toggleTheme()" class="btn btn-circle btn-ghost swap swap-rotate" id="theme-toggle">
                        <!-- sun icon -->
                        <svg class="swap-on fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                        </svg>
                        <!-- moon icon -->
                        <svg class="swap-off fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                        </svg>
                    </button>
                    <form action="{{ route('game.new') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg hover:scale-105 transition-transform duration-200">
                            🎲 New Game
                        </button>
                    </form>
                </div>
            </div>

            <!-- Game Info -->
            <div class="alert alert-info mb-6 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-bold">{{ session('initialHint') }}</h3>
                    <div class="text-sm">Remaining Guesses: {{ 5 - count($guesses) }}</div>
                </div>
            </div>

            <!-- Main Game Grid -->
            <div class="mb-6">
                <!-- Previous Guesses -->
                @foreach($guesses as $guess)
                    <div class="flex justify-center gap-2 mb-2">
                        @foreach(str_split($guess['word']) as $index => $letter)
                            <div class="w-16 h-16 flex items-center justify-center text-3xl font-bold rounded-lg flip-card
                                {{ $guess['result'][$index] === 'correct' ? 'bg-success text-success-content' :
                                   ($guess['result'][$index] === 'present' ? 'bg-warning text-warning-content' : 'bg-neutral text-neutral-content') }}"
                                style="animation-delay: {{ $index * 0.2 }}s">
                                {{ $letter }}
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <!-- Current Input Row (if game not over) -->
                @if(!$gameOver && count($guesses) < 5)
                    <form action="{{ route('game.guess') }}" method="POST" class="mb-2">
                        @csrf
                        <div class="flex justify-center gap-2">
                            @for($i = 0; $i < $wordLength; $i++)
                                <input type="text"
                                       maxlength="1"
                                       class="w-16 h-16 text-center text-3xl font-bold uppercase input input-bordered focus:input-primary rounded-lg"
                                       data-position="{{ $i }}"
                                       required
                                       pattern="[A-Za-z]"
                                       autocomplete="off"
                                       onkeyup="handleKeyUp(event, this, {{ $i }}, {{ $wordLength }})"
                                       onclick="this.select()">
                            @endfor
                        </div>
                        <input type="hidden" name="guess" id="finalGuess">
                    </form>
                @endif

                <!-- Remaining Empty Rows -->
                @for($i = count($guesses) + ($gameOver ? 0 : 1); $i < 5; $i++)
                    <div class="flex justify-center gap-2 mb-2">
                        @for($j = 0; $j < strlen(session('animal')); $j++)
                            <div class="w-16 h-16 flex items-center justify-center text-3xl font-bold rounded-lg bg-base-200 opacity-30">
                                ?
                            </div>
                        @endfor
                    </div>
                @endfor

                <!-- Add the guess button after all guess rows -->
                @if(!$gameOver && count($guesses) < 5)
                    <div class="flex justify-center mt-4 mb-8">
                        <button onclick="submitGuess()"
                                class="btn btn-primary btn-lg gap-2 hover:scale-105 transition-transform duration-200">
                            <span>Make Guess</span>
                            <kbd class="kbd kbd-sm">↵</kbd>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Game Controls -->
            @if(!$gameOver)
                <div class="mb-8">
                    <div class="card bg-base-200 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title text-2xl font-bold text-secondary mb-4">
                                🏪 Hint Store
                            </h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                                <form action="{{ route('game.hint') }}" method="POST" class="contents" id="hintForm">
                                    @csrf
                                    <button type="button"
                                            onclick="buyHint()"
                                            class="btn btn-secondary hover:scale-105 transition-transform duration-200 shadow-lg {{ session('points', 1000) < $hintCost ? 'btn-disabled' : '' }}"
                                            {{ session('points', 1000) < $hintCost ? 'disabled' : '' }}>
                                        <div class="flex flex-col items-center">
                                            <span class="text-2xl">💰</span>
                                            <span>Buy Letter</span>
                                            <span class="badge badge-sm mt-1">{{ $hintCost }} points</span>
                                        </div>
                                    </button>
                                </form>

                                @foreach([
                                    ['has_legs', '🦿', 'Has Legs?'],
                                    ['has_fur', '🦊', 'Has Fur?'],
                                    ['can_swim', '🏊‍♂️', 'Can Swim?'],
                                    ['can_fly', '🦅', 'Can Fly?'],
                                    ['is_carnivore', '🥩', 'Is Carnivore?']
                                ] as [$characteristic, $emoji, $label])
                                    <button onclick="checkCharacteristic('{{ $characteristic }}')"
                                            class="btn btn-primary hover:scale-105 transition-transform duration-200 shadow-lg">
                                        <div class="flex flex-col items-center">
                                            <span class="text-2xl">{{ $emoji }}</span>
                                            <span>{{ $label }}</span>
                                            <span class="badge badge-sm mt-1">{{ $characteristicCost }} points</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            <div id="characteristic-result" class="mt-4 text-lg font-bold animate-pulse"></div>
                        </div>
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
                            <div class="flex justify-between items-center border-b py-2 hover:bg-base-200">
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


                    // Refresh the entire transaction list
                    const transactionList = document.getElementById('transaction-list');
                    transactionList.innerHTML = data.transactions.reverse().map(transaction => `
                        <div class="flex justify-between items-center border-b py-2 hover:bg-base-200 transition-all duration-200">
                            <span class="text-sm">${transaction.timestamp} - ${transaction.action}</span>
                            <span class="font-mono ${transaction.points >= 0 ? 'text-success' : 'text-error'}">
                                ${transaction.points >= 0 ? '+' : ''}${transaction.points} points
                            </span>
                        </div>
                    `).join('');
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

        function handleKeyUp(event, currentInput, position, maxLength) {
            // Convert input to uppercase
            currentInput.value = currentInput.value.toUpperCase();

            // Handle different key presses
            switch (event.key) {
                case 'Enter':
                    if (allInputsFilled()) {
                        submitGuess();
                    }
                    break;

                case 'Backspace':
                    if (currentInput.value.length === 0 && position > 0) {
                        moveFocus(position - 1);
                    }
                    break;

                default:
                    // Move to next input when a letter is entered
                    if (currentInput.value.length === 1) {
                        if (position < maxLength - 1) {
                            moveFocus(position + 1);
                        }
                    }
                    break;
            }
        }

        function moveFocus(position) {
            const nextInput = document.querySelector(`[data-position="${position}"]`);
            if (nextInput) {
                nextInput.focus();
                nextInput.select();
            }
        }

        function allInputsFilled() {
            const inputs = Array.from(document.querySelectorAll('[data-position]'));
            return !inputs.some(input => !input.value);
        }

        function submitGuess() {
            if (!allInputsFilled()) {
                alert('Please fill in all letters');
                return false;
            }

            const inputs = Array.from(document.querySelectorAll('[data-position]'));
            const guess = inputs.map(input => input.value.toUpperCase()).join('');
            document.getElementById('finalGuess').value = guess;
            console.log(guess);

            const form = document.querySelector('form[action*="guess"]');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const currentTheme = document.querySelector('html').getAttribute('data-theme');
                    localStorage.setItem('theme', currentTheme);
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

            return false;
        }

        // Update the newGame function to preserve theme
        document.querySelector('form[action*="game.new"]').addEventListener('submit', function(e) {
            const currentTheme = localStorage.getItem('theme') || 'fantasy';
            const themeInput = document.createElement('input');
            themeInput.type = 'hidden';
            themeInput.name = 'theme';
            themeInput.value = currentTheme;
            this.appendChild(themeInput);
        });

        function buyHint() {
            const form = document.getElementById('hintForm');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update points display
                    document.querySelector('.badge-primary').textContent = `✨ Points: ${data.points}`;

                    // Fill in the letter in the current guess row
                    const input = document.querySelector(`[data-position="${data.position}"]`);
                    if (input) {
                        input.value = data.letter;
                        input.disabled = true;
                    }
                }
            });
        }

        function giveUp() {
            if (!confirm('Are you sure you want to give up? You will lose all remaining points.')) {
                return;
            }

            fetch('/game/give-up', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reveal the answer
                    alert(`The animal was: ${data.animal}`);
                    // Refresh the page or update the UI to show game over state
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Theme toggle functionality
        function toggleTheme() {
            const html = document.querySelector('html');
            const themeToggle = document.getElementById('theme-toggle');
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'fantasy' ? 'dark' : 'fantasy';

            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            if (newTheme === 'dark') {
                themeToggle.classList.add('swap-active');
            } else {
                themeToggle.classList.remove('swap-active');
            }

            // Save theme to session
            fetch('/set-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ theme: newTheme })
            });
        }

        // Apply saved theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = '{{ session('theme', 'fantasy') }}';
            const html = document.querySelector('html');
            const themeToggle = document.getElementById('theme-toggle');

            html.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                themeToggle.classList.add('swap-active');

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

        /* Add these styles for the input boxes */
        .input {
            transition: all 0.3s ease;
            text-transform: uppercase;
            width: 4rem !important; /* Force wider boxes */
            height: 4rem !important;
            font-size: 2rem !important;
        }

        .input:focus {
            transform: scale(1.1);
            outline: none;
            border-color: hsl(var(--p));
            box-shadow: 0 0 0 2px hsl(var(--p) / 20%);
        }

        /* Add a shake animation for invalid input */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .input:invalid {
            animation: shake 0.3s ease-in-out;
            border-color: hsl(var(--er));
        }

        /* Add smooth transition for theme changes */
        html {
            transition: all 0.3s ease;
        }

        /* Style for the theme toggle button */
        .swap {
            transition: transform 0.3s ease;
        }

        .swap:hover {
            transform: scale(1.1);
        }

        .swap-active .swap-on {
            display: block;
        }

        .swap-active .swap-off {
            display: none;
        }

        @keyframes flipIn {
            0% {
                transform: rotateX(0deg);
                background-color: hsl(var(--b2));
            }
            45% {
                transform: rotateX(90deg);
                background-color: hsl(var(--b2));
            }
            55% {
                transform: rotateX(90deg);
            }
            100% {
                transform: rotateX(0deg);
            }
        }

        .flip-card {
            animation: flipIn 0.6s ease-in-out forwards;
            backface-visibility: hidden;
            transform-origin: center;
        }

        /* Preserve animation state */
        .flip-card {
            animation-fill-mode: both;
        }

        /* Update theme transition */
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Ensure inputs maintain theme */
        .input {
            transition: all 0.3s ease;
            background-color: hsl(var(--b1));
            color: hsl(var(--bc));
        }

    </style>
</body>
</html>
