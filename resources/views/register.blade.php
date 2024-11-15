@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold mb-6">Create Account</h2>

            <div id="error-messages" class="alert alert-error mb-4 hidden">
                <ul></ul>
            </div>

            <form id="register-form" action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered" required />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" required />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="input input-bordered w-full" required />
                        <button type="button" onclick="togglePassword('password')" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-ghost btn-circle btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Confirm Password</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input input-bordered w-full" required />
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-ghost btn-circle btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full">Register</button>
            </form>

            <div class="divider">OR</div>

            <div class="text-center space-y-4">
                <p class="text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="link link-primary">Login</a>
                </p>
                <p class="text-sm">
                    Want to try first?
                    <a href="{{ route('game.index') }}" class="link link-primary">Play as Guest</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const password = document.querySelector('input[name="password"]').value;
    const confirmation = document.querySelector('input[name="password_confirmation"]').value;
    const errorDiv = document.getElementById('error-messages');
    const errorList = errorDiv.querySelector('ul');

    errorDiv.classList.add('hidden');
    errorList.innerHTML = '';

    if (password !== confirmation) {
        errorDiv.classList.remove('hidden');
        errorList.innerHTML = '<li>Passwords do not match</li>';
        return;
    }

    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Trigger confetti
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });

            // Redirect after animation
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } else {
            errorDiv.classList.remove('hidden');
            if (data.errors) {
                Object.values(data.errors).forEach(error => {
                    errorList.innerHTML += `<li>${error[0]}</li>`;
                });
            } else {
                errorList.innerHTML = `<li>${data.message}</li>`;
            }
        }
    });
});
</script>
@endsection
