@extends('layouts.app', [
    'title' => 'Recruitment Applications | Akhani Connect',
    'heading' => 'Candidate Applications',
    'subheading' => 'Review candidates linked to your active jobs.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Applications</h3>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Candidate</th>
                            <th>Job</th>
                            <th>Status</th>
                            <th>Documents</th>
                            <th>Applied</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($applications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ $application->candidate?->full_name ?? 'Candidate' }}</span>
                                        <span class="text-muted fs-7">{{ $application->candidate?->email }}</span>
                                    </div>
                                </td>
                                <td>{{ $application->job?->title ?? 'Unknown job' }}</td>
                                <td>
                                    <span class="badge badge-light-info">{{ ucfirst($application->status) }}</span>
                                </td>
                                <td>{{ $application->documents_count }}</td>
                                <td>{{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-muted">No applications received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
