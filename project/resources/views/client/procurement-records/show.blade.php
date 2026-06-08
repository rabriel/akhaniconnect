@extends('layouts.app', [
    'title' => 'Procurement Record | Akhani Connect',
    'heading' => $user->full_name,
    'subheading' => ($user->procurementProfile?->company_name ?? 'Procurement account') . ' | Verification review',
])

@section('content')
    <div class="row g-5 g-xl-8 mb-8">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Verification Progress</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $user->procurementProfile?->verification_progress ?? 0 }}%</span>
                    <div class="text-muted fs-7 mt-3">Proof of address: {{ $proofOfAddressUploaded ? 'Uploaded' : 'Missing' }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Verified Modules</span>
                    <span class="fs-2hx fw-bold text-success d-block mt-2">{{ $verifiedModules->count() }}</span>
                    <div class="text-muted fs-7 mt-3">{{ $verifiedModules->implode(', ') ?: 'No verified modules yet' }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="text-muted fw-semibold d-block fs-7">Enterprise Directors</span>
                    <span class="fs-2hx fw-bold text-dark d-block mt-2">{{ $user->procurementProfile?->directors?->count() ?? 0 }}</span>
                    <div class="mt-5">
                        <a href="{{ route('client.procurement-records.report', $user) }}" class="btn btn-light-primary btn-sm">Download report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-8">
        <div class="col-xl-7">
            <div class="card mb-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Profile Summary</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Email</div>
                            <div class="fw-bold">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Phone</div>
                            <div class="fw-bold">{{ $user->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Company</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->company_name ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Registration Number</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->registration_number ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">VAT Number</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->vat_number ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Company Phone</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->company_phone ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Enterprise Status</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->enterprise_status ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted fs-7">Enterprise Type</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->enterprise_type ?? 'Not set' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted fs-7">Registered Address</div>
                            <div class="fw-bold">{{ $user->procurementProfile?->enterprise_address ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Verification Records</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>Module</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th>Last Verified</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse ($user->verificationRecords as $verificationRecord)
                                    <tr>
                                        <td>{{ str_replace('_', ' ', ucfirst($verificationRecord->module)) }}</td>
                                        <td>
                                            <span class="badge badge-light-{{ $verificationRecord->status === 'verified' ? 'success' : ($verificationRecord->status === 'failed' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($verificationRecord->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $verificationRecord->provider_reference ?? 'N/A' }}</td>
                                        <td>{{ $verificationRecord->last_verified_at?->format('d M Y H:i') ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-muted">No verification records captured yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-8">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">CIPC Verification Summary</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-6">
                        <div class="text-muted fs-7">Enterprise Match</div>
                        <div class="fw-bold">{{ $enterpriseRecord?->summary['company_name'] ?? 'Not verified yet' }}</div>
                        <div class="text-muted fs-7">Status: {{ $enterpriseRecord?->summary['status'] ?? 'Pending' }}</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>Director</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th>Companies Found</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse ($user->procurementProfile?->directors ?? [] as $director)
                                    <tr>
                                        <td>{{ $director->full_name ?: 'Not synced yet' }}</td>
                                        <td>{{ ucfirst($director->status) }}</td>
                                        <td>{{ $director->provider_reference ?? 'N/A' }}</td>
                                        <td>{{ $director->verification_summary['companies_count'] ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-muted">No director verifications captured yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Send Follow-up</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('client.procurement-records.notify', $user) }}">
                        @csrf
                        <div class="mb-5">
                            <label class="form-label required">Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                        </div>
                        <div class="mb-5">
                            <label class="form-label required">Message</label>
                            <textarea name="message" rows="8" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
