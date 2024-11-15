<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="card w-full max-w-md bg-base-100 shadow-lg">
        <div class="card-body">
            <h1 class="text-2xl font-bold text-center mb-4">Register</h1>

            @if ($errors->any())
                <div class="alert alert-error shadow-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf

                <div class="form-control mb-4">
                    <label for="name" class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered" required>
                </div>

                <div class="form-control mb-4">
                    <label for="email" class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered" required>
                </div>

                <div class="form-control mb-4">
                    <label for="password" class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered" required>
                </div>

                <div class="form-control mb-6">
                    <label for="password_confirmation" class="label">
                        <span class="label-text">Confirm Password</span>
                    </label>
                    <input type="password" name="password_confirmation" class="input input-bordered hover:scale-105 transition-transform duration-200" required>
                </div>

                <button type="submit" class="btn btn-primary w-full hover:scale-105 transition-transform duration-200">Register</button>
            </form>
        </div>
    </div>

</body>
</html>
