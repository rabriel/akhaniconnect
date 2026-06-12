<div class="row g-5">
    <div class="col-md-8">
        <label class="form-label required">Job Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label required">Status</label>
        <select name="status" class="form-select" required>
            <option value="draft" @selected(old('status', $job->status) === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $job->status) === 'published')>Published</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}" placeholder="Johannesburg">
    </div>
    <div class="col-md-6">
        <label class="form-label">Province</label>
        <select name="province" class="form-select">
            <option value="">Select province</option>
            @foreach (config('south_africa.provinces', []) as $province)
                <option value="{{ $province }}" @selected(old('province', $job->province) === $province)>{{ $province }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Employment Type</label>
        <select name="employment_type" class="form-select">
            <option value="">Select type</option>
            <option value="Permanent" @selected(old('employment_type', $job->employment_type) === 'Permanent')>Permanent</option>
            <option value="Contract" @selected(old('employment_type', $job->employment_type) === 'Contract')>Contract</option>
            <option value="Temporary" @selected(old('employment_type', $job->employment_type) === 'Temporary')>Temporary</option>
            <option value="Internship" @selected(old('employment_type', $job->employment_type) === 'Internship')>Internship</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label {{ old('status', $job->status) === 'published' ? 'required' : '' }}">Published Date</label>
        <input
            type="date"
            name="published_at"
            class="form-control"
            value="{{ old('published_at', $job->published_at?->format('Y-m-d')) }}"
        >
        <div class="form-text">Choose when this vacancy should appear as published.</div>
    </div>
    <div class="col-12">
        <label class="form-label required">Description</label>
        <textarea id="job_description_editor" name="description" rows="8" class="form-control">{{ old('description', $job->description) }}</textarea>
        <div class="form-text">Use the editor to format responsibilities, requirements, and role highlights.</div>
    </div>
</div>

<div class="mt-10 d-flex flex-wrap gap-3">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('recruitment.jobs.index') }}" class="btn btn-light">Cancel</a>
</div>
