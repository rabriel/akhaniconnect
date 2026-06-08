@extends('layouts.app', [
    'title' => 'Recruitment Company Profile | Akhani Connect',
    'heading' => 'Recruitment Company Profile',
    'subheading' => 'Keep your recruiter account and company details up to date.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('recruitment.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-5 mb-8">
                    <div class="col-md-6">
                        <label class="form-label required">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Surname</label>
                        <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                </div>

                <div class="separator separator-dashed my-10"></div>

                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label required">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $user->recruitmentProfile?->company_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Registration Number</label>
                        <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $user->recruitmentProfile?->registration_number) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website', $user->recruitmentProfile?->website) }}" placeholder="https://example.co.za">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Phone</label>
                        <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $user->recruitmentProfile?->company_phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person_name" class="form-control" value="{{ old('contact_person_name', $user->recruitmentProfile?->contact_person_name ?? $user->full_name) }}">
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="btn btn-primary">Save company profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
