@extends('layouts.app', [
    'title' => 'Candidate Documents | Akhani Connect',
    'heading' => 'Candidate Documents',
    'subheading' => 'Upload your CV, qualifications, licences, and supporting documents for recruiter review.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-body">
            <div class="row g-5 align-items-end">
                <div class="col-xl-12">
                    <label class="form-label required">Document Type</label>
                    <select id="candidate_document_type" class="form-select">
                        <option value="">Select document type</option>
                        @foreach ($documentTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-12">
                    <div id="candidate_document_dropzone"
                         class="dropzone border-dashed border-primary min-h-200px"
                         data-upload-url="{{ route('candidate.documents.store') }}"
                         data-csrf-token="{{ csrf_token() }}">
                        <div class="dz-message needsclick">
                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                            <div class="ms-4">
                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                <span class="fs-7 fw-semibold text-muted">Upload PDF, Word, JPG, or PNG files up to 5MB each.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Uploaded Documents</h3>
            </div>
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
                        @forelse ($documents as $document)
                            <tr>
                                <td>{{ $document->original_name }}</td>
                                <td>{{ $documentTypes[$document->type] ?? ucwords(str_replace('_', ' ', $document->type)) }}</td>
                                <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('candidate.documents.show', $document) }}" class="btn btn-sm btn-light-primary">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-muted">No candidate documents uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/candidate-documents.js') }}"></script>
@endpush
