@extends('layouts.auth', ['title' => 'Register | Akhani Connect'])

@section('content')
    <div class="w-lg-650px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form class="form w-100" method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="mb-10 text-center">
                <h1 class="text-dark mb-3">Create an Account</h1>
                <div class="text-gray-400 fs-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="link-primary">Sign in here</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-10">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="row fv-row mb-7">
                <div class="col-xl-6">
                    <label class="form-label fw-bolder text-dark fs-6">First Name</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{ old('first_name') }}" required />
                </div>
                <div class="col-xl-6">
                    <label class="form-label fw-bolder text-dark fs-6">Last Name</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" name="surname" value="{{ old('surname') }}" required />
                </div>
            </div>

            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email') }}" required />
            </div>

            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6">Phone</label>
                <input class="form-control form-control-lg form-control-solid" type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 0821234567" required />
            </div>

            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6">Register As</label>
                <select class="form-select form-select-lg form-select-solid" name="role" required>
                    <option value="">Select role</option>
                    <option value="candidate" @selected(old('role') === 'candidate')>Candidate</option>
                    <option value="recruitment" @selected(old('role') === 'recruitment')>Recruitment</option>
                    <option value="procurement" @selected(old('role') === 'procurement')>Procurement</option>
                </select>
            </div>

            <div class="mb-10 fv-row">
                <label class="form-label fw-bolder text-dark fs-6">Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password" required />
                <div class="text-muted mt-2">Use 8 or more characters with a mix of letters, numbers and symbols.</div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" required />
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary">
                    <span class="indicator-label">Create Account</span>
                </button>
            </div>
        </form>
    </div>
@endsection
