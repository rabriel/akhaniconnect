@extends('layouts.app', [
    'title' => 'Driver Licence Verification | Akhani Connect',
    'heading' => 'Driver Licence Verification',
    'subheading' => 'Submit driver licence images and track verification attempts.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Submit Driver Licence</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('procurement.verifications.driver-licence.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Front image</label>
                        <input class="form-control form-control-lg form-control-solid" type="file" name="front_image" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Back image (optional)</label>
                        <input class="form-control form-control-lg form-control-solid" type="file" name="back_image">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit Verification</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Uploaded Driver Licence Documents</h2>
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
                                <td>{{ $document->type }}</td>
                                <td><span class="badge badge-light-success">{{ ucfirst($document->status) }}</span></td>
                                <td>{{ $document->uploaded_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10">No driver licence files uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Verification History</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            @if ($record)
                <div class="mb-5">
                    <span class="badge badge-light-{{ $record->status === 'verified' ? 'success' : ($record->status === 'failed' ? 'danger' : 'warning') }}">
                        {{ ucfirst($record->status) }}
                    </span>
                    @if ($record->provider_reference)
                        <span class="ms-4 text-muted">Reference: {{ $record->provider_reference }}</span>
                    @endif
                </div>
            @endif
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Attempted</th>
                            <th>Status</th>
                            <th>Reference</th>
                            <th>Error</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($record?->attempts?->sortByDesc('attempted_at') ?? [] as $attempt)
                            <tr>
                                <td>{{ $attempt->attempted_at?->format('Y-m-d H:i') }}</td>
                                <td>{{ ucfirst($attempt->status) }}</td>
                                <td>{{ $attempt->provider_reference ?: 'N/A' }}</td>
                                <td>{{ $attempt->error_message ?: 'None' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10">No verification attempts recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
