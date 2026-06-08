@extends('layouts.app', [
    'title' => 'Candidate Profile | Akhani Connect',
    'heading' => 'Candidate Profile',
    'subheading' => 'Keep your candidate details current before applying for jobs.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('candidate.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-5 mb-8">
                    <div class="col-md-6">
                        <label class="form-label required">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Surname</label>
                        <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->profile?->city) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Province</label>
                        <select name="province" class="form-select">
                            <option value="">Select province</option>
                            @foreach (config('south_africa.provinces', []) as $province)
                                <option value="{{ $province }}" @selected(old('province', $user->profile?->province) === $province)>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="separator separator-dashed my-10"></div>

                <div class="row g-5">
                    <div class="col-md-6">
                        <label class="form-label">Current Job Title</label>
                        <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $user->candidateProfile?->job_title) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Experience Level</label>
                        <input type="text" name="experience_level" class="form-control" value="{{ old('experience_level', $user->candidateProfile?->experience_level) }}" placeholder="Mid-level">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employment Status</label>
                        <input type="text" name="employment_status" class="form-control" value="{{ old('employment_status', $user->candidateProfile?->employment_status) }}" placeholder="Available immediately">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Notice Period</label>
                        <select name="notice_period" class="form-select">
                            <option value="">Select notice period</option>
                            @foreach (config('south_africa.notice_periods', []) as $noticePeriod)
                                <option value="{{ $noticePeriod }}" @selected(old('notice_period', $user->candidateProfile?->notice_period) === $noticePeriod)>{{ $noticePeriod }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Relocation</label>
                        <select name="willing_to_relocate" class="form-select">
                            <option value="">Select option</option>
                            <option value="1" @selected((string) old('willing_to_relocate', $user->candidateProfile?->willing_to_relocate) === '1')>Yes</option>
                            <option value="0" @selected((string) old('willing_to_relocate', $user->candidateProfile?->willing_to_relocate) === '0')>No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Job Industry</label>
                        <select name="job_industry" class="form-select">
                            <option value="">Select industry</option>
                            @foreach (config('south_africa.job_industries', []) as $industry)
                                <option value="{{ $industry }}" @selected(old('job_industry', $user->candidateProfile?->job_industry) === $industry)>{{ $industry }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employment Type</label>
                        <select name="preferred_employment_type" class="form-select">
                            <option value="">Select employment type</option>
                            @foreach (config('south_africa.employment_types', []) as $employmentType)
                                <option value="{{ $employmentType }}" @selected(old('preferred_employment_type', $user->candidateProfile?->preferred_employment_type) === $employmentType)>{{ $employmentType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Salary Expectation</label>
                        <input type="text" name="salary_expectation" class="form-control" value="{{ old('salary_expectation', $user->candidateProfile?->salary_expectation) }}" placeholder="R25 000 per month">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Highest Education Level</label>
                        <select name="education_level" class="form-select">
                            <option value="">Select education level</option>
                            @foreach (config('south_africa.education_levels', []) as $educationLevel)
                                <option value="{{ $educationLevel }}" @selected(old('education_level', $user->candidateProfile?->education_level) === $educationLevel)>{{ $educationLevel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Education</label>
                        <textarea name="education" rows="4" class="form-control" placeholder="List your schools, institutions, and qualifications...">{{ old('education', $user->candidateProfile?->education) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Certifications</label>
                        <textarea name="certifications" rows="4" class="form-control" placeholder="List relevant certificates, licences, or specialist training...">{{ old('certifications', $user->candidateProfile?->certifications) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Experience</label>
                        <textarea name="experience" rows="5" class="form-control" placeholder="Summarise your work history and role responsibilities...">{{ old('experience', $user->candidateProfile?->experience) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Skills</label>
                        <textarea name="skills" rows="4" class="form-control" placeholder="Add core skills, systems, and tools you are confident using...">{{ old('skills', $user->candidateProfile?->skills) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Professional Summary</label>
                        <textarea name="bio" rows="6" class="form-control">{{ old('bio', $user->candidateProfile?->bio) }}</textarea>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 mt-10">
                    <div class="text-muted fs-7">
                        Keep your profile and documents current so recruiters can review your experience in one place.
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('candidate.documents.index') }}" class="btn btn-light-primary">Manage documents</a>
                        <button type="submit" class="btn btn-primary">Save candidate profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
