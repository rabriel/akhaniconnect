@extends('layouts.app', [
    'title' => 'Enterprise Directors | Akhani Connect',
    'heading' => 'Enterprise Directors',
    'subheading' => 'Use a director ID number to verify and refresh director data from the API.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Add Director ID Number</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <form method="POST" action="{{ route('procurement.directors.store') }}">
                @csrf

                <div class="row mb-6">
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">ID number</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="id_number" value="{{ old('id_number') }}" required>
                    </div>
                    <div class="col-lg-6 fv-row">
                        <label class="form-label fs-6 fw-bold mb-3">Director name</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" value="Pulled from API after verification" disabled>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Director ID Number</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Saved Directors</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>ID Number</th>
                            <th>Director Name</th>
                            <th>Director Status</th>
                            <th>Status</th>
                            <th>Saved</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($directors as $director)
                            <tr>
                                <td>{{ $director->id_number }}</td>
                                <td>{{ $director->full_name ?: 'Not synced yet' }}</td>

                                <td>{{ $director->director_status ?: 'Not synced yet' }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $director->status === 'verified' ? 'success' : ($director->status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($director->status) }}
                                    </span>
                                </td>

                                <td>{{ $director->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('procurement.directors.show', $director) }}" class="btn btn-sm btn-light-primary">View</a>
                                        <form method="POST" action="{{ route('procurement.directors.verify', $director) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-light-primary">{{ $director->status === 'verified' ? 'Re-verify' : 'Verify' }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10">No directors have been added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
