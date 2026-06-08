@extends('layouts.app', [
    'title' => 'Candidate Dashboard | Akhani Connect',
    'heading' => 'Candidate Dashboard',
    'subheading' => 'Track your profile, explore vacancies, and manage applications.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-muted fw-semibold d-block fs-7">Candidate Profile</span>
                        <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $profileComplete ? 'Ready' : 'Pending' }}</span>
                        <p class="text-gray-600 fs-6 mt-4 mb-0">
                            {{ $profileComplete ? 'Your candidate profile is ready for applications.' : 'Complete your candidate profile to present yourself well to recruiters.' }}
                        </p>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('candidate.profile.edit') }}" class="btn btn-light-primary">Manage profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Applications Submitted</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $applicationsCount }}</span>
                    <div class="fs-6 text-gray-600 mt-4">Still under review: <span class="fw-bold text-gray-800">{{ $submittedApplicationsCount }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Published Jobs</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $publishedJobsCount }}</span>
                    <div class="mt-6">
                        <a href="{{ route('candidate.jobs.index') }}" class="btn btn-light-primary">Browse jobs</a>
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
                        <span class="card-label fw-bold text-dark">Recent Applications</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Track where you have already applied</span>
                    </h3>
                </div>
                <div class="card-body pt-3">
                    @forelse ($recentApplications as $application)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div>
                                <div class="fw-bold text-gray-900">{{ $application->job?->title ?? 'Unknown job' }}</div>
                                <div class="text-muted fs-7">
                                    {{ $application->job?->user?->recruitmentProfile?->company_name ?? 'Recruiter not set' }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="badge badge-light-info">{{ ucfirst($application->status) }}</div>
                                <div class="text-muted fs-8 mt-1">{{ optional($application->applied_at ?? $application->created_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">You have not applied for any jobs yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Latest Vacancies</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Published opportunities from recruiters</span>
                    </h3>
                </div>
                <div class="card-body pt-3">
                    @forelse ($availableJobs as $job)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div>
                                <div class="fw-bold text-gray-900">{{ $job->title }}</div>
                                <div class="text-muted fs-7">
                                    {{ $job->user?->recruitmentProfile?->company_name ?? 'Recruiter not set' }} | {{ $job->location ?: 'Location not set' }}
                                </div>
                            </div>
                            <a href="{{ route('candidate.jobs.show', $job) }}" class="btn btn-sm btn-light-primary">View</a>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No published jobs are available yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
