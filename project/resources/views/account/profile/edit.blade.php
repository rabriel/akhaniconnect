@extends('layouts.app', [
    'title' => 'My Profile | Akhani Connect',
    'heading' => 'My Profile',
    'subheading' => 'Update your account and profile details for Akhani Connect.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Account Details</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-8 align-items-center">
                    <div class="col-lg-3">
                        <div class="symbol symbol-125px symbol-circle">
                            @if (auth()->user()->profile?->avatar_url)
                                <img src="{{ auth()->user()->profile->avatar_url }}" alt="Profile picture" class="object-fit-cover">
                            @else
                                <span class="symbol-label bg-light-primary text-primary fs-1 fw-bold">
                                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <label class="form-label fs-6 fw-bold mb-3">Profile picture</label>
                        <input class="form-control form-control-lg form-control-solid" type="file" name="profile_picture" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-text">Upload a JPG, PNG, or WEBP image up to 5MB.</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">First name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Surname</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="surname" value="{{ old('surname', auth()->user()->surname) }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Email</label>
                        <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Phone</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Date of birth</label>
                        <input class="form-control form-control-lg form-control-solid" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional(auth()->user()->profile?->date_of_birth)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Gender</label>
                        <select class="form-select form-select-lg form-select-solid" name="gender">
                            <option value="">Select gender</option>
                            @foreach (config('south_africa.genders', []) as $gender)
                                <option value="{{ $gender }}" @selected(old('gender', auth()->user()->profile?->gender) === $gender)>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">South African ID number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="id_number" value="{{ old('id_number', auth()->user()->profile?->id_number) }}">
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Passport number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="passport_number" value="{{ old('passport_number', auth()->user()->profile?->passport_number) }}">
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Secondary phone</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="phone_secondary" value="{{ old('phone_secondary', auth()->user()->profile?->phone_secondary) }}">
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Postal code</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->profile?->postal_code) }}">
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Address line 1</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="address_line_1" value="{{ old('address_line_1', auth()->user()->profile?->address_line_1) }}">
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Address line 2</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="address_line_2" value="{{ old('address_line_2', auth()->user()->profile?->address_line_2) }}">
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Suburb</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="suburb" value="{{ old('suburb', auth()->user()->profile?->suburb) }}">
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">City</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="city" value="{{ old('city', auth()->user()->profile?->city) }}">
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Province</label>
                        <select class="form-select form-select-lg form-select-solid" name="province">
                            <option value="">Select province</option>
                            @foreach (config('south_africa.provinces', []) as $province)
                                <option value="{{ $province }}" @selected(old('province', auth()->user()->profile?->province) === $province)>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
