@extends('layouts.app', [
    'title' => 'Enterprise Details | Akhani Connect',
    'heading' => 'CIPC Enterprise',
    'subheading' => 'Use your company registration number to verify and refresh enterprise data from CIPC.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-body">
            <div class="mb-8">
                <h3 class="mb-3">CIPC Enterprise</h3>
                <p class="text-gray-600 mb-0">Hi {{ auth()->user()->full_name }}, enter the company registration number below. Enterprise fields are pulled from the API and can only be refreshed by verification.</p>
            </div>

            <form method="POST" action="{{ route('procurement.enterprise.update') }}">
                @csrf
                @method('PUT')

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Registration number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="registration_number" value="{{ old('registration_number', auth()->user()->procurementProfile?->registration_number) }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Company name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ auth()->user()->procurementProfile?->company_name }}" disabled>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">VAT number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ auth()->user()->procurementProfile?->vat_number }}" disabled>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Company phone</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ auth()->user()->procurementProfile?->company_phone }}" disabled>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Enterprise status</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ auth()->user()->procurementProfile?->enterprise_status }}" disabled>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Enterprise type</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ auth()->user()->procurementProfile?->enterprise_type }}" disabled>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Registered address</label>
                        <textarea class="form-control form-control-lg form-control-solid" rows="3" disabled>{{ auth()->user()->procurementProfile?->enterprise_address }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Registration Number</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h3 class="mb-2">Run CIPC Company Match</h3>
                <p class="text-gray-600 mb-0">Verify the saved registration number to pull the latest enterprise details from the API and refresh your stored company data.</p>
            </div>
            <div class="mt-5 mt-md-0">
                <form method="POST" action="{{ route('procurement.enterprise.verify') }}">
                    @csrf
                    <button type="submit" class="btn btn-light-primary">{{ $record?->status === 'verified' ? 'Re-verify Enterprise' : 'Verify Enterprise' }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Your Saved CIPC Enterprise</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Registration #</th>
                            <th>Company Name</th>
                            <th>VAT #</th>
                            <th>Company Phone</th>
                            <th>Enterprise Status</th>
                            <th>Status</th>
                            <th>Verification Ref</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        <tr>
                            <td>{{ auth()->user()->procurementProfile?->registration_number ?: 'Not saved' }}</td>
                            <td>{{ auth()->user()->procurementProfile?->company_name ?: 'Not synced yet' }}</td>
                            <td>{{ auth()->user()->procurementProfile?->vat_number ?: 'Not synced yet' }}</td>
                            <td>{{ auth()->user()->procurementProfile?->company_phone ?: 'Not synced yet' }}</td>
                            <td>{{ auth()->user()->procurementProfile?->enterprise_status ?: 'Not synced yet' }}</td>
                            <td>
                                <span class="badge badge-light-{{ $record?->status === 'verified' ? 'success' : ($record?->status === 'failed' ? 'danger' : (auth()->user()->procurementProfile?->registration_number ? 'warning' : 'secondary')) }}">
                                    {{ $record?->status ? ucfirst($record->status) : (auth()->user()->procurementProfile?->registration_number ? 'Saved' : 'Pending') }}
                                </span>
                            </td>
                            <td>{{ $record?->provider_reference ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($record?->summary)
                <div class="mt-8">
                    <h4 class="mb-3">Latest Verification Summary</h4>
                    <div class="row g-5">
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Company Name</div>
                            <div class="fw-bold">{{ $record->summary['company_name'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Registration Number</div>
                            <div class="fw-bold">{{ $record->summary['registration_number'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">CIPC Status</div>
                            <div class="fw-bold">{{ $record->summary['status'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Enterprise Type</div>
                            <div class="fw-bold">{{ $record->summary['enterprise_type'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-8">
                            <div class="text-muted fs-7">Registered Address</div>
                            <div class="fw-bold">{{ $record->summary['enterprise_address'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
