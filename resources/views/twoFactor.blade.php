@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="card card-bordered shadow-lg p-4">
            <div class="card-body">
                @if(session()->has('message'))
                    <div class="alert alert-info">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verify.store') }}">
                    @csrf
                    <h1 class="text-2xl font-semibold mb-4">Two Factor Verification</h1>
                    <p class="text-sm text-gray-500 mb-4">
                        You have received an email which contains a two-factor login code.
                        If you haven't received it, press <a href="{{ route('verify.resend') }}" class="text-blue-500 hover:underline">here</a>.
                    </p>

                    <div class="form-control mb-4">
                        <input name="two_factor_auth_code" type="text" class="input input-bordered w-full {{ $errors->has('two_factor_auth_code') ? 'input-error' : '' }}" required autofocus placeholder="Two Factor Code">
                        @if($errors->has('two_factor_auth_code'))
                            <div class="text-red-500 text-sm mt-2">
                                {{ $errors->first('two_factor_auth_code') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between">
                        <button type="submit" class="btn btn-primary px-6 py-2">
                            Verify
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection
