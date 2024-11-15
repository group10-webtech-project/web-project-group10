@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6">Reset Password</h2>

            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" required />
                </div>

                <button type="submit" class="btn btn-primary w-full">Send Reset Link</button>
            </form>

            <div class="divider">OR</div>

            <div class="space-y-4 text-center">
                <a href="{{ route('login') }}" class="link link-primary">Back to Login</a>
                <p class="text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="link link-primary">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
