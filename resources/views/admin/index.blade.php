@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="d-flex justify-content-between align-items-center h-screen p-5">
            <div class="card bg-base-100 shadow-xl">

                <div class="card-body flex justify-center items-center">

                    <h1 class="text-4xl">Admin Dashboard</h1>

                    <div>
                        <a href="{{ route('admin.animals') }}"
                           class="btn btn-primary mt-5 w-80">
                            Manage Animals</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
