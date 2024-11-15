@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6">Welcome Back!</h2>

            @if(session('message'))
                <div class="alert alert-info mb-4">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-4">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" required />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                        <a href="{{ route('password.request') }}" class="label-text-alt link link-primary">
                            Forgot password?
                        </a>
                    </label>
                    <input type="password" name="password" class="input input-bordered" required />
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Remember me</span>
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary" />
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full">Login</button>
            </form>

            <div class="divider">OR</div>

            <div class="text-center space-y-4">
                <a href="{{ route('register') }}" class="btn btn-outline btn-primary w-full">
                    Create New Account
                </a>
                <p class="text-sm">
                    Want to try first?
                    <a href="{{ route('game.index') }}" class="link link-primary">Play as Guest</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
