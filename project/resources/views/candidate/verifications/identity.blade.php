@extends('layouts.app', [
    'title' => 'Candidate SA ID Verification | Akhani Connect',
    'heading' => 'SA ID Verification',
    'subheading' => 'Verify your South African ID before accessing the candidate workspace.',
])

@section('content')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.identity-verification.store') }}">
                        @csrf
                        <div class="mb-5">
                            <label class="form-label required">South African ID Number</label>
                            <input type="text" name="id_number" class="form-control" value="{{ old('id_number', $user->profile?->id_number) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit verification</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="mb-5">Current Status</h3>
                    <div class="badge badge-light-{{ $record?->status === 'verified' ? 'success' : ($record?->status === 'failed' ? 'danger' : 'warning') }}">
                        {{ ucfirst($record?->status ?? 'pending') }}
                    </div>
                    <div class="text-muted fs-7 mt-4">Reference: {{ $record?->provider_reference ?? 'N/A' }}</div>
                    <div class="text-muted fs-7 mt-2">Last checked: {{ $record?->last_verified_at?->format('d M Y H:i') ?? 'Not yet submitted' }}</div>
                    @if ($record?->last_error)
                        <div class="alert alert-danger mt-5">{{ $record->last_error }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
