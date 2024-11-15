@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="pt-2">
        <label class="input input-bordered flex items-center gap-2 w-full max-w-xl mx-auto">
            <input type="text" class="grow" placeholder="Search animals..." id="search" autocomplete="off"/>
            <svg id="submit" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-4 w-4 opacity-70">
                <path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" />
            </svg>
        </label>
        <ul id="selection_menu" class="menu bg-base-200 rounded-box w-full max-w-xl mx-auto p-2 mt-2 shadow-lg"></ul>
    </div>

    <div class="card lg:card-side bg-base-100 shadow-xl max-w-5xl mx-auto mt-8">
        <figure class="lg:w-1/2 h-[400px]">
            <img id="animal_image" src="{{ asset('imgs/alligator.jpg') }}" alt="Animal" class="w-full h-full p-0" />
        </figure>
        <div class="card-body lg:w-1/2">
            <h2 class="card-title text-2xl" id="animal_name">Select an animal</h2>
            <div class="prose" id="info">
                <p>Search for an animal above to view its details.</p>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/search.js'])
@endsection
