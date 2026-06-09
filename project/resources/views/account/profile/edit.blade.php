@extends('layouts.app', [
    'title' => 'My Profile | Akhani Connect',
    'heading' => 'My Profile',
    'subheading' => 'Update your account and profile details for Akhani Connect.',
])

@section('content')
    @php
        $user = auth()->user();
        $mustVerifyIdentity = ($user->hasRole('candidate') || $user->hasRole('procurement')) && ! $user->hasVerifiedIdentity();
        $idNumberLocked = ($user->hasRole('candidate') || $user->hasRole('procurement')) && $user->hasVerifiedIdentity();
    @endphp
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Account Details</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            @if ($mustVerifyIdentity)
                <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                    <span class="me-4">
                        <i class="bi bi-shield-exclamation fs-2 text-warning"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span>You need to verify your ID to proceed.</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <fieldset @disabled($mustVerifyIdentity)>
                    <div class="row mb-8 align-items-center">
                        <div class="col-lg-3">
                            <div class="symbol symbol-125px symbol-circle">
                                @if ($user->profile?->avatar_url)
                                    <img src="{{ $user->profile->avatar_url }}" alt="Profile picture" class="object-fit-cover">
                                @else
                                    <span class="symbol-label bg-light-primary text-primary fs-1 fw-bold">
                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
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
                            <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                        </div>
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Surname</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="surname" value="{{ old('surname', $user->surname) }}" required>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Phone</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Date of birth</label>
                            <input class="form-control form-control-lg form-control-solid" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($user->profile?->date_of_birth)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Gender</label>
                            <select class="form-select form-select-lg form-select-solid" name="gender">
                                <option value="">Select gender</option>
                                @foreach (config('south_africa.genders', []) as $gender)
                                    <option value="{{ $gender }}" @selected(old('gender', $user->profile?->gender) === $gender)>{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">South African ID number</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="id_number" value="{{ old('id_number', $user->profile?->id_number) }}" @readonly($idNumberLocked)>
                            @if ($idNumberLocked)
                                <div class="form-text">This ID number was populated from your verified identity record.</div>
                            @endif
                        </div>
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Passport number</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="passport_number" value="{{ old('passport_number', $user->profile?->passport_number) }}">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Secondary phone</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="phone_secondary" value="{{ old('phone_secondary', $user->profile?->phone_secondary) }}">
                        </div>
                        <div class="col-lg-6 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Postal code</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="postal_code" value="{{ old('postal_code', $user->profile?->postal_code) }}">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-12 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Address line 1</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="address_line_1" value="{{ old('address_line_1', $user->profile?->address_line_1) }}">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-12 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Address line 2</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="address_line_2" value="{{ old('address_line_2', $user->profile?->address_line_2) }}">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Suburb</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="suburb" value="{{ old('suburb', $user->profile?->suburb) }}">
                        </div>
                        <div class="col-lg-4 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">City</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="city" value="{{ old('city', $user->profile?->city) }}">
                        </div>
                        <div class="col-lg-4 fv-row">
                            <label class="form-label fs-6 fw-bold mb-3">Province</label>
                            <select class="form-select form-select-lg form-select-solid" name="province">
                                <option value="">Select province</option>
                                @foreach (config('south_africa.provinces', []) as $province)
                                    <option value="{{ $province }}" @selected(old('province', $user->profile?->province) === $province)>{{ $province }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" @disabled($mustVerifyIdentity)>
                        {{ $mustVerifyIdentity ? 'Verify ID To Continue' : 'Save Profile' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@if ($mustVerifyIdentity)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swal === 'undefined') {
                    return;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Verify your ID',
                    text: 'You need to verify your ID to proceed.',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false,
                });
            });
        </script>
    @endpush
@endif
