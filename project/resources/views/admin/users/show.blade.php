@extends('layouts.app', [
    'title' => 'User Details | Akhani Connect',
    'heading' => $user->full_name,
    'subheading' => 'General account details for superadmin review.',
])

@section('content')
    <div class="card">
        <div class="card-body py-10">
            <div class="row g-6">
                <div class="col-md-6">
                    <div class="text-muted fs-7">Full Name</div>
                    <div class="fw-bold fs-5">{{ $user->full_name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted fs-7">Role</div>
                    <div class="fw-bold fs-5">{{ $user->role?->name ?? 'Unassigned' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted fs-7">Email Address</div>
                    <div class="fw-bold fs-5">{{ $user->email }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted fs-7">Phone</div>
                    <div class="fw-bold fs-5">{{ $user->phone }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted fs-7">Status</div>
                    <div class="fw-bold fs-5">{{ ucfirst($user->status) }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted fs-7">Joined</div>
                    <div class="fw-bold fs-5">{{ $user->created_at?->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
