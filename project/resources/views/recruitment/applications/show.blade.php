@extends('layouts.app', [
    'title' => 'Application Review | Akhani Connect',
    'heading' => 'Application Review',
    'subheading' => ($application->candidate?->full_name ?? 'Candidate') . ' | ' . ($application->job?->title ?? 'Job'),
])

@section('content')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-7">
            <div class="card mb-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Candidate Summary</h3></div>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Name</div>
                            <div class="fw-bold">{{ $application->candidate?->full_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Email</div>
                            <div class="fw-bold">{{ $application->candidate?->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Phone</div>
                            <div class="fw-bold">{{ $application->candidate?->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Current Title</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->job_title ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Experience Level</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->experience_level ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Employment Status</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->employment_status ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Notice Period</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->notice_period ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Relocation</div>
                            <div class="fw-bold">
                                @if (is_null($application->candidate?->candidateProfile?->willing_to_relocate))
                                    Not set
                                @else
                                    {{ $application->candidate?->candidateProfile?->willing_to_relocate ? 'Yes' : 'No' }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Job Industry</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->job_industry ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Employment Type</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->preferred_employment_type ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Salary Expectation</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->salary_expectation ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Education Level</div>
                            <div class="fw-bold">{{ $application->candidate?->candidateProfile?->education_level ?? 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-8"></div>
                    <div class="text-muted fs-7 mb-2">Professional Summary</div>
                    <div class="text-gray-800 fs-6">{{ $application->candidate?->candidateProfile?->bio ?? 'No summary provided yet.' }}</div>

                    <div class="separator separator-dashed my-8"></div>
                    <div class="row g-5">
                        <div class="col-12">
                            <div class="text-muted fs-7 mb-2">Education</div>
                            <div class="text-gray-800 fs-6">{{ $application->candidate?->candidateProfile?->education ?? 'No education details provided yet.' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted fs-7 mb-2">Certifications</div>
                            <div class="text-gray-800 fs-6">{{ $application->candidate?->candidateProfile?->certifications ?? 'No certifications added yet.' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted fs-7 mb-2">Experience</div>
                            <div class="text-gray-800 fs-6">{{ $application->candidate?->candidateProfile?->experience ?? 'No experience details provided yet.' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted fs-7 mb-2">Skills</div>
                            <div class="text-gray-800 fs-6">{{ $application->candidate?->candidateProfile?->skills ?? 'No skills provided yet.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Application Details</h3></div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-4"><strong>Job:</strong> {{ $application->job?->title }}</div>
                    <div class="mb-4"><strong>Applied:</strong> {{ optional($application->applied_at ?? $application->created_at)->format('d M Y H:i') }}</div>
                    <div class="mb-4"><strong>Status:</strong> {{ ucfirst($application->status) }}</div>
                    <div class="mb-4"><strong>Cover Letter:</strong></div>
                    <div class="text-gray-800 fs-6">{{ $application->cover_letter ?: 'No cover letter submitted.' }}</div>
                </div>
            </div>

            <div class="card mt-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Candidate Documents</h3></div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Uploaded</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse ($application->documents as $document)
                                    <tr>
                                        <td>{{ $document->original_name }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ', $document->type)) }}</td>
                                        <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('recruitment.applications.documents.show', [$application, $document]) }}" class="btn btn-sm btn-light-primary">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-muted">No application documents uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Candidate Profile Documents</h3></div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Uploaded</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @php($candidateDocuments = $application->candidate?->documents?->where('category', 'candidate_profile') ?? collect())
                                @forelse ($candidateDocuments as $document)
                                    <tr>
                                        <td>{{ $document->original_name }}</td>
                                        <td>{{ config('south_africa.candidate_document_types.' . $document->type, ucwords(str_replace('_', ' ', $document->type))) }}</td>
                                        <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('recruitment.applications.candidate-documents.show', [$application, $document]) }}" class="btn btn-sm btn-light-primary">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-muted">No candidate profile documents uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card mb-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Review Workflow</h3></div>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('recruitment.applications.update', $application) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-5">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach (['submitted', 'reviewing', 'shortlisted', 'interviewed', 'rejected', 'hired'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $application->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Reviewer Notes</label>
                            <textarea name="reviewer_notes" rows="6" class="form-control">{{ old('reviewer_notes', $application->reviewer_notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save review</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Contact Candidate</h3></div>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('recruitment.applications.notify', $application) }}">
                        @csrf
                        <div class="mb-5">
                            <label class="form-label required">Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                        </div>
                        <div class="mb-5">
                            <label class="form-label required">Message</label>
                            <textarea name="message" rows="7" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-light-primary w-100">Send notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
