@extends('layouts.app', [
    'title' => 'Procurement Dashboard | Akhani Connect',
    'heading' => 'Procurement Dashboard',
    'subheading' => 'Track your onboarding progress and complete verification-ready procurement details.',
])

@section('content')
    @php
        $progressTextClass = $progress === 100 ? 'text-success' : 'text-warning';
        $progressTrackClass = $progress === 100 ? 'bg-light-success' : 'bg-light-warning';
        $progressBarClass = $progress === 100 ? 'bg-success' : 'bg-warning';
    @endphp

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
                <span class="fw-bold {{ $progressTextClass }}">{{ $progress }}%</span>
            </div>
            <div class="progress h-10px {{ $progressTrackClass }}">
                <div class="progress-bar {{ $progressBarClass }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
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
                            @if (($step['exclude_from_progress'] ?? false) === true)
                                <div class="text-muted fs-8 mb-4">Optional for progress tracking.</div>
                            @endif
                            @if ($step['route'])
                                <a href="{{ $step['route'] }}" class="btn btn-sm {{ $step['status'] === 'verified' ? 'btn-light-success' : 'btn-light-primary' }}">Open</a>
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
                <h3 class="fw-bolder m-0">Profile Summary</h3>
            </div>
        </div>
        <div class="card-body pt-2">
            @php
                $profile = $user->profile;
                $procurementProfile = $user->procurementProfile;
                $directors = $procurementProfile?->directors ?? collect();
                $verifiedDirectors = $directors->where('status', 'verified')->count();
                $driverRecord = $user->verificationRecords->firstWhere('module', 'driver_licence');
                $driverDocuments = $user->documents->where('category', 'driver_licence');
                $driverStatus = $driverRecord?->status ?? 'pending';
                $statusClass = fn (string $status): string => match ($status) {
                    'verified' => 'success',
                    'failed' => 'danger',
                    'in_progress' => 'warning',
                    default => 'primary',
                };
                $statusLabel = fn (string $status): string => str($status)->replace('_', ' ')->title();
            @endphp

            <div class="accordion" id="procurement_profile_summary">
                <div class="accordion-item border-0 mb-5 rounded overflow-hidden">
                    <h2 class="accordion-header" id="summary_personal_heading">
                        <button class="accordion-button bg-light-success bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#summary_personal" aria-expanded="true" aria-controls="summary_personal">
                            <span>Personal Details</span>
                            <span class="badge badge-light-success ms-4">Verified Profile</span>
                        </button>
                    </h2>
                    <div id="summary_personal" class="accordion-collapse collapse show" aria-labelledby="summary_personal_heading" data-bs-parent="#procurement_profile_summary">
                        <div class="accordion-body bg-white pt-6">
                            <div class="row g-5">
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Full Name</div>
                                        <div class="fw-bold fs-5">{{ $user->full_name }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Email Address</div>
                                        <div class="fw-bold fs-5 text-break">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Phone</div>
                                        <div class="fw-bold fs-5">{{ $user->phone ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">ID Number</div>
                                        <div class="fw-bold fs-5">{{ $profile?->id_number ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">City</div>
                                        <div class="fw-bold fs-5">{{ $profile?->city ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Province</div>
                                        <div class="fw-bold fs-5">{{ $profile?->province ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Postal Code</div>
                                        <div class="fw-bold fs-5">{{ $profile?->postal_code ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Gender</div>
                                        <div class="fw-bold fs-5">{{ $profile?->gender ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 mb-5 rounded overflow-hidden">
                    <h2 class="accordion-header" id="summary_enterprise_heading">
                        <button class="accordion-button collapsed bg-light-primary bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#summary_enterprise" aria-expanded="false" aria-controls="summary_enterprise">
                            <span>Enterprise Details</span>
                            <span class="badge badge-light-primary ms-4">{{ filled($procurementProfile?->company_name) ? 'CIPC Synced' : 'Awaiting Verification' }}</span>
                        </button>
                    </h2>
                    <div id="summary_enterprise" class="accordion-collapse collapse" aria-labelledby="summary_enterprise_heading" data-bs-parent="#procurement_profile_summary">
                        <div class="accordion-body bg-white pt-6">
                            <div class="row g-5">
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Company Name</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->company_name ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Registration Number</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->registration_number ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">VAT Number</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->vat_number ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Company Phone</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->company_phone ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Enterprise Status</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_status ?: 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Last Synced</div>
                                        <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_synced_at?->format('Y-m-d H:i') ?: 'Not synced yet' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 mb-5 rounded overflow-hidden">
                    <h2 class="accordion-header" id="summary_directors_heading">
                        <button class="accordion-button collapsed bg-light-info bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#summary_directors" aria-expanded="false" aria-controls="summary_directors">
                            <span>Enterprise Directors</span>
                            <span class="badge badge-light-info ms-4">{{ $verifiedDirectors }} Verified</span>
                        </button>
                    </h2>
                    <div id="summary_directors" class="accordion-collapse collapse" aria-labelledby="summary_directors_heading" data-bs-parent="#procurement_profile_summary">
                        <div class="accordion-body bg-white pt-6">
                            <div class="row g-5">
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-info bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Saved Directors</div>
                                        <div class="fw-bold fs-5">{{ $directors->count() }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-info bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Verified Directors</div>
                                        <div class="fw-bold fs-5">{{ $verifiedDirectors }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-info bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Latest Director</div>
                                        <div class="fw-bold fs-5">{{ $directors->sortByDesc('updated_at')->first()?->full_name ?: 'Not added yet' }}</div>
                                    </div>
                                </div>
                            </div>

                            @if ($directors->isNotEmpty())
                                <div class="table-responsive mt-6">
                                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                                        <thead>
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                <th>Director</th>
                                                <th>ID Number</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-700">
                                            @foreach ($directors->take(5) as $director)
                                                <tr>
                                                    <td>{{ $director->full_name ?: 'Pending verification' }}</td>
                                                    <td>{{ $director->id_number }}</td>
                                                    <td>
                                                        <span class="badge badge-light-{{ $statusClass($director->status ?? 'pending') }}">
                                                            {{ $statusLabel($director->status ?? 'pending') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 rounded overflow-hidden">
                    <h2 class="accordion-header" id="summary_driver_heading">
                        <button class="accordion-button collapsed bg-light-warning bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#summary_driver" aria-expanded="false" aria-controls="summary_driver">
                            <span>Driver Licence</span>
                            <span class="badge badge-light-{{ $statusClass($driverStatus) }} ms-4">{{ $statusLabel($driverStatus) }}</span>
                        </button>
                    </h2>
                    <div id="summary_driver" class="accordion-collapse collapse" aria-labelledby="summary_driver_heading" data-bs-parent="#procurement_profile_summary">
                        <div class="accordion-body bg-white pt-6">
                            <div class="row g-5">
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-warning bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Verification Status</div>
                                        <div class="fw-bold fs-5">{{ $statusLabel($driverStatus) }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-warning bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Uploaded Files</div>
                                        <div class="fw-bold fs-5">{{ $driverDocuments->count() }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-warning bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Last Verified</div>
                                        <div class="fw-bold fs-5">{{ $driverRecord?->last_verified_at?->format('Y-m-d H:i') ?: 'Not verified yet' }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="rounded border border-gray-200 bg-light-warning bg-opacity-25 p-4 h-100">
                                        <div class="text-muted fs-7 mb-1">Reference</div>
                                        <div class="fw-bold fs-5 text-break">{{ $driverRecord?->provider_reference ?: 'Pending' }}</div>
                                    </div>
                                </div>
                            </div>

                            @if ($driverDocuments->isNotEmpty())
                                <div class="table-responsive mt-6">
                                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                                        <thead>
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                <th>File Name</th>
                                                <th>Type</th>
                                                <th>Uploaded</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-700">
                                            @foreach ($driverDocuments as $document)
                                                <tr>
                                                    <td>{{ $document->original_name }}</td>
                                                    <td>{{ str($document->type)->replace('_', ' ')->title() }}</td>
                                                    <td>{{ $document->uploaded_at?->format('Y-m-d H:i') ?: 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="rounded border border-dashed border-gray-300 bg-light-warning bg-opacity-10 px-5 py-4 mt-6">
                                    <div class="fw-bold mb-1">No driver licence files uploaded yet</div>
                                    <div class="text-muted fs-7">Upload the front and optional back image to start driver licence verification.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
