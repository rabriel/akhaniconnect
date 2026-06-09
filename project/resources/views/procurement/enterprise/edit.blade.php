@extends('layouts.app', [
    'title' => 'Enterprise Details | Akhani Connect',
    'heading' => 'CIPC Enterprise',
    'subheading' => 'Use your company registration number to verify and refresh enterprise data from CIPC.',
])

@section('content')
    @php
        $procurementProfile = auth()->user()->procurementProfile;
        $enterpriseData = $procurementProfile?->enterprise_data ?? [];
        $enterpriseRecordStatus = $record?->status ? ucfirst($record->status) : ($procurementProfile?->registration_number ? 'Awaiting verification' : 'Pending');
    @endphp

    <div class="d-flex justify-content-end mb-6">
        <a href="{{ route('procurement.enterprise.report') }}" class="btn btn-primary">Download PDF</a>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <div class="mb-8">
                <h3 class="mb-3">CIPC Enterprise</h3>
                <p class="text-gray-600 mb-0">Hi {{ auth()->user()->full_name }}, enter the company registration number below and run verification. All enterprise fields are pulled from the API and cannot be edited manually.</p>
            </div>

            @if ($record?->status === 'failed' && filled($record->last_error))
                <div class="alert alert-light-danger border border-danger border-opacity-25 mb-8">
                    <div class="fw-semibold mb-1">Latest verification failed</div>
                    <div class="text-muted">{{ $record->last_error }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('procurement.enterprise.verify') }}">
                @csrf

                <div class="d-flex flex-column flex-lg-row align-items-lg-end gap-3">
                    <div class="fv-row mb-0 flex-lg-grow-1">
                        <label class="form-label fs-6 fw-bold mb-3">Registration number</label>
                        <input
                            class="form-control form-control-lg form-control-solid"
                            type="text"
                            name="registration_number"
                            value="{{ old('registration_number', $procurementProfile?->registration_number) }}"
                            placeholder="Enter company registration number"
                            required
                        >
                    </div>
                    <div class="fv-row mb-0 flex-shrink-0">
                        <button type="submit" class="btn btn-primary w-100 w-lg-auto">
                            {{ $record?->status === 'verified' ? 'Re-verify Enterprise' : 'Verify Enterprise' }}
                        </button>
                    </div>
                </div>

                <div class="form-text mt-3">Format example: <strong>2014/081962/07</strong> or digits only like <strong>201408196207</strong>.</div>
                <div class="form-text mt-2">This is the only field you can enter manually. Company details below are populated from the CIPC API.</div>
            </form>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body py-8">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-6">
                <div>
                    <div class="fs-2hx fw-bold">{{ $procurementProfile?->company_name ?: 'Enterprise Record' }}</div>
                    <div class="text-muted mt-2">
                        {{ $procurementProfile?->registration_number ?: 'Registration number not saved' }}
                        @if ($procurementProfile?->enterprise_type)
                            | {{ $procurementProfile->enterprise_type }}
                        @endif
                        @if ($procurementProfile?->vat_number)
                            | VAT {{ $procurementProfile->vat_number }}
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge badge-light-{{ $record?->status === 'verified' ? 'success' : ($record?->status === 'failed' ? 'danger' : ($procurementProfile?->registration_number ? 'warning' : 'secondary')) }} fs-7 px-4 py-3">
                        {{ $enterpriseRecordStatus }}
                    </span>
                    <span class="badge badge-light-primary fs-7 px-4 py-3">
                        {{ $procurementProfile?->enterprise_status ?: 'Status pending' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion accordion-icon-toggle" id="enterprise_profile_accordion">
        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="enterprise_overview_heading">
                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#enterprise_overview_body" aria-expanded="true" aria-controls="enterprise_overview_body">
                    Enterprise Overview
                </button>
            </h2>
            <div id="enterprise_overview_body" class="accordion-collapse collapse show" aria-labelledby="enterprise_overview_heading" data-bs-parent="#enterprise_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-lg-4">
                            <div class="text-muted fs-7">Company Name</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->company_name ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="text-muted fs-7">Registration Number</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->registration_number ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="text-muted fs-7">VAT Number</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->vat_number ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="text-muted fs-7">Enterprise Type</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_type ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="text-muted fs-7">Enterprise Status</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_status ?: 'N/A' }}</div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="text-muted fs-7">Last Synced</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_synced_at?->format('Y-m-d H:i') ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="enterprise_contact_heading">
                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#enterprise_contact_body" aria-expanded="false" aria-controls="enterprise_contact_body">
                    Contact And Address
                </button>
            </h2>
            <div id="enterprise_contact_body" class="accordion-collapse collapse" aria-labelledby="enterprise_contact_heading" data-bs-parent="#enterprise_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Company Phone</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->company_phone ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-8">
                            <div class="text-muted fs-7">Registered Address</div>
                            <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_address ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="enterprise_verification_heading">
                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#enterprise_verification_body" aria-expanded="false" aria-controls="enterprise_verification_body">
                    Verification Details
                </button>
            </h2>
            <div id="enterprise_verification_body" class="accordion-collapse collapse" aria-labelledby="enterprise_verification_heading" data-bs-parent="#enterprise_profile_accordion">
                <div class="accordion-body">
                    <div class="row g-6">
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Verification Status</div>
                            <div class="fw-bold fs-5">{{ $record?->summary['status'] ?? $procurementProfile?->enterprise_status ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Reference</div>
                            <div class="fw-bold fs-5 text-break">{{ $record?->provider_reference ?: 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted fs-7">Transaction ID</div>
                            <div class="fw-bold fs-5 text-break">{{ $record?->summary['transaction_id'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($enterpriseData !== [])
            <div class="accordion-item">
                <h2 class="accordion-header" id="enterprise_api_heading">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#enterprise_api_body" aria-expanded="false" aria-controls="enterprise_api_body">
                        Additional Enterprise Data
                    </button>
                </h2>
                <div id="enterprise_api_body" class="accordion-collapse collapse" aria-labelledby="enterprise_api_heading" data-bs-parent="#enterprise_profile_accordion">
                    <div class="accordion-body">
                        <div class="row g-6">
                            @foreach ($enterpriseData as $label => $value)
                                @continue(is_array($value))
                                <div class="col-md-4">
                                    <div class="text-muted fs-7">{{ ucwords(str_replace('_', ' ', $label)) }}</div>
                                    <div class="fw-bold fs-5">{{ filled($value) ? $value : 'N/A' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
