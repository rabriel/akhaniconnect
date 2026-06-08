@extends('layouts.app', [
    'title' => 'Procurement Records | Akhani Connect',
    'heading' => 'Procurement Records',
    'subheading' => 'Search procurement users and filter verification readiness.',
])

@section('content')
    <div class="card mb-8">
        <div class="card-body">
            <form method="GET" action="{{ route('client.procurement-records.index') }}">
                <div class="row g-5 align-items-end">
                    <div class="col-xl-5">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Name, email, company, registration number">
                    </div>
                    <div class="col-xl-3">
                        <label class="form-label">Progress</label>
                        <select name="progress" class="form-select">
                            <option value="">All progress states</option>
                            <option value="pending" @selected(($filters['progress'] ?? '') === 'pending')>Pending</option>
                            <option value="in_progress" @selected(($filters['progress'] ?? '') === 'in_progress')>In progress</option>
                            <option value="verified" @selected(($filters['progress'] ?? '') === 'verified')>Verified</option>
                        </select>
                    </div>
                    <div class="col-xl-3">
                        <label class="form-label">Verified Module</label>
                        <select name="module" class="form-select">
                            <option value="">Any module</option>
                            <option value="driver_licence" @selected(($filters['module'] ?? '') === 'driver_licence')>Driver licence</option>
                            <option value="bank_account" @selected(($filters['module'] ?? '') === 'bank_account')>Bank account</option>
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
                            <th>Procurement User</th>
                            <th>Company</th>
                            <th>Progress</th>
                            <th>Verified Modules</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($records as $record)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ $record->full_name }}</span>
                                        <span class="text-muted fs-7">{{ $record->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $record->procurementProfile?->company_name ?? 'Not set' }}</span>
                                        <span class="text-muted fs-7">{{ $record->procurementProfile?->registration_number ?? 'No registration number' }}</span>
                                    </div>
                                </td>
                                <td>{{ $record->procurementProfile?->verification_progress ?? 0 }}%</td>
                                <td>{{ $record->verificationRecords->where('status', 'verified')->count() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('client.procurement-records.show', $record) }}" class="btn btn-sm btn-light-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-muted">No procurement records matched your search.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $records->links() }}
            </div>
        </div>
    </div>
@endsection
