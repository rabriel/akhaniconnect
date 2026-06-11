@extends('layouts.app', [
    'title' => 'Candidate Details | Akhani Connect',
    'heading' => $user->full_name,
    'subheading' => 'Candidate profile, documents, and application activity for superadmin review.',
])

@section('content')
    @php
        $profile = $user->profile;
        $candidateProfile = $user->candidateProfile;
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
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-light">Edit Account</a>
    </div>

    <div class="card mb-8">
        <div class="card-body py-8">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-6">
                <div>
                    <div class="fs-2 fw-bolder">{{ $user->full_name }}</div>
                    <div class="text-muted mt-2">
                        {{ $candidateProfile?->job_title ?: 'Candidate profile' }}
                        @if ($profile?->city)
                            | {{ $profile->city }}
                        @endif
                        @if ($profile?->province)
                            | {{ $profile->province }}
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge badge-light-primary fs-7 px-4 py-3">{{ $candidateDocuments->count() }} profile documents</span>
                    <span class="badge badge-light-info fs-7 px-4 py-3">{{ $applicationDocuments->count() }} application documents</span>
                    <span class="badge badge-light-success fs-7 px-4 py-3">{{ $applications->count() }} applications</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Candidate Data Review</h3>
            </div>
        </div>
        <div class="card-body pt-2">
            <div class="accordion accordion-icon-toggle" id="admin_candidate_detail_accordion">
                <div class="accordion-item mb-5">
                    <h2 class="accordion-header" id="admin_candidate_personal_heading">
                        <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#admin_candidate_personal_body" aria-expanded="true" aria-controls="admin_candidate_personal_body">Personal Details</button>
                    </h2>
                    <div id="admin_candidate_personal_body" class="accordion-collapse collapse show" aria-labelledby="admin_candidate_personal_heading" data-bs-parent="#admin_candidate_detail_accordion">
                        <div class="accordion-body">
                            <div class="row g-6">
                                <div class="col-lg-6"><div class="text-muted fs-7">Full Name</div><div class="fw-bold fs-5">{{ $user->full_name }}</div></div>
                                <div class="col-lg-6"><div class="text-muted fs-7">Email Address</div><div class="fw-bold fs-5 text-break">{{ $user->email }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">Phone</div><div class="fw-bold fs-5">{{ $user->phone ?: 'N/A' }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">ID Number</div><div class="fw-bold fs-5">{{ $profile?->id_number ?: 'N/A' }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">Gender</div><div class="fw-bold fs-5">{{ $profile?->gender ?: 'N/A' }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">City</div><div class="fw-bold fs-5">{{ $profile?->city ?: 'N/A' }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">Province</div><div class="fw-bold fs-5">{{ $profile?->province ?: 'N/A' }}</div></div>
                                <div class="col-md-4"><div class="text-muted fs-7">Postal Code</div><div class="fw-bold fs-5">{{ $profile?->postal_code ?: 'N/A' }}</div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-5">
                    <h2 class="accordion-header" id="admin_candidate_profile_heading">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#admin_candidate_profile_body" aria-expanded="false" aria-controls="admin_candidate_profile_body">Candidate Profile</button>
                    </h2>
                    <div id="admin_candidate_profile_body" class="accordion-collapse collapse" aria-labelledby="admin_candidate_profile_heading" data-bs-parent="#admin_candidate_detail_accordion">
                        <div class="accordion-body">
                            <div class="row g-6">
                                <div class="col-lg-4"><div class="text-muted fs-7">Job Title</div><div class="fw-bold fs-5">{{ $candidateProfile?->job_title ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Experience Level</div><div class="fw-bold fs-5">{{ $candidateProfile?->experience_level ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Employment Status</div><div class="fw-bold fs-5">{{ $candidateProfile?->employment_status ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Notice Period</div><div class="fw-bold fs-5">{{ $candidateProfile?->notice_period ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Relocation</div><div class="fw-bold fs-5">{{ $candidateProfile?->willing_to_relocate ? 'Yes' : 'No' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Industry</div><div class="fw-bold fs-5">{{ $candidateProfile?->job_industry ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Employment Type</div><div class="fw-bold fs-5">{{ $candidateProfile?->preferred_employment_type ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Salary Expectation</div><div class="fw-bold fs-5">{{ $candidateProfile?->salary_expectation ?: 'N/A' }}</div></div>
                                <div class="col-lg-4"><div class="text-muted fs-7">Education Level</div><div class="fw-bold fs-5">{{ $candidateProfile?->education_level ?: 'N/A' }}</div></div>
                                <div class="col-lg-12"><div class="text-muted fs-7">Education</div><div class="fw-bold fs-5">{{ $candidateProfile?->education ?: 'N/A' }}</div></div>
                                <div class="col-lg-12"><div class="text-muted fs-7">Certifications</div><div class="fw-bold fs-5">{{ $candidateProfile?->certifications ?: 'N/A' }}</div></div>
                                <div class="col-lg-12"><div class="text-muted fs-7">Experience</div><div class="fw-bold fs-5">{{ $candidateProfile?->experience ?: 'N/A' }}</div></div>
                                <div class="col-lg-12"><div class="text-muted fs-7">Skills</div><div class="fw-bold fs-5">{{ $candidateProfile?->skills ?: 'N/A' }}</div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-5">
                    <h2 class="accordion-header" id="admin_candidate_documents_heading">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#admin_candidate_documents_body" aria-expanded="false" aria-controls="admin_candidate_documents_body">Profile Documents</button>
                    </h2>
                    <div id="admin_candidate_documents_body" class="accordion-collapse collapse" aria-labelledby="admin_candidate_documents_heading" data-bs-parent="#admin_candidate_detail_accordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th>File</th><th>Type</th><th>Uploaded</th><th class="text-end">Action</th></tr></thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @forelse ($candidateDocuments as $document)
                                            @php
                                                $extension = strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION));
                                                $typeMeta = $documentTypeMeta[$extension] ?? ['badge' => 'secondary', 'icon' => 'bi-file-earmark'];
                                            @endphp
                                            <tr>
                                                <td>{{ $document->display_name ?: $document->original_name }}</td>
                                                <td><span class="d-inline-flex align-items-center gap-2 fw-semibold"><i class="bi {{ $typeMeta['icon'] }} fs-3 text-{{ $typeMeta['badge'] }}"></i><span>{{ strtoupper($extension !== '' ? $extension : 'file') }}</span></span></td>
                                                <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                                <td class="text-end"><a href="{{ route('admin.candidates.documents.show', [$user, $document]) }}" class="btn btn-sm btn-light-primary">Download</a></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-10 text-muted">No candidate profile documents uploaded yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-5">
                    <h2 class="accordion-header" id="admin_candidate_application_documents_heading">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#admin_candidate_application_documents_body" aria-expanded="false" aria-controls="admin_candidate_application_documents_body">Application Documents</button>
                    </h2>
                    <div id="admin_candidate_application_documents_body" class="accordion-collapse collapse" aria-labelledby="admin_candidate_application_documents_heading" data-bs-parent="#admin_candidate_detail_accordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th>File</th><th>Application</th><th>Type</th><th class="text-end">Action</th></tr></thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @forelse ($applicationDocuments as $document)
                                            @php
                                                $extension = strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION));
                                                $typeMeta = $documentTypeMeta[$extension] ?? ['badge' => 'secondary', 'icon' => 'bi-file-earmark'];
                                                $application = $applications->firstWhere('id', $document->application_id);
                                            @endphp
                                            <tr>
                                                <td>{{ $document->display_name ?: $document->original_name }}</td>
                                                <td>{{ $application?->job?->title ?: 'Application record' }}</td>
                                                <td><span class="d-inline-flex align-items-center gap-2 fw-semibold"><i class="bi {{ $typeMeta['icon'] }} fs-3 text-{{ $typeMeta['badge'] }}"></i><span>{{ strtoupper($extension !== '' ? $extension : 'file') }}</span></span></td>
                                                <td class="text-end"><a href="{{ route('admin.candidates.documents.show', [$user, $document]) }}" class="btn btn-sm btn-light-primary">Download</a></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-10 text-muted">No application documents uploaded yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="admin_candidate_applications_heading">
                        <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#admin_candidate_applications_body" aria-expanded="false" aria-controls="admin_candidate_applications_body">Applications</button>
                    </h2>
                    <div id="admin_candidate_applications_body" class="accordion-collapse collapse" aria-labelledby="admin_candidate_applications_heading" data-bs-parent="#admin_candidate_detail_accordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead><tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"><th>Job</th><th>Status</th><th>Applied</th><th>Documents</th></tr></thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @forelse ($applications as $application)
                                            <tr>
                                                <td>{{ $application->job?->title ?: 'Job no longer available' }}</td>
                                                <td><span class="badge badge-light-primary">{{ ucfirst($application->status) }}</span></td>
                                                <td>{{ $application->applied_at?->format('d M Y H:i') ?? $application->created_at?->format('d M Y H:i') }}</td>
                                                <td>{{ $application->documents_count }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-10 text-muted">No applications submitted yet.</td></tr>
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
@endsection
