@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 overflow-hidden">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6">Choose your prefered way of playing!</h2>
            <div class="text-center space-y-4">
                <a href="{{ route('game.index') }}" class="btn btn-primary w-full">
                    Single Player
                </a>
            </div>

            <div class="divider">OR</div>

            <div class="text-center space-y-4">
                <a href="{{ route('multiplayer.menu') }}" class="btn btn-accent w-full">
                    Multiplayer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
