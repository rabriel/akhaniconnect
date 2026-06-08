@extends('layouts.app', [
    'title' => 'Verification Details | Akhani Connect',
    'heading' => 'Verification Details',
    'subheading' => 'Review request and response history for a verification module.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>{{ $verificationRecord->user?->full_name }} | {{ str_replace('_', ' ', ucfirst($verificationRecord->module)) }}</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="mb-3"><strong>Status:</strong> {{ ucfirst($verificationRecord->status) }}</div>
            <div class="mb-3"><strong>Provider:</strong> {{ ucfirst($verificationRecord->provider) }}</div>
            <div class="mb-3"><strong>Reference:</strong> {{ $verificationRecord->provider_reference ?: 'N/A' }}</div>
            <div class="mb-3"><strong>Last Error:</strong> {{ $verificationRecord->last_error ?: 'None' }}</div>
            @if ($verificationRecord->summary)
                <div class="mb-3">
                    <strong>Summary</strong>
                    <pre class="bg-light p-4 rounded">{{ json_encode($verificationRecord->summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            @endif
            @if ($verificationRecord->user?->hasRole('procurement'))
                <div class="mt-5">
                    <a href="{{ route('admin.procurement-reports.show', $verificationRecord->user) }}" class="btn btn-light-primary">Download procurement report</a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Attempt History</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="accordion accordion-flush" id="admin_verification_attempts">
                @forelse ($verificationRecord->attempts->sortByDesc('attempted_at') as $attempt)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="admin_heading_{{ $attempt->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#admin_collapse_{{ $attempt->id }}">
                                {{ ucfirst($attempt->status) }} | {{ $attempt->attempted_at?->format('Y-m-d H:i') ?: 'Pending' }}
                            </button>
                        </h2>
                        <div id="admin_collapse_{{ $attempt->id }}" class="accordion-collapse collapse" data-bs-parent="#admin_verification_attempts">
                            <div class="accordion-body">
                                <div class="mb-3"><strong>Reference:</strong> {{ $attempt->provider_reference ?: 'N/A' }}</div>
                                <div class="mb-3"><strong>Error:</strong> {{ $attempt->error_message ?: 'None' }}</div>
                                <div class="mb-3">
                                    <strong>Request Payload</strong>
                                    <pre class="bg-light p-4 rounded">{{ json_encode($attempt->request_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                </div>
                                <div class="mb-3">
                                    <strong>Processed Response</strong>
                                    <pre class="bg-light p-4 rounded">{{ json_encode($attempt->processed_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">No verification attempts recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
