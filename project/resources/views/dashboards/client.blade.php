@extends('layouts.app', [
    'title' => 'Client Dashboard | Akhani Connect',
    'heading' => 'Client Dashboard',
    'subheading' => 'Review procurement accounts, track verification progress, and follow up.',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Procurement Users</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $procurementUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Verified</span>
                    <span class="fs-2hx fw-bold text-success d-block mt-2">{{ $verifiedUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">In Progress</span>
                    <span class="fs-2hx fw-bold text-warning d-block mt-2">{{ $inProgressUsersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Pending</span>
                    <span class="fs-2hx fw-bold text-gray-800 d-block mt-2">{{ $pendingUsersCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div>
                <h3 class="mb-2">Client review workspace</h3>
                <p class="text-gray-600 fs-6 mb-0">Search procurement users, inspect verification records, and send follow-up messages from a single place.</p>
            </div>
            <div class="mt-5 mt-md-0">
                <a href="{{ route('client.procurement-records.index') }}" class="btn btn-primary">Open procurement records</a>
            </div>
        </div>
    </div>
@endsection
