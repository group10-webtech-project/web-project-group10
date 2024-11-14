<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'fantasy') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nerdle</title>
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/search.js'])
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-primary/10 via-base-100 to-secondary/10">
    <!--
    <div class="join w-full shadow-lg join w-full shadow-lg">
        <input type="text" class="join-item input input-bordered input-lg flex-1 text-lg" id="guess">
        <button id="submit">guess</button>
    </div>
    -->
    <div>
        <label class="input input-bordered flex items-center gap-2 w-1/2 mx-auto mt-1">
            <input type="text" class="grow" placeholder="Search" id="search" autocomplete="off"/>
            <svg
                id="submit"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70">
                <path
                fill-rule="evenodd"
                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                clip-rule="evenodd" />
            </svg>
        </label>
        <ul id="selection_menu" class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow mx-auto left-0 right-0 text-xl absolute empty:hidden mt-1"></ul>
    </div>

    <div class="card lg:card-side bg-base-100 shadow-xl w-3/4 mt-6 mx-auto">
        <figure class="min-w-96">
            <img
            id="animal_image"
            src=""
            alt="Picture of animal" />
        </figure>
        <div class="card-body">
            <h2 class="card-title" id="animal_name"></h2>
            <p id="info"></p>
        </div>
    </div>

</body>

</html>
