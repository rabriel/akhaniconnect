@extends('layouts.app', [
    'title' => 'Bank Account Verification | Akhani Connect',
    'heading' => 'Bank Account Verification',
    'subheading' => 'Submit business or individual bank account details for verification.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Verify Bank Account</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('procurement.verifications.bank-account.store') }}">
                @csrf

                <div class="row mb-6">
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Type</label>
                        <select class="form-select form-select-lg form-select-solid" name="type" required>
                            <option value="Individual" @selected(old('type') === 'Individual')>Individual</option>
                            <option value="Company" @selected(old('type') === 'Company')>Company</option>
                        </select>
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">First name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}">
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Surname / Company name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="surname" value="{{ old('surname', auth()->user()->surname) }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Identity number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="identity_number" value="{{ old('identity_number', auth()->user()->procurementProfile?->registration_number ?: auth()->user()->profile?->id_number) }}" required>
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Identity type</label>
                        <select class="form-select form-select-lg form-select-solid" name="identity_type" required>
                            <option value="IDNumber" @selected(old('identity_type') === 'IDNumber')>ID Number</option>
                            <option value="CompanyRegNumber" @selected(old('identity_type') === 'CompanyRegNumber')>Company Registration Number</option>
                            <option value="PassportNumber" @selected(old('identity_type') === 'PassportNumber')>Passport Number</option>
                        </select>
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Bank account number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Branch code</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="bank_branch_code" value="{{ old('bank_branch_code') }}" required>
                    </div>
                    <div class="col-lg-4 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Account type</label>
                        <select class="form-select form-select-lg form-select-solid" name="bank_account_type" required>
                            <option value="Savings" @selected(old('bank_account_type') === 'Savings')>Savings</option>
                            <option value="Current" @selected(old('bank_account_type') === 'Current')>Current</option>
                            <option value="Transmission" @selected(old('bank_account_type') === 'Transmission')>Transmission</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit Verification</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Verification History</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            @if ($record)
                <div class="mb-5">
                    <span class="badge badge-light-{{ $record->status === 'verified' ? 'success' : ($record->status === 'failed' ? 'danger' : 'warning') }}">
                        {{ ucfirst($record->status) }}
                    </span>
                    @if ($record->provider_reference)
                        <span class="ms-4 text-muted">Reference: {{ $record->provider_reference }}</span>
                    @endif
                </div>
            @endif
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Attempted</th>
                            <th>Status</th>
                            <th>Reference</th>
                            <th>Error</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($record?->attempts?->sortByDesc('attempted_at') ?? [] as $attempt)
                            <tr>
                                <td>{{ $attempt->attempted_at?->format('Y-m-d H:i') }}</td>
                                <td>{{ ucfirst($attempt->status) }}</td>
                                <td>{{ $attempt->provider_reference ?: 'N/A' }}</td>
                                <td>{{ $attempt->error_message ?: 'None' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10">No verification attempts recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
