@extends('layouts.app', [
    'title' => 'Verification History | Akhani Connect',
    'heading' => 'Verification History',
    'subheading' => 'Review your verification modules and retry saved workflows where supported.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Saved Verification Records</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Module</th>
                            <th>Status</th>
                            <th>Provider</th>
                            <th>Last Verified</th>
                            <th>Attempts</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ str_replace('_', ' ', ucfirst($record->module)) }}</td>
                                <td>{{ ucfirst($record->status) }}</td>
                                <td>{{ ucfirst($record->provider) }}</td>
                                <td>{{ $record->last_verified_at?->format('Y-m-d H:i') ?: 'Never' }}</td>
                                <td>{{ $record->attempts->count() }}</td>
                                <td>
                                    <a href="{{ route('procurement.verifications.show', $record) }}" class="btn btn-sm btn-light-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">No verification history available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
