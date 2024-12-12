@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{ $room->room_code }}
    {{ $player->name }}
    <?php if ($player->id == $room->admin_id): ?>
        <form action="{{ url('/rooms/' . $room->id . '/start') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success gap-2 hover:scale-105 transition-transform duration-200">
                <span class="hidden sm:inline">Start</span>
            </button>
        </form>
    <?php endif; ?>
</div>

<script>
    const room = @json($room);

    document.addEventListener('DOMContentLoaded', () => { //after echo loaded
        window.Echo.private("delivery").listen("PackageSent", (event) => {
            console.log("ahoy");
            console.log(event.data);
        });

        window.Echo.private(`rooms.${room.id}`)
            .listen('UserJoined', (e) => {
                console.log("joined");
                console.log(e);
            }).listen('GameStart', (e) => {
                console.log("start");
                console.log(e);
            });



    });

</script>

@endsection
