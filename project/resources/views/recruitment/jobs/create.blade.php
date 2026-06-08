@extends('layouts.app', [
    'title' => 'Create Job | Akhani Connect',
    'heading' => 'Create Job Post',
    'subheading' => 'Publish a new vacancy for candidate applications.',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('recruitment.jobs.store') }}">
                @csrf

                <div class="row g-5">
                    <div class="col-md-8">
                        <label class="form-label required">Job Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                            <option value="published" @selected(old('status') === 'published')>Published</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Johannesburg">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Province</label>
                        <select name="province" class="form-select">
                            <option value="">Select province</option>
                            @foreach (config('south_africa.provinces', []) as $province)
                                <option value="{{ $province }}" @selected(old('province') === $province)>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employment Type</label>
                        <select name="employment_type" class="form-select">
                            <option value="">Select type</option>
                            <option value="Permanent" @selected(old('employment_type') === 'Permanent')>Permanent</option>
                            <option value="Contract" @selected(old('employment_type') === 'Contract')>Contract</option>
                            <option value="Temporary" @selected(old('employment_type') === 'Temporary')>Temporary</option>
                            <option value="Internship" @selected(old('employment_type') === 'Internship')>Internship</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label required">Description</label>
                        <textarea id="job_description_editor" name="description" rows="8" class="form-control">{{ old('description') }}</textarea>
                        <div class="form-text">Use the editor to format responsibilities, requirements, and role highlights.</div>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="btn btn-primary">Save job post</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#job_description_editor'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'link',
                    'blockQuote',
                    'insertTable',
                    '|',
                    'undo',
                    'redo',
                ],
            })
            .catch(function (error) {
                console.error(error);
            });
    </script>
@endpush
