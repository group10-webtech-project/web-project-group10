@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl rounded-lg">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-center text-primary mb-4">{{ $animal->name }}</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <p class="text-lg font-semibold"><strong>Category:</strong> <span class="text-gray-700">{{ $animal->category->name }}</span></p>
                        <p class="text-lg font-semibold"><strong>Size:</strong> <span class="text-gray-700">{{ $animal->size }}</span></p>
                        <p class="text-lg font-semibold"><strong>Diet:</strong> <span class="text-gray-700">{{ $animal->diet }}</span></p>
                        <p class="text-lg font-semibold"><strong>Region:</strong> <span class="text-gray-700">{{ $animal->region }}</span></p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-lg font-semibold"><strong>Description:</strong></p>
                        <p class="text-gray-700">{{ $animal->description }}</p>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.animals') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
