@extends('layouts.app', [
    'title' => 'Procurement Record | Akhani Connect',
    'heading' => $user->full_name,
    'subheading' => ($user->procurementProfile?->company_name ?? 'Procurement account') . ' | Verified procurement review',
])

@section('content')
    @php
        $profile = $user->profile;
        $procurementProfile = $user->procurementProfile;
        $enterpriseBadge = $enterpriseRecord?->status === 'verified'
            ? 'success'
            : ($enterpriseRecord?->status === 'failed' ? 'danger' : 'warning');
        $documentTypeMeta = [
            'pdf' => ['badge' => 'danger', 'icon' => 'bi-file-earmark-pdf'],
            'doc' => ['badge' => 'primary', 'icon' => 'bi-file-earmark-word'],
            'docx' => ['badge' => 'primary', 'icon' => 'bi-file-earmark-word'],
            'jpg' => ['badge' => 'success', 'icon' => 'bi-file-earmark-image'],
            'jpeg' => ['badge' => 'success', 'icon' => 'bi-file-earmark-image'],
            'png' => ['badge' => 'success', 'icon' => 'bi-file-earmark-image'],
            'webp' => ['badge' => 'success', 'icon' => 'bi-file-earmark-image'],
        ];
    @endphp

    <div class="d-flex flex-wrap justify-content-end gap-3 mb-8">
        <a href="{{ route('client.procurement-records.report', $user) }}" class="btn btn-primary">Download Full PDF</a>
        <a href="{{ route('client.procurement-records.enterprise-report', $user) }}" class="btn btn-light-primary">Download Enterprise PDF</a>
    </div>

    <div class="card mb-8">
        <div class="card-body py-8">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-6">
                <div>
                    <div class="fs-2 fw-bolder">{{ $procurementProfile?->company_name ?: $user->full_name }}</div>
                    <div class="text-muted mt-2">
                        {{ $procurementProfile?->registration_number ?: 'Registration number pending' }}
                        @if ($procurementProfile?->enterprise_type)
                            | {{ $procurementProfile->enterprise_type }}
                        @endif
                        @if ($profile?->id_number)
                            | ID {{ $profile->id_number }}
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge badge-light-{{ ($procurementProfile?->verification_progress ?? 0) === 100 ? 'success' : 'warning' }} fs-7 px-4 py-3">
                        Progress {{ $procurementProfile?->verification_progress ?? 0 }}%
                    </span>
                    <span class="badge badge-light-success fs-7 px-4 py-3">
                        {{ $verifiedModules->count() }} verified modules
                    </span>
                    <span class="badge badge-light-primary fs-7 px-4 py-3">
                        {{ $verifiedDirectors->count() }} verified directors
                    </span>
                    <span class="badge badge-light-info fs-7 px-4 py-3">
                        {{ $procurementDocuments->count() }} documents
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xl-8">
            <div class="card mb-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Verified Procurement Information</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="accordion accordion-icon-toggle" id="client_procurement_record_accordion">
                        <div class="accordion-item mb-5">
                            <h2 class="accordion-header" id="client_personal_heading">
                                <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#client_personal_body" aria-expanded="true" aria-controls="client_personal_body">
                                    Personal Details
                                </button>
                            </h2>
                            <div id="client_personal_body" class="accordion-collapse collapse show" aria-labelledby="client_personal_heading" data-bs-parent="#client_procurement_record_accordion">
                                <div class="accordion-body">
                                    <div class="row g-8">
                                        <div class="col-lg-6">
                                            <div class="border border-gray-200 rounded p-5 h-100 bg-light">
                                                <div class="row g-5">
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Full Name</div>
                                                        <div class="fw-bold fs-5">{{ $user->full_name }}</div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Phone</div>
                                                        <div class="fw-bold fs-5">{{ $user->phone ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Date Of Birth</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->date_of_birth?->format('Y-m-d') ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Address Line 1</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->address_line_1 ?: 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="border border-gray-200 rounded p-5 h-100 bg-light">
                                                <div class="row g-5">
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Email Address</div>
                                                        <div class="fw-bold fs-5 text-break">{{ $user->email }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-muted fs-7 mb-2">ID Number</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->id_number ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-muted fs-7 mb-2">Gender</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->gender ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-muted fs-7 mb-2">City</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->city ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-muted fs-7 mb-2">Postal Code</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->postal_code ?: 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-muted fs-7 mb-2">Address Line 2</div>
                                                        <div class="fw-bold fs-5">{{ $profile?->address_line_2 ?: 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-5">
                            <h2 class="accordion-header" id="client_enterprise_heading">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#client_enterprise_body" aria-expanded="false" aria-controls="client_enterprise_body">
                                    Enterprise Details
                                </button>
                            </h2>
                            <div id="client_enterprise_body" class="accordion-collapse collapse" aria-labelledby="client_enterprise_heading" data-bs-parent="#client_procurement_record_accordion">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4 mb-6">
                                        <div>
                                            <div class="fw-bold fs-4">{{ $procurementProfile?->company_name ?: 'Enterprise record pending' }}</div>
                                            <div class="text-muted fs-7 mt-1">
                                                {{ $procurementProfile?->registration_number ?: 'Registration number not available' }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-3">
                                            <span class="badge badge-light-{{ $enterpriseBadge }} fs-7 px-4 py-3">
                                                {{ $enterpriseRecord?->status ? ucfirst($enterpriseRecord->status) : 'Pending' }}
                                            </span>
                                            <a href="{{ route('client.procurement-records.enterprise-report', $user) }}" class="btn btn-sm btn-light-primary">Download Enterprise PDF</a>
                                        </div>
                                    </div>

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
                                        <div class="col-lg-4 col-md-6">
                                            <div class="text-muted fs-7">Company Phone</div>
                                            <div class="fw-bold fs-5">{{ $procurementProfile?->company_phone ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="text-muted fs-7">Registered Address</div>
                                            <div class="fw-bold fs-5">{{ $procurementProfile?->enterprise_address ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="text-muted fs-7">Reference</div>
                                            <div class="fw-bold fs-5 text-break">{{ $enterpriseRecord?->provider_reference ?: 'N/A' }}</div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="text-muted fs-7">Transaction ID</div>
                                            <div class="fw-bold fs-5 text-break">{{ $enterpriseRecord?->summary['transaction_id'] ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="text-muted fs-7">Verification Status</div>
                                            <div class="fw-bold fs-5">{{ $enterpriseRecord?->summary['status'] ?? $procurementProfile?->enterprise_status ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-5">
                            <h2 class="accordion-header" id="client_directors_heading">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#client_directors_body" aria-expanded="false" aria-controls="client_directors_body">
                                    Enterprise Directors
                                </button>
                            </h2>
                            <div id="client_directors_body" class="accordion-collapse collapse" aria-labelledby="client_directors_heading" data-bs-parent="#client_procurement_record_accordion">
                                <div class="accordion-body">
                                    @if ($verifiedDirectors->isNotEmpty())
                                        <div class="accordion accordion-flush" id="client_director_items">
                                            @foreach ($verifiedDirectors as $director)
                                                <div class="accordion-item border rounded mb-5">
                                                    <h2 class="accordion-header" id="client_director_heading_{{ $director->id }}">
                                                        <button class="accordion-button collapsed fs-5 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#client_director_body_{{ $director->id }}" aria-expanded="false" aria-controls="client_director_body_{{ $director->id }}">
                                                            <span>
                                                                {{ $director->full_name ?: 'Director Record' }}
                                                                <span class="text-muted fs-7 d-block mt-1">
                                                                    {{ $director->id_number ?: 'ID not available' }}
                                                                    @if ($director->position)
                                                                        | {{ $director->position }}
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="client_director_body_{{ $director->id }}" class="accordion-collapse collapse" aria-labelledby="client_director_heading_{{ $director->id }}" data-bs-parent="#client_director_items">
                                                        <div class="accordion-body">
                                                            <div class="d-flex justify-content-end mb-5">
                                                                <a href="{{ route('client.procurement-records.director-report', [$user, $director]) }}" class="btn btn-sm btn-light-primary">Download Director PDF</a>
                                                            </div>
                                                            <div class="row g-6">
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Full Name</div>
                                                                    <div class="fw-bold fs-5">{{ $director->full_name ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Initials</div>
                                                                    <div class="fw-bold fs-5">{{ $director->initials ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">ID Number</div>
                                                                    <div class="fw-bold fs-5">{{ $director->id_number ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="text-muted fs-7">Birth Date</div>
                                                                    <div class="fw-bold fs-5">{{ $director->birth_date?->format('Y-m-d') ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="text-muted fs-7">Gender</div>
                                                                    <div class="fw-bold fs-5">{{ $director->gender ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="text-muted fs-7">Title</div>
                                                                    <div class="fw-bold fs-5">{{ $director->title ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6">
                                                                    <div class="text-muted fs-7">Marital Status</div>
                                                                    <div class="fw-bold fs-5">{{ $director->marital_status ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Director Status</div>
                                                                    <div class="fw-bold fs-5">{{ $director->director_status ?: ucfirst($director->status) }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Employer</div>
                                                                    <div class="fw-bold fs-5">{{ $director->employer ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Number Of Enquiries</div>
                                                                    <div class="fw-bold fs-5">{{ $director->number_of_enquiries ?? 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Cellular Number</div>
                                                                    <div class="fw-bold fs-5">{{ $director->cellular_number ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Home Telephone</div>
                                                                    <div class="fw-bold fs-5">{{ $director->home_telephone ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <div class="text-muted fs-7">Work Telephone</div>
                                                                    <div class="fw-bold fs-5">{{ $director->work_telephone ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="text-muted fs-7">Email Address</div>
                                                                    <div class="fw-bold fs-5 text-break">{{ $director->email_address ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="text-muted fs-7">Privacy Status</div>
                                                                    <div class="fw-bold fs-5">{{ $director->privacy_status ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="text-muted fs-7">Residential Address</div>
                                                                    <div class="fw-bold fs-5">{{ $director->residential_address ?: 'N/A' }}</div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="text-muted fs-7">Postal Address</div>
                                                                    <div class="fw-bold fs-5">{{ $director->postal_address ?: 'N/A' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-muted">No verified directors are available for this procurement profile yet.</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-5">
                            <h2 class="accordion-header" id="client_documents_heading">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#client_documents_body" aria-expanded="false" aria-controls="client_documents_body">
                                    Procurement Documents
                                </button>
                            </h2>
                            <div id="client_documents_body" class="accordion-collapse collapse" aria-labelledby="client_documents_heading" data-bs-parent="#client_procurement_record_accordion">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th>Document Name</th>
                                                    <th>Original File</th>
                                                    <th>Type</th>
                                                    <th>Uploaded</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-semibold">
                                                @forelse ($procurementDocuments as $document)
                                                    @php
                                                        $extension = strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION));
                                                        $typeMeta = $documentTypeMeta[$extension] ?? ['badge' => 'secondary', 'icon' => 'bi-file-earmark'];
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $document->display_name ?: pathinfo($document->original_name, PATHINFO_FILENAME) }}</td>
                                                        <td>{{ $document->original_name }}</td>
                                                        <td>
                                                            <span class="d-inline-flex align-items-center gap-2 fw-semibold">
                                                                <i class="bi {{ $typeMeta['icon'] }} fs-3 text-{{ $typeMeta['badge'] }}"></i>
                                                                <span>{{ strtoupper($extension !== '' ? $extension : 'file') }}</span>
                                                            </span>
                                                        </td>
                                                        <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('client.procurement-records.documents.show', [$user, $document]) }}" class="btn btn-sm btn-light-primary">Download</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-10 text-muted">No procurement documents have been uploaded yet.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="client_records_heading">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#client_records_body" aria-expanded="false" aria-controls="client_records_body">
                                    Verification Records
                                </button>
                            </h2>
                            <div id="client_records_body" class="accordion-collapse collapse" aria-labelledby="client_records_heading" data-bs-parent="#client_procurement_record_accordion">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th>Module</th>
                                                    <th>Status</th>
                                                    <th>Reference</th>
                                                    <th>Last Verified</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-semibold">
                                                @forelse ($user->verificationRecords as $verificationRecord)
                                                    <tr>
                                                        <td>{{ str_replace('_', ' ', ucfirst($verificationRecord->module)) }}</td>
                                                        <td>
                                                            <span class="badge badge-light-{{ $verificationRecord->status === 'verified' ? 'success' : ($verificationRecord->status === 'failed' ? 'danger' : 'warning') }}">
                                                                {{ ucfirst($verificationRecord->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $verificationRecord->provider_reference ?? 'N/A' }}</td>
                                                        <td>{{ $verificationRecord->last_verified_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-10 text-muted">No verification records captured yet.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Review Snapshot</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded bg-light-success bg-opacity-50 p-5 mb-5">
                        <div class="text-muted fs-7 mb-1">Enterprise Verification</div>
                        <div class="fw-bold fs-4">{{ $enterpriseRecord?->status ? ucfirst($enterpriseRecord->status) : 'Pending' }}</div>
                    </div>
                    <div class="rounded bg-light-primary bg-opacity-50 p-5 mb-5">
                        <div class="text-muted fs-7 mb-1">Verified Modules</div>
                        <div class="fw-bold fs-4">{{ $verifiedModules->implode(', ') ?: 'None yet' }}</div>
                    </div>
                    <div class="rounded bg-light-info bg-opacity-50 p-5">
                        <div class="text-muted fs-7 mb-1">Supporting Documents</div>
                        <div class="fw-bold fs-4">{{ $procurementDocuments->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Send Follow-up</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('client.procurement-records.notify', $user) }}">
                        @csrf
                        <div class="mb-5">
                            <label class="form-label required">Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                        </div>
                        <div class="mb-5">
                            <label class="form-label required">Message</label>
                            <textarea name="message" rows="8" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
