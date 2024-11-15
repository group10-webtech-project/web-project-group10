<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="card w-full max-w-md bg-base-100 shadow-lg">
        <div class="card-body">
            <h1 class="text-2xl font-bold text-center mb-4">Login</h1>

            @if(session('message'))
                <div class="alert alert-info shadow-lg mb-4">
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error shadow-lg mb-4">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" id="email" class="input input-bordered" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label for="password" class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" id="password" class="input input-bordered" required>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full hover:scale-105 transition-transform duration-200">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
