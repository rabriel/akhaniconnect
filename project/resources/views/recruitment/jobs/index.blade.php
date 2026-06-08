@extends('layouts.app', [
    'title' => 'Recruitment Jobs | Akhani Connect',
    'heading' => 'Job Posts',
    'subheading' => 'Create and monitor recruitment vacancies.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Recruiter Jobs</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('recruitment.jobs.create') }}" class="btn btn-primary">Create job</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Title</th>
                            <th>Location</th>
                            <th>Province</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Published</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->location ?: 'Not set' }}</td>
                                <td>{{ $job->province ?: 'Not set' }}</td>
                                <td>{{ $job->employment_type ?: 'Not set' }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $job->status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td>{{ $job->published_at?->format('d M Y') ?? 'Draft' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-muted">No jobs created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
@endsection
