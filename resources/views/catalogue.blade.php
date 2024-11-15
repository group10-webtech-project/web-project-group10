@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="pt-2">
        <label class="input input-bordered flex items-center w-1/2 mx-auto">
            <input type="text" class="grow" placeholder="Search animals..." id="search" autocomplete="off"/>
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
        <ul id="selection_menu" class="menu dropdown-content bg-base-100 rounded-box z-[1] w-1/2 shadow-xl mx-auto left-0 right-0 text-xl absolute empty:hidden mt-1"></ul>
    </div>

    <div class="card lg:card-side bg-base-100 shadow-xl w-3/4 mt-6 mx-auto">
        <figure class="min-w-96">
            <img class="w-full h-full object-cover"
            id="animal_image"
            src=""
            alt="Picture of animal" />
        </figure>
        <div class="card-body">
            <h2 class="card-title" id="animal_name"></h2>
            <p id="info"></p>
        <div class="card-body">
            <h2 class="card-title" id="animal_name"></h2>
            <p id="info"></p>
        </div>
    </div>
</div>

@vite(['resources/js/search.js'])
@endsection
