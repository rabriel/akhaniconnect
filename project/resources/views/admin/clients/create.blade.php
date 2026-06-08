@extends('layouts.app', [
    'title' => 'Create Client | Akhani Connect',
    'heading' => 'Create Client',
    'subheading' => 'Create a client account and define its company access scope.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>New Client Account</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('admin.clients.store') }}">
                @csrf

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">First name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Surname</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="surname" value="{{ old('surname') }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Email</label>
                        <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Phone</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Company name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="company_name" value="{{ old('company_name') }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Contact person</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="contact_person_name" value="{{ old('contact_person_name') }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Company phone</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="company_phone" value="{{ old('company_phone') }}">
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Status</label>
                        <select class="form-select form-select-lg form-select-solid" name="status" required>
                            <option value="active" @selected(old('status') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Access scope</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="access_scope" value="{{ old('access_scope') }}" placeholder="e.g. Procurement records - Gauteng">
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Confirm password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Client</button>
                </div>
            </form>
        </div>
    </div>
@endsection
