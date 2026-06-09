@extends('layouts.auth', ['title' => 'Reset Password | Akhani Connect'])

@section('content')
    <div class="auth-card w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form class="form w-100" method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Choose a New Password</h1>
                <div class="text-gray-400 fw-bold fs-6">
                    Set a new password for your Akhani Connect account.
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-10">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">New Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password" required />
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">Confirm Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" required />
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary w-100">
                    <span class="indicator-label">Reset password</span>
                </button>
            </div>
        </form>
    </div>
@endsection
