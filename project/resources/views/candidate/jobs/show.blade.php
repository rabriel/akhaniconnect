@extends('layouts.app', [
    'title' => 'Job Details | Akhani Connect',
    'heading' => $job->title,
    'subheading' => ($job->user?->recruitmentProfile?->company_name ?? 'Recruiter not set') . ' | ' . collect([$job->location ?: 'Location not set', $job->province])->filter()->implode(', '),
])

@section('content')
    <div class="row g-5 g-xl-8">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-6">
                        <span class="badge badge-light-success">{{ $job->employment_type ?: 'Open role' }}</span>
                    </div>
                    <div class="text-gray-800 fs-6">{!! $job->description !!}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="mb-5">Application</h3>

                    @if ($hasApplied)
                        <div class="alert alert-info">You have already applied for this position.</div>
                        <a href="{{ route('candidate.applications.index') }}" class="btn btn-light-primary">View my applications</a>
                    @else
                        <form method="POST" action="{{ route('candidate.applications.store', $job) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-5">
                                <label class="form-label">Cover Letter</label>
                                <textarea name="cover_letter" rows="8" class="form-control" placeholder="Introduce your fit for this role...">{{ old('cover_letter') }}</textarea>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">CV Document</label>
                                <input type="file" name="cv_document" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-text">Upload a CV in PDF or Word format.</div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Supporting Documents</label>
                                <input type="file" name="supporting_documents[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                <div class="form-text">Optional certificates, references, or supporting files.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply now</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
