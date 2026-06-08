@extends('layouts.app', [
    'title' => 'Proof Of Address | Akhani Connect',
    'heading' => 'Proof Of Address',
    'subheading' => 'Upload a current proof of address document for the procurement workflow.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Upload Document</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('procurement.documents.proof-of-address.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="form-label fs-6 fw-bold mb-3">Proof of address file</label>
                    <input class="form-control form-control-lg form-control-solid" type="file" name="document" required>
                    <div class="text-muted mt-2">Accepted formats: PDF, JPG, JPEG, PNG. Maximum size: 5 MB.</div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Upload Document</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Uploaded Documents</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>File Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Uploaded</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($documents as $document)
                            <tr>
                                <td>{{ $document->original_name }}</td>
                                <td>{{ strtoupper(pathinfo($document->original_name, PATHINFO_EXTENSION)) }}</td>
                                <td>
                                    <span class="badge badge-light-success">{{ ucfirst($document->status) }}</span>
                                </td>
                                <td>{{ $document->uploaded_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10">No proof of address documents uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
