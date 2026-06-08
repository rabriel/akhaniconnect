@extends('layouts.auth', ['title' => 'Login | Akhani Connect'])

@section('content')
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form class="form w-100" method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Akhani Connect</h1>
                <div class="text-gray-400 fw-bold fs-4">
                    New here?
                    <a href="{{ route('register') }}" class="link-primary fw-light">Create an Account</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-10">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>

            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                    <a href="{{ route('password.request') }}" class="link-primary fs-6">Forgot Password?</a>
                </div>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password" required />
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">Continue</span>
                </button>
            </div>
        </form>
    </div>
@endsection
