@extends('layouts.app', [
    'title' => 'Procurement Dashboard | Akhani Connect',
    'heading' => 'Procurement Dashboard',
    'subheading' => 'Track your onboarding progress and complete verification-ready procurement details.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-body">
            <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between align-items-start gap-6">
                <div>
                    <h2 class="mb-3">Hi, {{ $user->full_name }}</h2>
                    <p class="text-gray-600 fs-6 mb-6">Complete your procurement profile and enterprise details below so the verification workflow can move cleanly into the next phase.</p>
                </div>
                <div class="text-end">
                    <span class="badge badge-light-primary fs-7">Account: Procurement</span>
                </div>
            </div>

            <div class="d-flex align-items-center mb-2">
                <span class="fw-bold text-gray-700 me-3">Progress</span>
                <span class="fw-bold text-warning">{{ $progress }}%</span>
            </div>
            <div class="progress h-10px bg-light-warning">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
        @foreach ($steps as $step)
            <div class="col-xl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-start">
                        <div class="symbol symbol-60px me-5">
                            <span class="symbol-label {{ $step['status'] === 'verified' ? 'bg-light-success' : 'bg-light-danger' }}">
                                <i class="bi {{ $step['status'] === 'verified' ? 'bi-check-circle' : 'bi-x-circle' }} fs-2 {{ $step['status'] === 'verified' ? 'text-success' : 'text-danger' }}"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bolder fs-3 {{ $step['status'] === 'verified' ? 'text-success' : 'text-danger' }}">
                                {{ ucfirst($step['status']) }}
                            </div>
                            <div class="fw-bold text-dark fs-5 mb-2">{{ $step['title'] }}</div>
                            <div class="text-gray-500 fs-7 mb-4">{{ $step['description'] }}</div>
                            @if ($step['route'])
                                <a href="{{ $step['route'] }}" class="btn btn-sm btn-light-primary">Open</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header border-0">
            <div class="card-title">
                <h3 class="fw-bolder m-0">Profile Details</h3>
            </div>
        </div>
        <div class="card-body pt-2">
            <div class="accordion accordion-icon-toggle" id="procurement_profile_summary">
                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_personal">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Personal Details</h3>
                    </div>
                    <div id="summary_personal" class="collapse show" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Full Name:</strong> {{ $user->full_name }}</div>
                            <div class="mb-2"><strong>Email Address:</strong> {{ $user->email }}</div>
                            <div class="mb-2"><strong>Phone:</strong> {{ $user->phone }}</div>
                            <div class="mb-2"><strong>ID Number:</strong> {{ $user->profile?->id_number ?: 'Not provided' }}</div>
                            <div class="mb-2"><strong>City:</strong> {{ $user->profile?->city ?: 'Not provided' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_enterprise">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Enterprise Details</h3>
                    </div>
                    <div id="summary_enterprise" class="collapse" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Company Name:</strong> {{ $user->procurementProfile?->company_name ?: 'Not provided' }}</div>
                            <div class="mb-2"><strong>Registration Number:</strong> {{ $user->procurementProfile?->registration_number ?: 'Not provided' }}</div>
                            <div class="mb-2"><strong>VAT Number:</strong> {{ $user->procurementProfile?->vat_number ?: 'Not provided' }}</div>
                            <div class="mb-2"><strong>Company Phone:</strong> {{ $user->procurementProfile?->company_phone ?: 'Not provided' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_directors">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Enterprise Directors</h3>
                    </div>
                    <div id="summary_directors" class="collapse" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Saved Directors:</strong> {{ $user->procurementProfile?->directors?->count() ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_documents">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Proof Of Address</h3>
                    </div>
                    <div id="summary_documents" class="collapse" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Uploaded Documents:</strong> {{ $user->documents->where('category', 'proof_of_address')->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_driver_licence">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Driver Licence</h3>
                    </div>
                    <div id="summary_driver_licence" class="collapse" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Status:</strong> {{ optional($user->verificationRecords->firstWhere('module', 'driver_licence'))->status ?: 'Pending' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="accordion-header py-3 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#summary_bank_account">
                        <span class="accordion-icon">
                            <i class="bi bi-chevron-right fs-4"></i>
                        </span>
                        <h3 class="fs-5 text-gray-800 fw-bold mb-0 ms-4">Bank Account Verification</h3>
                    </div>
                    <div id="summary_bank_account" class="collapse" data-bs-parent="#procurement_profile_summary">
                        <div class="pt-5 ps-12">
                            <div class="mb-2"><strong>Status:</strong> {{ optional($user->verificationRecords->firstWhere('module', 'bank_account'))->status ?: 'Pending' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
