@extends('layouts.app', [
    'title' => 'Clients | Akhani Connect',
    'heading' => 'Client Management',
    'subheading' => 'Manage client accounts created by superadmin.',
])

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Client Accounts</h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Client
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Contact</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Scope</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse ($clients as $client)
                            <tr>
                                <td>{{ $client->full_name }}</td>
                                <td>{{ $client->clientProfile?->company_name ?? 'Not set' }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->clientProfile?->access_scope ?? 'General' }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $client->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10">No client accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection
