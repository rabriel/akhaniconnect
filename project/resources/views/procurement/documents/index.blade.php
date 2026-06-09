@extends('layouts.app', [
    'title' => 'Procurement Documents | Akhani Connect',
    'heading' => 'Procurement Documents',
    'subheading' => 'Upload named supporting documents for client review and procurement onboarding.',
])

@section('content')
    @php
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

    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Upload Documents</h3>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('procurement.documents.store') }}" enctype="multipart/form-data" id="procurement_documents_form">
                @csrf

                <div
                    id="procurement_document_repeater"
                    data-max-items="10"
                    data-initial-count="{{ max(1, count(old('documents', [0]))) }}"
                >
                    @php($oldDocuments = old('documents', [['name' => '', 'file' => null]]))

                    @foreach ($oldDocuments as $index => $oldDocument)
                        <div class="border border-gray-200 rounded p-5 mb-5 procurement-document-item" data-repeater-item>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="fw-bold fs-5">Document {{ $loop->iteration }}</div>
                                <button type="button" class="btn btn-sm btn-light-danger procurement-document-remove" @disabled($loop->count === 1)>Remove</button>
                            </div>
                            <div class="row g-5">
                                <div class="col-lg-6">
                                    <label class="form-label required">Document Name</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-solid"
                                        name="documents[{{ $index }}][name]"
                                        value="{{ $oldDocument['name'] ?? '' }}"
                                        placeholder="Example: BBBEE Certificate"
                                        required
                                    >
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label required">File</label>
                                    <input
                                        type="file"
                                        class="form-control form-control-solid"
                                        name="documents[{{ $index }}][file]"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
                    <div class="text-muted fs-7">
                        Accepted formats: PDF, Word, JPG, PNG, or WEBP. Maximum size: 5 MB per file.
                    </div>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-light-primary" id="procurement_document_add">Add Another Document</button>
                        <button type="submit" class="btn btn-primary">Upload Documents</button>
                    </div>
                </div>
            </form>
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
                            <th>Document Name</th>
                            <th>Original File</th>
                            <th>Type</th>
                            <th>Uploaded</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($documents as $document)
                            <tr>
                                <td>{{ $document->display_name ?: pathinfo($document->original_name, PATHINFO_FILENAME) }}</td>
                                <td>{{ $document->original_name }}</td>
                                <td>
                                    @php($extension = strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION)))
                                    @php($typeMeta = $documentTypeMeta[$extension] ?? ['badge' => 'secondary', 'icon' => 'bi-file-earmark'])
                                    <span class="d-inline-flex align-items-center gap-2 fw-semibold">
                                        <i class="bi {{ $typeMeta['icon'] }} fs-3 text-{{ $typeMeta['badge'] }}"></i>
                                        <span>{{ strtoupper($extension !== '' ? $extension : 'file') }}</span>
                                    </span>
                                </td>
                                <td>{{ $document->uploaded_at?->format('d M Y H:i') ?? $document->created_at?->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('procurement.documents.show', $document) }}" class="btn btn-sm btn-light-primary">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-muted">No procurement documents uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <template id="procurement_document_template">
        <div class="border border-gray-200 rounded p-5 mb-5 procurement-document-item" data-repeater-item>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="fw-bold fs-5">Document</div>
                <button type="button" class="btn btn-sm btn-light-danger procurement-document-remove">Remove</button>
            </div>
            <div class="row g-5">
                <div class="col-lg-6">
                    <label class="form-label required">Document Name</label>
                    <input
                        type="text"
                        class="form-control form-control-solid"
                        data-field="name"
                        placeholder="Example: BBBEE Certificate"
                        required
                    >
                </div>
                <div class="col-lg-6">
                    <label class="form-label required">File</label>
                    <input
                        type="file"
                        class="form-control form-control-solid"
                        data-field="file"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp"
                        required
                    >
                </div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/procurement-documents.js') }}"></script>
@endpush
