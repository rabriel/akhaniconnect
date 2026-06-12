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
                            <th class="text-end">Action</th>
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
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('recruitment.jobs.edit', $job) }}" class="btn btn-sm btn-light-primary">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('recruitment.jobs.destroy', $job) }}" class="js-job-delete-form" data-job-title="{{ $job->title }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-muted">No jobs created yet.</td>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-job-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    const jobTitle = form.dataset.jobTitle || 'this job post';
                    const confirmed = window.confirm('Delete "' + jobTitle + '"? This will also remove linked applications.');

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush
