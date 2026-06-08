@extends('layouts.app', [
    'title' => 'Recruitment Candidates | Akhani Connect',
    'heading' => 'Candidate Pipeline',
    'subheading' => 'Search and review candidates across your job applications.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-body">
            <form method="GET" action="{{ route('recruitment.candidates.index') }}">
                <div class="row g-5 align-items-end">
                    <div class="col-xl-5">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Candidate name, email, title, or job">
                    </div>
                    <div class="col-xl-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach (['submitted', 'reviewing', 'shortlisted', 'interviewed', 'rejected', 'hired'] as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2">
                        <label class="form-label">Job</label>
                        <select name="job_id" class="form-select">
                            <option value="">All jobs</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}" @selected((string) ($filters['job_id'] ?? '') === (string) $job->id)>{{ $job->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2">
                        <label class="form-label">Province</label>
                        <select name="province" class="form-select">
                            <option value="">All provinces</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province }}" @selected(($filters['province'] ?? '') === $province)>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-1">
                        <button type="submit" class="btn btn-primary w-100">Go</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Candidate</th>
                            <th>Current Title</th>
                            <th>Job</th>
                            <th>Province</th>
                            <th>Status</th>
                            <th>Documents</th>
                            <th>Applied</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($applications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ $application->candidate?->full_name }}</span>
                                        <span class="text-muted fs-7">{{ $application->candidate?->email }}</span>
                                    </div>
                                </td>
                                <td>{{ $application->candidate?->candidateProfile?->job_title ?? 'Not set' }}</td>
                                <td>{{ $application->job?->title ?? 'Unknown job' }}</td>
                                <td>{{ $application->candidate?->profile?->province ?? 'Not set' }}</td>
                                <td>
                                    <span class="badge badge-light-info">{{ ucfirst($application->status) }}</span>
                                </td>
                                <td>{{ $application->documents_count }} application / {{ $application->candidate?->documents?->where('category', 'candidate_profile')->count() ?? 0 }} profile</td>
                                <td>{{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('recruitment.applications.show', $application) }}" class="btn btn-sm btn-light-primary">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-muted">No candidates matched your filters.</td>
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
