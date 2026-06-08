@extends('layouts.auth', ['title' => 'Forgot Password | Akhani Connect'])

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form class="form w-100" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Reset Your Password</h1>
                <div class="text-gray-400 fw-bold fs-6">
                    Enter your account email and we will send you a password reset link.
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-10">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-10">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">Send reset link</span>
                </button>

                <a href="{{ route('login') }}" class="btn btn-light w-100">Back to login</a>
            </div>
        </form>
    </div>
@endsection
