@extends('layouts.app', [
    'title' => 'Client Dashboard | Akhani Connect',
    'heading' => 'Client Dashboard',
    'subheading' => 'Review procurement accounts, track verification progress, and follow up.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Procurement Users</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $procurementUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Verified</span>
                    <span class="fs-2hx fw-bold text-success d-block mt-2">{{ $verifiedUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">In Progress</span>
                    <span class="fs-2hx fw-bold text-warning d-block mt-2">{{ $inProgressUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Pending</span>
                    <span class="fs-2hx fw-bold text-gray-800 d-block mt-2">{{ $pendingUsersCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">Progress Distribution</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="client_progress_distribution_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">Verified Modules</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="client_module_coverage_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">Verification Activity</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="client_verification_activity_chart" class="h-300px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bolder m-0">Verification Summary</h3>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="accordion" id="client_dashboard_summary">
                        <div class="accordion-item border-0 mb-5 rounded overflow-hidden">
                            <h2 class="accordion-header" id="client_summary_overview_heading">
                                <button class="accordion-button bg-light-primary bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#client_summary_overview" aria-expanded="true" aria-controls="client_summary_overview">
                                    <span>Overview</span>
                                    <span class="badge badge-light-primary ms-4">{{ $verificationRecordsCount }} verification records</span>
                                </button>
                            </h2>
                            <div id="client_summary_overview" class="accordion-collapse collapse show" aria-labelledby="client_summary_overview_heading" data-bs-parent="#client_dashboard_summary">
                                <div class="accordion-body bg-white pt-6">
                                    <div class="row g-5">
                                        <div class="col-md-4">
                                            <div class="rounded border border-gray-200 bg-light-primary bg-opacity-25 p-4 h-100">
                                                <div class="text-muted fs-7 mb-1">Total Verification Records</div>
                                                <div class="fw-bold fs-3">{{ $verificationRecordsCount }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="rounded border border-gray-200 bg-light-success bg-opacity-25 p-4 h-100">
                                                <div class="text-muted fs-7 mb-1">Verified Directors</div>
                                                <div class="fw-bold fs-3">{{ $verifiedDirectorsCount }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="rounded border border-gray-200 bg-light-warning bg-opacity-25 p-4 h-100">
                                                <div class="text-muted fs-7 mb-1">Uploaded Documents</div>
                                                <div class="fw-bold fs-3">{{ $documentsCount }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-5 rounded overflow-hidden">
                            <h2 class="accordion-header" id="client_summary_modules_heading">
                                <button class="accordion-button collapsed bg-light-success bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#client_summary_modules" aria-expanded="false" aria-controls="client_summary_modules">
                                    <span>Verification Modules</span>
                                    <span class="badge badge-light-success ms-4">{{ $moduleBreakdown->where('verified', '>', 0)->count() }} active modules</span>
                                </button>
                            </h2>
                            <div id="client_summary_modules" class="accordion-collapse collapse" aria-labelledby="client_summary_modules_heading" data-bs-parent="#client_dashboard_summary">
                                <div class="accordion-body bg-white pt-6">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-4">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th>Module</th>
                                                    <th>Verified</th>
                                                    <th>Failed</th>
                                                    <th>Pending</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-700">
                                                @foreach ($moduleBreakdown as $module)
                                                    <tr>
                                                        <td>{{ $module['label'] }}</td>
                                                        <td><span class="badge badge-light-success">{{ $module['verified'] }}</span></td>
                                                        <td><span class="badge badge-light-danger">{{ $module['failed'] }}</span></td>
                                                        <td><span class="badge badge-light-warning">{{ $module['pending'] }}</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 rounded overflow-hidden">
                            <h2 class="accordion-header" id="client_summary_recent_heading">
                                <button class="accordion-button collapsed bg-light-info bg-opacity-50 text-dark fw-bold fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#client_summary_recent" aria-expanded="false" aria-controls="client_summary_recent">
                                    <span>Recent Procurement Activity</span>
                                    <span class="badge badge-light-info ms-4">{{ $recentlyVerifiedUsers->count() }} tracked users</span>
                                </button>
                            </h2>
                            <div id="client_summary_recent" class="accordion-collapse collapse" aria-labelledby="client_summary_recent_heading" data-bs-parent="#client_dashboard_summary">
                                <div class="accordion-body bg-white pt-6">
                                    @if ($recentlyVerifiedUsers->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-4">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        <th>User</th>
                                                        <th>Progress</th>
                                                        <th>Verified Modules</th>
                                                        <th>Directors</th>
                                                        <th>Documents</th>
                                                        <th>Last Verified</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-700">
                                                    @foreach ($recentlyVerifiedUsers as $record)
                                                        <tr>
                                                            <td>
                                                                <div class="fw-bold">{{ $record['name'] }}</div>
                                                                <div class="text-muted fs-7">{{ $record['company'] }}</div>
                                                            </td>
                                                            <td><span class="badge badge-light-primary">{{ $record['progress'] }}%</span></td>
                                                            <td>{{ $record['verified_modules'] }}</td>
                                                            <td>{{ $record['directors_verified'] }}</td>
                                                            <td>{{ $record['documents_uploaded'] }}</td>
                                                            <td>{{ $record['last_verified_at']?->format('d M Y H:i') ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="rounded border border-dashed border-gray-300 bg-light-info bg-opacity-10 px-5 py-4">
                                            <div class="fw-bold mb-1">No procurement activity available yet</div>
                                            <div class="text-muted fs-7">Procurement verification activity will appear here once users begin completing their onboarding.</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="mb-2">Client review workspace</h3>
                        <p class="text-gray-600 fs-6 mb-0">Search procurement users, inspect verification records, and send follow-up messages from a single place.</p>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('client.procurement-records.index') }}" class="btn btn-primary w-100">Open procurement records</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.clientDashboardCharts = @json($charts);
    </script>
    <script src="{{ asset('assets/js/custom/client-dashboard.js') }}"></script>
@endpush
