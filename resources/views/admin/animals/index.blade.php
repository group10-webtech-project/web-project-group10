@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">

                <div class="flex justify-between items-center mb-3">
                    <h1 class="text-2xl font-bold">Animals</h1>
                    <a href="{{ route('admin.animals.create') }}" class="btn btn-primary">Add New Animal</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Diet</th>
                        <th>Region</th>
                        <th>Habitat</th>
                        <th>Lifespan</th>
                        <th>Is carnivore</th>
                        <th>Has legs</th>
                        <th>Has fur</th>
                        <th>Can swim</th>
                        <th>Can fly</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($animals as $animal)
                        <tr>
                            <td>{{ $animal->id }}</td>
                            <td>{{ $animal->name }}</td>
                            <td>{{ $animal->short_name }}</td>
                            <td>{{ $animal->category->name }}</td>
                            <td>{{ $animal->size }}</td>
                            <td>{{ $animal->diet }}</td>
                            <td>{{ $animal->region }}</td>
                            <td>{{ $animal->habitat }}</td>
                            <td>{{ $animal->lifespan }}</td>
                            <td>{!! $animal->is_carnivore ? '✔️' : '❌' !!}</td>
                            <td>{!! $animal->has_legs ? '✔️' : '❌' !!}</td>
                            <td>{!! $animal->has_fur ? '✔️' : '❌' !!}</td>
                            <td>{!! $animal->can_swim ? '✔️' : '❌' !!}</td>
                            <td>{!! $animal->can_fly ? '✔️' : '❌' !!}</td>

                            <td>
                                <div class="flex space-x-4 items-center">
                                    <!-- View Action -->
                                    <a href="{{ route('admin.animals.show', $animal) }}" class="group relative">
                                        <button
                                            class="p-2 rounded-full bg-base-100 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 24 24" class="w-6 h-6">
                                                <path
                                                    d="M12 4.5c-4.09 0-7.5 3.11-7.5 7.5s3.41 7.5 7.5 7.5 7.5-3.11 7.5-7.5-3.41-7.5-7.5-7.5zm0 13.5c-2.84 0-5.25-2.22-5.25-5s2.41-5 5.25-5 5.25 2.22 5.25 5-2.41 5-5.25 5z"/>
                                                <path d="M11 10h2v4h-2zm0-2h2v1h-2z"/>
                                            </svg>
                                        </button>
                                        <span
                                            class="absolute hidden group-hover:block text-sm px-2 py-1 bg-gray-900 text-white rounded-md -bottom-8 left-1/2 transform -translate-x-1/2 z-10">
                    View
                </span>
                                    </a>

                                    <!-- Edit Action -->
                                    <a href="{{ route('admin.animals.edit', $animal) }}" class="group relative">
                                        <button
                                            class="p-2 rounded-full bg-base-100 hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 24 24" class="w-6 h-6">
                                                <path
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zm2.92 2.16H4.5v-1.42l10.06-10.06 1.42 1.42L5.92 19.41z"/>
                                                <path
                                                    d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0L15.13 5.96l3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                        </button>
                                        <span
                                            class="absolute hidden group-hover:block text-sm px-2 py-1 bg-gray-900 text-white rounded-md -bottom-8 left-1/2 transform -translate-x-1/2 z-10">
                    Edit
                </span>
                                    </a>

                                    <!-- Delete Action -->
                                    <form action="{{ route('admin.animals.destroy', $animal) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this animal?');"
                                          class="group relative">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-full bg-base-100 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 24 24" class="w-6 h-6">
                                                <path
                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM16 4l-1-1h-6L8 4H4v2h16V4h-4z"/>
                                            </svg>
                                        </button>
                                        <span
                                            class="absolute hidden group-hover:block text-sm px-2 py-1 bg-gray-900 text-white rounded-md -bottom-8 left-1/2 transform -translate-x-1/2 z-10">
                    Delete
                </span>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">No animals found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="flex-col justify-between">
                    {{ $animals->links('vendor.pagination.tailwind') }}
                </div>

            </div>
        </div>
    </div>
@endsection
