@extends('layouts.app', [
    'title' => 'Admin Reports | Akhani Connect',
    'heading' => 'Reports',
    'subheading' => 'Track role distribution and verification activity across the platform.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Role Counts</h3></div>
                </div>
                <div class="card-body pt-0">
                    @foreach ($roleCounts as $roleName => $aggregate)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ $roleName }}</div>
                            <div class="badge badge-light-primary">{{ $aggregate }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Verification Modules</h3></div>
                </div>
                <div class="card-body pt-0">
                    @foreach ($moduleCounts as $module => $aggregate)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ str_replace('_', ' ', ucfirst($module)) }}</div>
                            <div class="badge badge-light-info">{{ $aggregate }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title"><h3 class="fw-bold m-0">Verification Status</h3></div>
                </div>
                <div class="card-body pt-0">
                    @foreach ($statusCounts as $status => $aggregate)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ ucfirst($status) }}</div>
                            <div class="badge badge-light-warning">{{ $aggregate }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title"><h3 class="fw-bold m-0">Recent Verification Activity</h3></div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>User</th>
                            <th>Module</th>
                            <th>Status</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @foreach ($recentVerifications as $verification)
                            <tr>
                                <td>{{ $verification->user?->full_name }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($verification->module)) }}</td>
                                <td>{{ ucfirst($verification->status) }}</td>
                                <td>{{ $verification->updated_at?->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
