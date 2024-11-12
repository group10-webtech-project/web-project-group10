<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

@if(session('message'))
    <p>{{ session('message') }}</p>
@endif

<form action="/login" method="POST">
    @csrf
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
