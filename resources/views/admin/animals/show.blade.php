@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl rounded-lg">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-center text-primary mb-4">{{ $animal->name }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($animal->image_url)
                        <div class="md:col-span-2 flex justify-center mb-4">
                            <img src="{{ asset('storage/' . $animal->image_url) }}"
                                 alt="{{ $animal->name }}"
                                 class="max-w-full max-h-96 object-cover rounded-lg shadow-md"
                            >
                        </div>
                    @endif

                    <div>
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Basic Information</h2>
                        <div class="space-y-2">
                            <p class="text-lg"><strong>Short Name:</strong> {{ $animal->short_name }}</p>
                            <p class="text-lg"><strong>Category:</strong> {{ $animal->category->name }}</p>
                            <p class="text-lg"><strong>Size:</strong> {{ $animal->size }}</p>
                            <p class="text-lg"><strong>Habitat:</strong> {{ $animal->habitat }}</p>
                            <p class="text-lg"><strong>Diet:</strong> {{ $animal->diet }}</p>
                            <p class="text-lg">
                                <strong>Is Carnivore:</strong>
                                {{ $animal->is_carnivore ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Additional Details</h2>
                        <div class="space-y-2">
                            <p class="text-lg"><strong>Region:</strong> {{ $animal->region }}</p>
                            <p class="text-lg"><strong>Lifespan:</strong> {{ $animal->lifespan }}</p>
                            <p class="text-lg">
                                <strong>Has Legs:</strong>
                                {{ $animal->has_legs ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-lg">
                                <strong>Has Fur:</strong>
                                {{ $animal->has_fur ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-lg">
                                <strong>Can Swim:</strong>
                                {{ $animal->can_swim ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-lg">
                                <strong>Can Fly:</strong>
                                {{ $animal->can_fly ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Description</h2>
                        <p class="text-lg text-gray-700">{{ $animal->description }}</p>
                    </div>

                    @if($animal->initial_hint)
                        <div class="md:col-span-2">
                            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Initial Hint</h2>
                            <p class="text-lg text-gray-700">{{ $animal->initial_hint }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('admin.animals.edit', $animal) }}" class="btn btn-primary mr-2">Edit Animal</a>
                    <a href="{{ route('admin.animals') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
