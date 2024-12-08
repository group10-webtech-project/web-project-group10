@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl rounded-lg">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-center text-primary mb-6">Edit Animal</h1>
                <form action="{{ route('admin.animals.update', $animal) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label for="name" class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" class="input input-bordered" id="name" name="name" value="{{ $animal->name }}" required>
                    </div>

                    <div class="form-control">
                        <label for="size" class="label">
                            <span class="label-text">Short Name (the one you guess in the game)</span>
                        </label>
                        <input type="text" class="input input-bordered" id="size" name="size" value="{{ $animal->short_name }}" required>
                    </div>

                    <div class="form-control">
                        <label for="size" class="label">
                            <span class="label-text">Size</span>
                        </label>
                        <input type="text" class="input input-bordered" id="size" name="size" value="{{ $animal->size }}" required>
                    </div>

                    <div class="form-control">
                        <label for="diet" class="label">
                            <span class="label-text">Diet</span>
                        </label>
                        <select class="select select-bordered" id="diet" name="diet" required>
                            <option value="Herbivore" {{ $animal->diet == 'Herbivore' ? 'selected' : '' }}>Herbivore</option>
                            <option value="Carnivore" {{ $animal->diet == 'Carnivore' ? 'selected' : '' }}>Carnivore</option>
                            <option value="Omnivore" {{ $animal->diet == 'Omnivore' ? 'selected' : '' }}>Omnivore</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="category_id" class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select class="select select-bordered" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $animal->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="region" class="label">
                            <span class="label-text">Region</span>
                        </label>
                        <input type="text" class="input input-bordered" id="region" name="region" value="{{ $animal->region }}" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
