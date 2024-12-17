@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 overflow-hidden">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6">Playing with friends is always fun!</h2>

            <form action="{{ route('rooms.joinWithCode') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Room code</span>
                    </label>
                    <input name="room_code" class="input input-bordered" required />
                </div>
                <button type="submit" class="btn btn-primary w-full">Join</button>
            </form>

            <div class="divider">OR</div>

            <div class="text-center space-y-4">
                <a href="{{ route('rooms.create') }}" class="btn btn-accent w-full">
                    Host game
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
