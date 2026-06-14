@extends('layouts.app', [
    'title' => 'Superadmin Dashboard | Akhani Connect',
    'heading' => 'Superadmin Dashboard',
    'subheading' => 'Manage platform operations, users, clients, and reporting.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Users</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $usersCount }}</div>
                    <div class="text-gray-400 mt-2">Total registered accounts across the platform.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Clients</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $clientsCount }}</div>
                    <div class="text-gray-400 mt-2">Client accounts currently managed by superadmin.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Open Verifications</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $openVerificationsCount }}</div>
                    <div class="text-gray-400 mt-2">Verification records still pending attention or failed.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">User Role Distribution</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="admin_role_distribution_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Verification Status Mix</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="admin_verification_status_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Platform Activity Trend</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="admin_platform_activity_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Recent Users</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($recentUsers as $user)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div>
                                <div class="fw-bold text-gray-900">{{ $user->full_name }}</div>
                                <div class="text-muted fs-7">{{ $user->role?->name ?? 'Unassigned' }} | {{ $user->email }}</div>
                            </div>
                            <div class="text-muted fs-8">{{ $user->created_at?->format('d M Y') }}</div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No recent users found.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Verification Status Breakdown</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($verificationBreakdown as $status => $aggregate)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ ucfirst($status) }}</div>
                            <div class="badge badge-light-primary">{{ $aggregate }}</div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No verification records found yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.adminDashboardCharts = @json($charts);
    </script>
    <script src="{{ asset('assets/js/custom/admin-dashboard.js') }}"></script>
@endpush
