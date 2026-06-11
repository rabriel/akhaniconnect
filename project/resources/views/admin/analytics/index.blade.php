@extends('layouts.app', [
    'title' => 'Analytics & Activity | Akhani Connect',
    'heading' => 'Analytics & Activity',
    'subheading' => 'Review user IP, country, browser, platform, and recent platform activity.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Tracked Activities</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $activitiesCount }}</div>
                    <div class="text-gray-400 mt-2">Authenticated actions captured across the platform.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Active Users</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $activeUsersCount }}</div>
                    <div class="text-gray-400 mt-2">Users with tracked activity records.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Unique IPs</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $uniqueIpsCount }}</div>
                    <div class="text-gray-400 mt-2">Distinct IP addresses seen in activity logs.</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted fw-semibold d-block fs-7">Login Events</div>
                    <div class="fs-2hx fw-bolder mt-2">{{ $loginCount }}</div>
                    <div class="text-gray-400 mt-2">Successful sign-ins recorded by the platform.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Top Browsers</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($topBrowsers as $item)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ $item['label'] }}</div>
                            <div class="badge badge-light-primary">{{ $item['aggregate'] }}</div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No browser activity recorded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Top Countries</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($topCountries as $item)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ $item['label'] }}</div>
                            <div class="badge badge-light-primary">{{ $item['aggregate'] }}</div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No country data recorded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Top Routes</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse ($topRoutes as $item)
                        <div class="d-flex flex-stack py-4 border-bottom border-gray-200">
                            <div class="fw-bold text-gray-900">{{ $item['label'] }}</div>
                            <div class="badge badge-light-primary">{{ $item['aggregate'] }}</div>
                        </div>
                    @empty
                        <div class="text-muted fs-6">No route activity recorded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Recent Activity</h3>
            </div>
        </div>
        <div class="card-body pt-0">
            @forelse ($recentActivities as $activity)
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4 py-4 border-bottom border-gray-200">
                    <div>
                        <div class="fw-bold text-gray-900">
                            {{ $activity->user?->full_name ?? 'Unknown User' }}
                            <span class="text-muted fs-7">({{ $activity->activity_type }})</span>
                        </div>
                        <div class="text-muted fs-7">
                            {{ $activity->browser ?? 'Unknown Browser' }} | {{ $activity->platform ?? 'Unknown Platform' }} | {{ $activity->country_name ?? 'Unknown' }}
                        </div>
                        <div class="text-muted fs-7">
                            {{ $activity->method }} {{ $activity->path ?: '/' }} | {{ $activity->ip_address ?? 'No IP captured' }}
                        </div>
                    </div>
                    <div class="text-muted fs-8">
                        {{ $activity->occurred_at?->format('d M Y H:i') }}
                    </div>
                </div>
            @empty
                <div class="text-muted fs-6">No activity captured yet.</div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3 class="fw-bold m-0">Activity Log</h3>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>User</th>
                            <th>Activity</th>
                            <th>IP</th>
                            <th>Country</th>
                            <th>Browser</th>
                            <th>Platform</th>
                            <th>Route</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($activities as $activity)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ $activity->user?->full_name ?? 'Unknown User' }}</span>
                                        <span class="text-muted fs-7">{{ $activity->user?->role?->name ?? 'No role' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light-primary">{{ str_replace('_', ' ', ucfirst($activity->activity_type)) }}</span>
                                </td>
                                <td>{{ $activity->ip_address ?? 'N/A' }}</td>
                                <td>{{ $activity->country_name ?? 'Unknown' }}</td>
                                <td>{{ $activity->browser ?? 'Unknown Browser' }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $activity->platform ?? 'Unknown Platform' }}</span>
                                        <span class="text-muted fs-7">{{ $activity->device_type ?? 'Unknown Device' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $activity->route_name ?? 'Unnamed route' }}</span>
                                        <span class="text-muted fs-7">{{ $activity->method }} {{ $activity->path }}</span>
                                    </div>
                                </td>
                                <td>{{ $activity->occurred_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-muted">No activity records found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
