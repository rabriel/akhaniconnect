@extends('layouts.app', [
    'title' => 'Verification Logs | Akhani Connect',
    'heading' => 'Verification Logs',
    'subheading' => 'Review procurement verification activity across the platform.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>All Verification Records</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>User</th>
                            <th>Role</th>
                            <th>Module</th>
                            <th>Status</th>
                            <th>Last Verified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record->user?->full_name }}</td>
                                <td>{{ $record->user?->role?->name }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($record->module)) }}</td>
                                <td>{{ ucfirst($record->status) }}</td>
                                <td>{{ $record->last_verified_at?->format('Y-m-d H:i') ?: 'Never' }}</td>
                                <td><a href="{{ route('admin.verifications.show', $record) }}" class="btn btn-sm btn-light-primary">View</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">No verification records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $records->links() }}
            </div>
        </div>
    </div>
@endsection
