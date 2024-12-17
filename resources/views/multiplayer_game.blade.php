@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <!-- Header Section -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body p-4 sm:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold">Hi, {{ $playerName }}! 👋</h2>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-4">
                    <div class="badge badge-primary badge-lg text-lg sm:text-2xl p-4">
                        ✨ Points: {{ session('points', 500) }}
                    </div>
                </div>
                <div id="timer">
                    Timer
                </div>
            </div>

            <!-- Game Info -->
            <div class="alert alert-info mt-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-bold">{{ session('initialHint') }}</h3>
                    <div class="text-sm">Remaining Guesses: {{ 5 - count($guesses) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Game Grid -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body p-4 sm:p-8">
            <!-- Previous Guesses -->
            @foreach($guesses as $guess)
                <div class="flex justify-center gap-1 sm:gap-2 mb-2">
                    @foreach(str_split($guess['word']) as $index => $letter)
                        <div @class([
                            'w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center text-2xl sm:text-3xl font-bold rounded-lg',
                            'bg-success text-success-content' => $guess['result'][$index] === 'correct',
                            'bg-warning text-warning-content' => $guess['result'][$index] === 'present',
                            'bg-neutral text-neutral-content' => $guess['result'][$index] === 'wrong'
                        ])>
                            {{ $letter }}
                        </div>
                    @endforeach
                </div>
            @endforeach

            <!-- Current Input Row -->
            @if(!$gameOver && count($guesses) < 5)
                <form action="{{ route('multiplayer.guess', $room->id) }}" method="POST" class="mb-2">
                    @csrf
                    <div class="flex justify-center gap-1 sm:gap-2 bg-base-200 rounded-lg p-2">
                        @for($i = 0; $i < $wordLength; $i++)
                            <input type="text"
                                   maxlength="1"
                                   class="w-12 h-12 sm:w-16 sm:h-16 text-center text-2xl sm:text-3xl font-bold uppercase input input-bordered focus:input-primary rounded-lg"
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
                <div class="flex justify-center gap-1 sm:gap-2 mb-2">
                    @for($j = 0; $j < $wordLength; $j++)
                        <div class="w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center text-2xl sm:text-3xl font-bold rounded-lg bg-base-200 opacity-30">
                            ?
                        </div>
                    @endfor
                </div>
            @endfor

            <!-- Guess Button -->
            @if(!$gameOver && count($guesses) < 5)
                <div class="flex justify-center mt-4">
                    <button onclick="submitGuess()"
                            class="btn btn-primary btn-lg gap-2 hover:scale-105 transition-transform duration-200">
                        <span>Make Guess</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Game Controls -->
    @if(!$gameOver)
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body p-4 sm:p-8">
                <h2 class="card-title text-xl sm:text-2xl font-bold text-secondary mb-4">
                    🏪 Hint Store
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-4">
                    <form action="{{ route('multiplayer.hint', $room->id) }}" method="POST" class="contents" id="hintForm">
                        @csrf
                        <button type="button"
                                onclick="buyHint()"
                                class="btn btn-secondary hover:scale-105 transition-transform duration-200 shadow-lg {{ session('points', 1000) < $hintCost ? 'btn-disabled' : '' }}"
                                {{ session('points', 1000) < $hintCost ? 'disabled' : '' }}>
                            <div class="flex flex-col items-center">
                                <span class="text-xl sm:text-2xl">💰</span>
                                <span class="text-xs sm:text-sm">Buy Letter</span>
                                <span class="badge badge-sm mt-1">{{ $hintCost }}</span>
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
                                <span class="text-xl sm:text-2xl">{{ $emoji }}</span>
                                <span class="text-xs sm:text-sm">{{ $label }}</span>
                                <span class="badge badge-sm mt-1">{{ $characteristicCost }}</span>
                            </div>
                        </button>
                    @endforeach
                </div>
                <div id="characteristic-result" class="mt-4 text-lg font-bold animate-pulse"></div>
            </div>
        </div>
    @endif

    <!-- Transaction History -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body p-4 sm:p-8">
            <h3 class="card-title text-lg font-bold mb-2">
                <span class="text-xl mr-2">💰</span>
                Transaction History
            </h3>
            <div class="overflow-y-auto max-h-48">
                <div id="transaction-list" class="space-y-2">
                    @foreach(session('transactions', []) as $transaction)
                        <div class="flex justify-between items-center p-2 hover:bg-base-200 rounded-lg transition-colors">
                            <div class="flex flex-col">
                                <span class="text-sm">{{ $transaction['action'] }}</span>
                                <span class="text-xs text-base-content/70">
                                    {{ \Carbon\Carbon::parse($transaction['timestamp'])->diffForHumans() }}
                                </span>
                            </div>
                            <span class="font-mono {{ $transaction['points'] >= 0 ? 'text-success' : 'text-error' }}">
                                {{ $transaction['points'] >= 0 ? '+' : '' }}{{ $transaction['points'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Game Over Modal -->
    @if($gameOver)
        <script>
            // Clear hints when game is over
            localStorage.removeItem('hints');
        </script>
        <div class="fixed inset-0 bg-black/50 z-40" id="game-over-overlay"></div>
   @endif
</div>

@endsection

<script>
    const room = @json($room);
    let remaining_seconds = @json($remainingSeconds);
    let timer = null;
    console.log(timer);
    const interval = setInterval(() => {
        const minutes = Math.floor(remaining_seconds / 60);
        const seconds = Math.floor(remaining_seconds % 60);

        timer.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        remaining_seconds--;

        if (remaining_seconds < 0) {
            clearInterval(interval);
            timer.innerHTML = "Game ended";
        }
    }, 1000);


function submitGuess() {
    if (!allInputsFilled()) {
        alert('Please fill in all letters');
        return;
    }

    const inputs = Array.from(document.querySelectorAll('[data-position]'));
    const guess = inputs.map(input => input.value.toUpperCase()).join('');
    document.getElementById('finalGuess').value = guess;

    const form = document.querySelector('form[action*="guess"]');
    const formData = new FormData(form);

    fetch('{{ route('multiplayer.guess', $room->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear hints if game is over
            console.log(data);
            if (data.roundOver) {
                localStorage.removeItem('hints');
            }
            // Animate each letter before reloading
            inputs.forEach((input, index) => {
                input.classList.add('flip-card');
                input.style.animationDelay = `${index * 0.2}s`;
            });

            // Reload after all animations complete
            setTimeout(() => {
                if(data.gameOver) {
                    window.location.href = "{{ route('rooms.finish', ['id' => $room->id]) }}";
                }
                else {
                    location.reload();
                }
            }, (inputs.length * 0.2 + 0.5) * 1000);
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your guess');
    });
}

function handleKeyUp(event, currentInput, position, maxLength) {
    currentInput.value = currentInput.value.toUpperCase();

    if (event.key === 'Enter') {
        submitGuess();
        return;
    }

    if (currentInput.value.length === 1 && position < maxLength - 1) {
        const nextInput = document.querySelector(`[data-position="${position + 1}"]`);
        if (nextInput) nextInput.focus();
    }
}

function allInputsFilled() {
    const inputs = document.querySelectorAll('[data-position]');
    return Array.from(inputs).every(input => input.value.length === 1);
}

function buyHint() {
    const form = document.getElementById('hintForm');

    fetch('{{ route('multiplayer.hint', $room->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update points display
            document.querySelector('.badge-primary').textContent = `✨ Points: ${data.points}`;

            // Find input at the hint position
            const input = document.querySelector(`[data-position="${data.position}"]`);

            if (input) {
                // Remove any existing animation class
                input.classList.remove('flip-card');
                // Force reflow
                void input.offsetWidth;
                // Add animation class
                input.classList.add('flip-card');

                // Set the letter value and disable the input
                input.value = data.letter;
                input.disabled = true;

                // Store hint in local storage
                const hints = JSON.parse(localStorage.getItem('hints') || '{}');
                hints[data.position] = data.letter;
                localStorage.setItem('hints', JSON.stringify(hints));
            }
        } else {
            alert(data.error || 'Not enough points!');
        }
    });
}

// Add this to restore hints after page reload
document.addEventListener('DOMContentLoaded', function() {
    timer = document.getElementById("timer");
    window.Echo.private(`rooms.${room.id}`)
        .listen('GameEnded', (room) => {
            window.location.href = "{{ route('rooms.finish', ['id' => $room->id]) }}";
        });
    const hints = JSON.parse(localStorage.getItem('hints') || '{}');
    Object.entries(hints).forEach(([position, letter]) => {
        const input = document.querySelector(`[data-position="${position}"]`);
        if (input) {
            input.value = letter;
            input.disabled = true;
        }
    });
});

function checkCharacteristic(characteristic) {
    fetch('{{ route('multiplayer.checkCharacteristic', $room->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ characteristic })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.querySelector('.badge-primary').textContent = `✨ Points: ${data.points}`;
            const resultDiv = document.getElementById('characteristic-result');
            resultDiv.textContent = `${characteristic.replace('_', ' ')}: ${data.result ? 'Yes' : 'No'}`;

            // Refresh the page to update transaction history
            location.reload();
        }
    });
}
</script>

<style>
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
    animation-fill-mode: both;
}

/* Color hints for guesses */
.bg-success {
    transition: background-color 0.3s ease;
}

.bg-warning {
    transition: background-color 0.3s ease;
}

.bg-neutral {
    transition: background-color 0.3s ease;
}

/* Add these new animations */
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

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Enhanced input styling */
.input {
    transition: all 0.3s ease;
    text-transform: uppercase;
    width: 4rem !important;
    height: 4rem !important;
    font-size: 2rem !important;
}

.input:focus {
    transform: scale(1.1);
    outline: none;
    border-color: hsl(var(--p));
    box-shadow: 0 0 0 2px hsl(var(--p) / 20%);
}

.input:invalid {
    animation: shake 0.3s ease-in-out;
    border-color: hsl(var(--er));
}
</style>
