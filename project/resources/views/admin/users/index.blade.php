@extends('layouts.app', [
    'title' => 'Users | Akhani Connect',
    'heading' => 'User Management',
    'subheading' => 'Review registered users, roles, and account status.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Registered Users</h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add User
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($users as $user)
                            @php
                                $roleSlug = $user->role?->slug;
                                $roleBadgeClass = match ($roleSlug) {
                                    'superadmin' => 'ak-role-pill--superadmin',
                                    'candidate' => 'ak-role-pill--candidate',
                                    'recruitment' => 'ak-role-pill--recruitment',
                                    'procurement' => 'ak-role-pill--procurement',
                                    'client' => 'ak-role-pill--client',
                                    default => 'ak-role-pill--default',
                                };
                            @endphp
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge ak-role-pill {{ $roleBadgeClass }}">
                                        {{ $user->role?->name ?? 'Unassigned' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-light-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-light-primary">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
