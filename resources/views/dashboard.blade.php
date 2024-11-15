<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<!-- this is only here so i can test the redirection-->
<h1>hello {{ Auth::user()->name }}</h1>

<a href="/logout">Logout</a>

</body>
</html>
