@extends('layouts.app', [
    'title' => 'Candidate Jobs | Akhani Connect',
    'heading' => 'Published Jobs',
    'subheading' => 'Browse active opportunities from Akhani Connect recruiters.',
])

@section('content')
    <div class="row g-5">
        @forelse ($jobs as $job)
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h3 class="mb-1">{{ $job->title }}</h3>
                                <div class="text-muted fs-7">
                                    {{ $job->user?->recruitmentProfile?->company_name ?? 'Recruiter not set' }}
                                </div>
                            </div>
                            <span class="badge badge-light-success">{{ $job->employment_type ?: 'Open role' }}</span>
                        </div>

                        <div class="text-gray-700 fs-6 mb-5">
                            {{ \Illuminate\Support\Str::of(strip_tags($job->description))->squish()->limit(180) }}
                        </div>

                        <div class="text-muted fs-7 mb-5">
                            {{ $job->location ?: 'Location not set' }}
                            @if ($job->province)
                                | {{ $job->province }}
                            @endif
                            @if ($job->published_at)
                                | Published {{ $job->published_at->format('d M Y') }}
                            @endif
                        </div>

                        <a href="{{ route('candidate.jobs.show', $job) }}" class="btn btn-light-primary">View details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-muted fs-6">
                        No published jobs are available yet.
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
@endsection
