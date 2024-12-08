@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Animal</h1>
        <form action="{{ route('admin.animals.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="size">Size</label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>
            <div class="form-group mb-3">
                <label for="diet">Diet</label>
                <select class="form-control" id="diet" name="diet" required>
                    <option value="Herbivore">Herbivore</option>
                    <option value="Carnivore">Carnivore</option>
                    <option value="Omnivore">Omnivore</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="region">Region</label>
                <input type="text" class="form-control" id="region" name="region" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
