@extends('layouts.app', [
    'title' => 'Candidate Driver Licence Verification | Akhani Connect',
    'heading' => 'Driver Licence Verification',
    'subheading' => 'Upload your licence images and verify them through the API.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Submit Driver Licence</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('candidate.verifications.driver-licence.store') }}" enctype="multipart/form-data" id="candidate_driver_licence_form">
                @csrf

                <div class="row g-6 mb-8">
                    <div class="col-lg-6">
                        <label for="candidate_front_image" class="form-label required">Front of Licence</label>
                        <label class="ak-upload-tile" for="candidate_front_image" data-upload-tile>
                            <input id="candidate_front_image" type="file" name="front_image" class="d-none" accept=".png,.jpg,.jpeg" required data-upload-input>
                            <span class="ak-upload-tile__icon">
                                <i class="bi bi-upload"></i>
                            </span>
                            <span class="ak-upload-tile__title">Click to upload front image</span>
                            <span class="ak-upload-tile__meta">PNG, JPG up to 10MB</span>
                            <span class="ak-upload-tile__filename" data-upload-filename>No file selected</span>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label for="candidate_back_image" class="form-label">Back of Licence <span class="text-muted">(Optional)</span></label>
                        <label class="ak-upload-tile" for="candidate_back_image" data-upload-tile>
                            <input id="candidate_back_image" type="file" name="back_image" class="d-none" accept=".png,.jpg,.jpeg" data-upload-input>
                            <span class="ak-upload-tile__icon">
                                <i class="bi bi-upload"></i>
                            </span>
                            <span class="ak-upload-tile__title">Click to upload back image</span>
                            <span class="ak-upload-tile__meta">PNG, JPG up to 10MB</span>
                            <span class="ak-upload-tile__filename" data-upload-filename>No file selected</span>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Verify Driver Licence</button>
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
                                <td>{{ str_replace('_', ' ', ucfirst($document->type)) }}</td>
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

@push('scripts')
    <script src="{{ asset('assets/js/custom/candidate-driver-licence.js') }}"></script>
@endpush
