@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{ $room->room_code }}
    {{ $user->name }}
    <?php if ($user->id == $room->admin_id && !$room->active): ?>
        <button type="submit" onclick="startGame()" class="btn btn-success gap-2 hover:scale-105 transition-transform duration-200">
            <span class="hidden sm:inline">Start</span>
        </button>
    <?php endif; ?>

    <table class="table table-zebra">
        <thead>
            <tr>
                <th class="">Name</th>
                <th class="">Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="">{{ $user->name }}</td>
                    <td class="">{{ $user->current_room_score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    const room = @json($room);

    document.addEventListener('DOMContentLoaded', () => { //after echo loaded
        window.Echo.private("delivery").listen("PackageSent", (event) => {
            console.log("ahoy");
            console.log(event.data);
        });

        window.Echo.private(`rooms.${room.id}`)
            .listen('UserJoined', (user) => {
                console.log(user);
                if(user.id != "{{ $user->id }}")
                {
                    location.reload();
                }
            }).listen('GameStart', (e) => {
                console.log("start");
                window.location.href = "{{ route('multiplayer.newGame', ['id' => $room->id]) }}";
                console.log(e);
            });



    });

    async function startGame() {
        const response = await fetch("{{ route('rooms.start', ['id' => $room->id]) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
        console.log(await response.json());
    }

</script>

@endsection
