@extends('layouts.app', [
    'title' => 'Recruitment Dashboard | Akhani Connect',
    'heading' => 'Recruitment Dashboard',
    'subheading' => 'Manage company setup, job posts, and incoming candidates.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted fw-semibold d-block fs-7">Company Profile</span>
                        <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $profileComplete ? 'Ready' : 'Pending' }}</span>
                        <p class="text-gray-600 fs-6 mt-4 mb-0">
                            {{ $profileComplete ? 'Recruiter company details are in place.' : 'Complete your company profile before scaling job activity.' }}
                        </p>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('recruitment.profile.edit') }}" class="btn btn-light-primary">Manage company profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Jobs Posted</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $jobsCount }}</span>
                    <div class="fs-6 text-gray-600 mt-4">Published jobs: <span class="fw-bold text-gray-800">{{ $publishedJobsCount }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Applications Received</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $applicationsCount }}</span>
                    <div class="mt-6">
                        <a href="{{ route('recruitment.applications.index') }}" class="btn btn-light-primary">Review applications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Recent Job Posts</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Your latest recruitment activity</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('recruitment.jobs.create') }}" class="btn btn-sm btn-light-primary">New job</a>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @forelse ($recentJobs as $job)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div>
                                <div class="fw-bold text-gray-900">{{ $job->title }}</div>
                                <div class="text-muted fs-7">{{ $job->location ?: 'Location not set' }} | {{ $job->status }}</div>
                            </div>
                            <div class="badge badge-light-{{ $job->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($job->status) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No jobs created yet. Start with your first vacancy.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Recent Applications</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Candidates linked to your jobs</span>
                    </h3>
                </div>
                <div class="card-body pt-3">
                    @forelse ($recentApplications as $application)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div>
                                <div class="fw-bold text-gray-900">{{ $application->candidate?->full_name ?? 'Candidate' }}</div>
                                <div class="text-muted fs-7">{{ $application->job?->title ?? 'Unknown job' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="badge badge-light-info">{{ ucfirst($application->status) }}</div>
                                <div class="text-muted fs-8 mt-1">{{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">Applications will appear here once candidates start applying.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
