@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl rounded-lg">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-center text-primary mb-6">Create Animal</h1>
                <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label for="name" class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" class="input input-bordered" id="name" name="name" required>
                    </div>

                    <div class="form-control">
                        <label for="short_name" class="label">
                            <span class="label-text">Short Name (the one you guess in the game)</span>
                        </label>
                        <input type="text" class="input input-bordered" id="short_name" name="short_name" required>
                    </div>

                    <div class="form-control">
                        <label for="size" class="label">
                            <span class="label-text">Size</span>
                        </label>
                        <input type="text" class="input input-bordered" id="size" name="size" required>
                    </div>

                    <div class="form-control">
                        <label for="habitat" class="label">
                            <span class="label-text">Habitat</span>
                        </label>
                        <input type="text" class="input input-bordered" id="habitat" name="habitat" required>
                    </div>

                    <div class="form-control">
                        <label for="diet" class="label">
                            <span class="label-text">Diet</span>
                        </label>
                        <select class="select select-bordered" id="diet" name="diet" required>
                            <option value="Herbivore">Herbivore</option>
                            <option value="Carnivore">Carnivore</option>
                            <option value="Omnivore">Omnivore</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Is Carnivore</span>
                            <input type="hidden" name="is_carnivore" value="0"/>
                            <!-- Ensure 0 is sent when unchecked -->
                            <input type="checkbox" class="toggle toggle-primary" name="is_carnivore"
                                   value="1"  />
                        </label>
                    </div>

                    <div class="form-control">
                        <label for="region" class="label">
                            <span class="label-text">Region</span>
                        </label>
                        <input type="text" class="input input-bordered" id="region" name="region" required>
                    </div>

                    <div class="form-control">
                        <label for="lifespan" class="label">
                            <span class="label-text">Lifespan</span>
                        </label>
                        <input type="text" class="input input-bordered" id="lifespan" name="lifespan" required>
                    </div>

                    <div class="form-control">
                        <label for="category_id" class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select class="select select-bordered" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="description" class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea class="textarea textarea-bordered" id="description" name="description"
                                  rows="4"></textarea>
                    </div>

                    <div class="form-control">
                        <label for="initial_hint" class="label">
                            <span class="label-text">Initial Hint</span>
                        </label>
                        <input type="text" class="input input-bordered" id="initial_hint" name="initial_hint">
                    </div>

                    <div class="form-control">
                        <label for="image" class="label">
                            <span class="label-text">Animal Image</span>
                        </label>
                        <input type="file" class="file-input file-input-bordered file-input-primary w-full" id="image"
                               name="image_url" accept="image/*"/>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Has Legs</span>
                            <input type="hidden" name="has_legs" value="0"/> <!-- Ensure 0 is sent when unchecked -->
                            <input type="checkbox" class="toggle toggle-primary" name="has_legs"
                                   value="1"  />
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Has Fur</span>
                            <input type="hidden" name="has_fur" value="0"/> <!-- Ensure 0 is sent when unchecked -->
                            <input type="checkbox" class="toggle toggle-primary" name="has_fur"
                                   value="1"  />
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Can Swim</span>
                            <input type="hidden" name="can_swim" value="0"/> <!-- Ensure 0 is sent when unchecked -->
                            <input type="checkbox" class="toggle toggle-primary" name="can_swim"
                                   value="1"  />
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Can Fly</span>
                            <input type="hidden" name="can_fly" value="0"/> <!-- Ensure 0 is sent when unchecked -->
                            <input type="checkbox" class="toggle toggle-primary" name="can_fly"
                                   value="1"  />
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Animal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
