@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    Room code: {{ $room->room_code }}
    <?php if ($user->id == $room->admin_id && !$room->active): ?>
        <form id="config" class="space-y-4">
            <div class="max-w-3xl">
                <div>
                    <label for="number_of_animals" class="block max-w-xs text-sm font-medium text-gray-700">Number of Animals to Guess</label>
                    <input type="number" name="number_of_animals" id="number_of_animals"
                        class="input input-bordered w-48"
                        value="{{ old('number_of_animals', 5) }}" min="1" max="{{ $animalCount }}" required>
                    @error('number_of_animals')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-2xl">
                    <label for="minutes" class="block max-w-xs text-sm font-medium text-gray-700">Time Limit (mm:ss)</label>
                    <input type="number" name="minutes" id="minutes"
                        class="input input-bordered w-16 max-w-xs"
                        value="{{ old('minutes', 2) }}" min="1" max="60" required>
                    @error('minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    :
                    <input type="number" name="seconds" id="seconds"
                        class="input input-bordered w-16 max-w-xs"
                        value="{{ old('seconds', 0) }}" min="0" max="59" required>
                    @error('seconds')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                <button onclick="startGame()" class="flex-1 my-auto btn btn-success gap-2 hover:scale-105 transition-transform duration-200">
                    <span class="hidden sm:inline">Start</span>
                </button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Name</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->current_room_score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="fixed inset-0 bg-black/50 z-40" style="display: none" id="win-message">
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-xl px-4">
            <div class="bg-green-400 rounded-md shadow-lg h-20">
                <span class="max-h-20 w-full absolute text-center text-xl sm:text-2xl top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">Congratulations!<br>{{ $users[0]->name }} won!</span>
            </div>
        </div>
    </div>
</div>

<script>
    const room = @json($room);

    document.addEventListener('DOMContentLoaded', () => { //after echo loaded
        window.Echo.private(`rooms.${room.id}`)
            .listen('UserJoined', (user) => {
                console.log(user);
                if(user.id != "{{ $user->id }}")
                {
                    location.reload();
                }
            }).listen('GameStart', (e) => {
                console.log("start");
                localStorage.removeItem('hints');
                window.location.href = "{{ route('multiplayer.newGame', ['id' => $room->id]) }}";
                console.log(e);
            }).listen('GameEnded', (e) => {
                const win_msg = document.getElementById("win-message");
                win_msg.style.display = "block";
                win_msg.classList.remove("fade-in-item");
                void win_msg.offsetWidth;
                win_msg.classList.add("fade-in-item");

                setTimeout(() => {
                    win_msg.classList.remove("fade-out-item");
                    void win_msg.offsetWidth;
                    win_msg.classList.add("fade-out-item");
                    setTimeout(()=> {win_msg.style.display = "none";}, 2000);
                }, 3000);
                console.log("Winner is:");
                console.log("{{ $users[0]->name }}");
                localStorage.removeItem('hints');
           });

        document.getElementById("config").addEventListener("submit", async function (event) {
            event.preventDefault();
            console.log("get prevented");
        });
    });

    async function startGame() {
        const form = document.getElementById("config");
        const formData = new FormData(form);
        const response = await fetch("{{ route('rooms.start', ['id' => $room->id]) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData
        });
        console.log(await response.json());
    }

</script>

@endsection
